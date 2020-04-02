<?php
  namespace App\Models;
  use Core\Model;
  use Core\Validators\{RequiredValidator,NumericValidator};
  use Core\H;

 class Products extends Model {

   public $id, $created_at, $update_at, $name, $description, $vendor, $category, $action_end, $quantity, $min_price, $auction_time;
   public $list_price, $price, $bid_increment , $deleted= 0;
   const blackList = ['id','deleted'];
   protected static $_table = "products";
   protected static $_softDelete = true;

   public function beforeSave() {
    if (!$this->isNew()) $this->timeStamps();
   }

   public function validator() {
     $requiredFields = ['product_name' => "Name", 'price' => "Price", 'quantity' => "Mennyiség", 'description' => "Termékleírás"];
     foreach($requiredFields as $field => $display) {
       $this->runValidation(new RequiredValidator($this, ['field' => $field, 'msg' => $display." is required"]));
     }
     $this->runValidation(new NumericValidator($this, ['field' => 'price', 'msg' => 'Price must be a numeric']));
     $this->runValidation(new NumericValidator($this, ['field' => 'min_price', 'msg' => 'List Price must be a numeric']));
     $this->runValidation(new NumericValidator($this, ['field' => 'quantity', 'msg' => 'Shipping must be a numeric']));

   }

   public static function findByUserId($user_id, $params=[]) {
     $conditions = [
       'conditions' => "vendor = ?",
       'bind' => [(int)$user_id],
       'order' => 'name'
     ];
     $params = array_merge($conditions, $params);
     return self::find($params);
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

   public static function allProducts($options, $admin = false) {
    $db = self::getDb();
    $limit = (array_key_exists('limit', $options) && !empty($options['limit'])) ? $options['limit'] : 4;
    $offset = (array_key_exists('offset',$options) && !empty($options['offset']))? $options['offset'] : 0;
    $where = "status = 1 AND products.deleted = 0 AND pi.sort = '0'";
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

    $select = "SELECT COUNT(*) as total";
    $sql = " FROM products
            JOIN product_images as pi
            ON products.id = pi.product_id
            JOIN categories
            ON products.category = categories.id
            WHERE {$where}
            ";
    $total = $db->query($select . $sql, $binds)->first()->total;
    $select = "SELECT products.*, pi.url as url, categories.category_name as category";
    $pager = " LIMIT ? OFFSET ?";
    $binds[] = $limit;
    $binds[] = $offset;
    $results = $db->query($select . $sql . $pager, $binds)->results();
    return ['results' => $results, 'total' => $total];
  }

  public static function auctionEndSold($user_id) {
    $db = self::getDb();
    $sql = "SELECT products.*, product_images.url as url FROM products JOIN product_images ON products.id = product_images.product_id WHERE product_images.sort = 0 AND products.sold = 1 AND status = 0 AND products.vendor = " .$user_id;
    return $db->query($sql)->results();
  }

  public static function auctionEndNotSold($user_id) {
    $db = self::getDb();
    $sql = "SELECT products.*, product_images.url as url FROM products JOIN product_images ON products.id = product_images.product_id WHERE product_images.sort = 0 AND products.sold = 0 AND status = 0 AND products.vendor = " .$user_id;
    return $db->query($sql)->results();
  }

  public static function hasFilters($options){
        foreach($options as $key => $value){
          if(!empty($value) && $key != 'limit' && $key != 'offset') return true;
        }
        return false;
      }

  public function getImages() {
    return ProductImages::find([
      'conditions' => "product_id = ?" ,
      'bind' => [$this->id],
      'order' => 'sort'
    ]);
  }

  public static function activeProducts() {
      $db = self::getDb();
      $db->query("UPDATE products SET status = 0 WHERE auction_end < NOW()");
  }




 }
