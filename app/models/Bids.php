<?php
namespace App\Models;
use Core\Model;
use Core\Validators\{RequiredValidator,NumericValidator,BidMinValidator,UniqueValidator};
use Core\FH;
use Core\DB;
use Core\Session;
use Core\Router;

class Bids extends Model {

    public $id, $product_id, $user_id, $bid_date, $bid_amount, $deleted = 0, $min_bid_price;
    protected static $_table = "bids";
    protected static $_softDelete = true;

    public function onConstruct() {
        $this->currentUser = Users::currentUser();
    }

    public function beforeSave() {
        $this->timeStamps();
    }

    public function validator() {
        $this->runValidation(new UniqueValidator($this,['field'=>['user_id','product_id','deleted'],'msg'=>'Korábban már licitált, Ön vezeti a licitet. ']));
        $this->runValidation(new NumericValidator($this, ['field' => 'bid_amount', 'msg' => 'Licitként csak számot adhat meg!']));
        $this->runValidation(new RequiredValidator($this, ['field' => 'bid_amount', 'msg' => 'Kérlek adj meg egy licit.']));
        $this->runValidation(new BidMinValidator($this,['field'=>'bid_amount','rule'=>$this->min_bid_price,'msg'=>'Licited a minimum alatt van! Kérlek adj meg egy összeget legalább ' . $this->min_bid_price . ' Ft értékben.']));
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
