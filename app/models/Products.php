<?php
  namespace App\Models;
  use Core\Model;
  use Core\Validators\{RequiredValidator,NumericValidator};
  use Core\H;

 class Products extends Model {

   public $id, $created_at, $update_at, $name, $description,$body, $vendor, $brand_id,$featured = 0, $user_id;
   public $list_price, $price, $shipping, $deleted= 0;
   const blackList = ['id','deleted'];
   protected static $_table = "products";
   protected static $_softDelete = true;

   public function beforeSave() {
    $this->timeStamps();
   }

   public function validator() {
     $requiredFields = ['name' => "Name", 'price' => "Price", 'list_price' => "List Price", 'shipping' => "Shipping", 'body' => "Body"];
     foreach($requiredFields as $field => $display) {
       $this->runValidation(new RequiredValidator($this, ['field' => $field, 'msg' => $display." is required"]));
     }
     $this->runValidation(new NumericValidator($this, ['field' => 'price', 'msg' => 'Price must be a numeric']));
     $this->runValidation(new NumericValidator($this, ['field' => 'list_price', 'msg' => 'List Price must be a numeric']));
     $this->runValidation(new NumericValidator($this, ['field' => 'shipping', 'msg' => 'Shipping must be a numeric']));

   }

   public static function findByUserId($user_id, $params=[]) {
     $conditions = [
       'conditions' => "user_id = ?",
       'bind' => [(int)$user_id],
       'order' => 'name'
     ];
     $params = array_merge($conditions, $params);
     return self::find($params);
   }

   public static function findByIdAndUserId($id, $user_id) {
     $conditions = [
       'conditions' => "id = ? AND user_id = ?",
       'bind' => [(int)$id, (int)$user_id]
     ];
     return self::findFirst($conditions);
   }

   public function allProducts() {
    $sql = "SELECT products.*, pi.url as url, brands.name as brand
            FROM products
            JOIN product_images as pi
            ON products.id = pi.product_id
            JOIN brands
            ON products.brand_id = brands.id
            WHERE products.deleted = '0' and pi.sort = '0'
            group by pi.product_id
            ";
    return  $this->query($sql)->results();
  }




 }
