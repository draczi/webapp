<?php
  namespace App\Models;
  use Core\Model;
  use Core\Validators\{RequiredValidator,NumericValidator,DoubleLicitValidator};
  use Core\H;
  use Core\DB;
  use Core\Session;
  use Core\Router;

 class Bids extends Model {

   public $id, $product_id, $user_id, $bid_date, $bid_amount, $deleted = 0;
   protected static $_table = "bids";
   protected static $_softDelete = true;

   public function onConstruct() {
     $this->currentUser = Users::currentUser();
  }

   public function beforeSave() {
    $this->timeStamps();
   }

   public function validator() {
    $this->runValidation(new NumericValidator($this, ['field' => 'bid_amount', 'msg' => 'Licitként csak számot adhatsz meg!']));
    $this->runValidation(new RequiredValidator($this, ['field' => 'bid_amount', 'msg' => 'Kérlek adj meg egy licit.']));


   }

   public static function findProductBind($product_id) {
     return self::findFirst([
       'conditions' => 'product_id = ?',
       'bind' => [$product_id]
    ]);
   }

   public static function findProductAndUserBind($product_id, $user_id) {
     return self::findFirst([
       'column' => 'id',
       'conditions' => 'product_id = ? AND user_id = ? AND deleted = 0',
       'bind' => [$product_id, $user_id]
     ]);
   }


}

  // public static function findByUserId($product_id) {
  //   $bid = self::findFirst([
  //     'conditions' => 'product_id = ? AND deleted = 0',
  //     'bind' => [$product_id]
  //    ]);
  //    if($bid) {
  //      $this->update(['deleted' => '1']);
  //    }
  //  }
