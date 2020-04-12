<?php
namespace App\Models;
use Core\Model;
use Core\Validators\{RequiredValidator,NumericValidator,NumMinValidator,UniqueValidator,DontMatchesValidator};
use Core\H;


class Bids extends Model {

    public $id, $product_id, $user_id, $bid_date, $bid_amount, $deleted = 0, $min_bid_price, $vendor, $auction_end;
    protected static $_table = "bids";
    protected static $_softDelete = true;

    public function beforeSave() {
        $this->timeStamps();
    }

    public function validator() {
        $this->runValidation(new UniqueValidator($this,['field'=>['user_id','product_id','deleted'],'msg'=>'Korábban már licitált, Ön vezeti a licitet. ']));
        $this->runValidation(new NumericValidator($this, ['field' => 'bid_amount', 'msg' => 'Licitként csak számot adhat meg!']));
        $this->runValidation(new RequiredValidator($this, ['field' => 'bid_amount', 'msg' => 'Kérlek adj meg egy licitet.']));
        $this->runValidation(new DontMatchesValidator($this, ['field' => 'user_id', 'rule' => $this->vendor, 'msg' => 'A saját termékére nem licitálhat.']));
        //$this->runValidation(new NumMinValidator($this,['field'=>'bid_amount','rule'=>$this->min_bid_price,'msg'=>'Licited a minimum alatt van! Kérlek adj meg egy összeget legalább ' . $this->min_bid_price . ' Ft értékben.']));
        $this->runValidation(new NumMinValidator($this,['field'=>'auction_end','rule'=>date('Y-m-d H:m:s'),'msg'=>'Az aukció lezárult! Sajnos a licited nem érvényes.']));
    }

    public static function findProductBid($product_id) {
        return self::findFirst([
            'conditions' => 'product_id = ? AND deleted = 0',
            'bind' => [$product_id]
        ]);
    }

    public static function findUserBid($user_id) {
        return self::findFirst([
            'conditions' => 'user_id = ? AND deleted = 0',
            'bind' => [$user_id]
        ]);
    }

    public static function findProductAndUserBind($product_id, $user_id) {
        return self::findFirst([
            'column' => 'id',
            'conditions' => 'product_id = ? AND user_id = ? AND deleted = 0',
            'bind' => [$product_id, $user_id]
        ]);
    }

    public static function deleteBids($product_id) {
      $images = self::findAll([
        'conditions' => "product_id = ?",
        'bind' => [$product_id]
      ]);
      foreach($bids as $bid) {
        $bid->delete();
      }


}
}
