<?php
  namespace App\Models;
  use Core\Model;
  use Core\Validators\{RequiredValidator,NumericValidator};
  use Core\H;


 class Products extends Model {

   public $id, $created_at, $update_at, $name, $description,$body, $vendor, $brand, $user_id;
   public $list_price, $price, $shipping, $deleted= 0;
   const blackList = ['id','deleted'];

   protected function $_table = "products";
   protected function $_softDelete = true;

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

   public function findByUserId($user_id, $params=[]) {
     $conditions = [
       'conditions' => "user_id = ?",
       'bind' => [(int)$user_id,
       'order' => 'name'
     ];
     $params = array_merge($conditions, $params);
     return self::find($params);
   }




 }
