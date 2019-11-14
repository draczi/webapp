<?php
  namespace App\Models;
  use Core\Model;
  use Core\Validators\{RequiredValidator,NumericValidator};
  use Core\H;
  use Core\DB;

 class Bids extends Model {

   public $id, $product_id, $user_id, $bid_date, $bid_amoun, $status = 0;
   protected static $_table = "bids";
   protected static $_softDelete = true;

   public function beforeSave() {
    $this->timeStamps();
   }

   public function validator() {
     $this->runValidation(new NumericValidator($this, ['field' => 'bids', 'msg' => 'Licitként csak számot adhatsz meg!']));
     $this->runValidation(new RequiredValidator($this, ['field' => 'bids', 'msg' => 'Kérlek adj meg egy licit.']));

   }
