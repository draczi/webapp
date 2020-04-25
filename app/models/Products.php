<?php
namespace App\Models;
use Core\Model;
use Core\Validators\{RequiredValidator,NumericValidator, NumMinValidator};
use Core\H;
use Core\Emails;

class Products extends Model {

    public $id, $product_name, $description, $vendor, $category, $action_end, $quantity, $auction_time;
    public $status = 1, $sold = 0, $created_date, $update_date, $price, $bid_increment , $deleted= 0;
    const blackList = ['id','deleted', 'status', 'sold'];
    protected static $_table = "products";
    protected static $_softDelete = true;

    public function beforeSave() {
        $this->timeStamps();
    }

    public function validator() {
        $requiredFields = ['product_name' => "Terméknév", 'price' => "Termék ára", 'quantity' => "Termék mennyisége", 'description' => "Termékleírás"];
        foreach($requiredFields as $field => $display) {
            $this->runValidation(new RequiredValidator($this, ['field' => $field, 'msg' => $display." nincs kitöltve."]));
        }
        $this->runValidation(new NumericValidator($this, ['field' => 'price', 'msg' => 'A termék árát kérem számokban adja meg.']));
        $this->runValidation(new NumericValidator($this, ['field' => 'quantity', 'msg' => 'Termék mennyiségét számokban adja meg.']));
        $this->runValidation(new NumMinValidator($this, ['field' => 'category', 'rule' => 1, 'msg' => 'Kérem válasszom egy kategóriát.']));

    }

    public static function findByUserIdAndImages($user_id) {
        $db = self::getDb();
        $sql = "SELECT products.*, product_images.url as url FROM products JOIN product_images ON products.id = product_images.product_id WHERE product_images.sort = 0 AND products.deleted = 0 AND products.status = 1 AND  products.vendor = " .$user_id;
        return $db->query($sql)->results();
    }

    public static function findByIdAndUserId($id, $user_id) {
        $conditions = [
            'conditions' => "id = ? AND vendor = ?",
            'bind' => [(int)$id, (int)$user_id]
        ];
        return self::findFirst($conditions);
    }

    public static function findByCategory($category) {
        $conditions = [
            'conditions' => "category = ?",
            'bind' => [$category]
        ];
        return self::findFirst($conditions);
    }

    public static function getOptionVendor() {
        $db = self::getDb();
        $vendors = $db->query("SELECT DISTINCT vendor, username FROM products LEFT JOIN users ON users.id = products.vendor")->results();
        $vendorsAry = ['0' =>' Összes felhasználó'];
        foreach($vendors as $vendor) {
            $vendorsAry[$vendor->vendor] = $vendor->username;
        }
        return $vendorsAry;
    }

    public static function allProducts($options, $admin = false) {
        $db = self::getDb();
        $limit = (array_key_exists('limit', $options) && !empty($options['limit'])) ? $options['limit'] : 4;
        $offset = (array_key_exists('offset',$options) && !empty($options['offset']))? $options['offset'] : 0;
        $where = "products.status = 1 AND products.deleted = 0 AND pi.sort = '0'";
        if($admin) $where = "pi.sort = '0'";
        $binds = [];
        if(array_key_exists('search',$options) && !empty($options['search'])) {
            $where .= " AND (products.product_name LIKE ? OR categories.category_name LIKE ?)";
            $binds[] = "%" . $options['search'] . "%";
            $binds[] = "%" . $options['search'] . "%";
        }
        if(array_key_exists('max_price',$options) && !empty($options['max_price'])) {
            $where .= " AND products.price <= ?";
            $binds[] = $options['max_price'];
        }
        if(array_key_exists('min_price',$options) && !empty($options['min_price'])) {
            $where .= " AND products.price >= ?";
            $binds[] = $options['min_price'];
        }
        if(array_key_exists('category',$options) && !empty($options['category'])) {
            $where .= " AND products.category = ?";
            $binds[] = $options['category'];
        }

        if(array_key_exists('actual', $options) && !empty($options['actual']) && $options['actual'] != -1) {
            $where .= " AND products.status = 0 OR products.deleted = ?";
            $binds[] = $options['actual'];
        }
        if(array_key_exists('actual', $options) && $options['actual'] == -1) {
            $where .= " AND products.status = 1 AND products.deleted = 0";
        }
        if(array_key_exists('vendor', $options) && !empty($options['vendor'])) {
            $where .= " AND products.vendor = ?";
            $binds[] = $options['vendor'];
        }

        $select = "SELECT COUNT(*) as total";
        $sql = " FROM products
        JOIN product_images as pi
        ON products.id = pi.product_id
        JOIN categories
        ON products.category = categories.id
        JOIN users
        ON products.vendor = users.id
        WHERE {$where}
        ";
        $total = $db->query($select . $sql, $binds)->first()->total;
        $select = "SELECT products.*, pi.url as url, categories.category_name as category, users.username as username";
        $pager = " LIMIT ? OFFSET ?";
        $binds[] = $limit;
        $binds[] = $offset;
        $results = $db->query($select . $sql . $pager, $binds)->results();
        return ['results' => $results, 'total' => $total];
    }

    public static function auctionEndSold($user_id) {
        $db = self::getDb();
        $sql = "SELECT products.*, product_images.url as url, bids.bid_amount as bid_price, users.username as customer FROM products JOIN product_images ON products.id = product_images.product_id LEFT JOIN bids ON bids.product_id = products.id JOIN users ON users.id = bids.user_id WHERE product_images.sort = 0 AND products.sold = 1 AND status = 0 AND bids.deleted = 0 AND vendor = '".$user_id."'";
        return $db->query($sql)->results();
    }

    public static function auctionEndNotSold($user_id) {
        $db = self::getDb();
        $sql = "SELECT products.*, product_images.url as url FROM products JOIN product_images ON products.id = product_images.product_id WHERE product_images.sort = 0 AND products.sold = 0 AND status = 0 AND products.vendor = " .$user_id;
        return $db->query($sql)->results();
    }

    public function getImages() {
        return ProductImages::find([
            'conditions' => "product_id = ?" ,
            'bind' => [$this->id],
            'order' => 'sort'
        ]);
    }

    public static function closedAuctions() {
        $inaktivProducts = array();
        $products = self::find([
            'conditions' => 'status = 1 AND auction_end < NOW()'
        ]);
        foreach($products as $product) {
            ($bid = Bids::findProductBid($product->id)) ? $product->sold = 1 : $product->sold;
            Emails::closedAuctionEmailSablon($product, Users::findById($product->vendor), $product->sold, (isset($bid)?$bid:''), ($bid)? Users::findById($bid->user_id) : 'NULL');
            $product->status = 0;
            $product->save();
        }
    }

    public static function deleteProducts($user_id) {
        $products = self::findAll([
            'conditions' => "user_id",
            'bind' => [$user_id]
        ]);
        foreach($products as $product) {
            $product->delete();
        }
    }

}
