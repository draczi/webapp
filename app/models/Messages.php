<?php
namespace App\Models;
use Core\Model;
use Core\Validators\{RequiredValidator,EmailValidator,MinValidator,MaxValidator,MatchesValidator,UniqueValidator};

class Messages extends Model {
  public $message_id, $message, $product_id, $user_id;
  protected static $_table = 'messages';

  public function validator(){
       $this->runValidation(new RequiredValidator($this,['field' => 'message', 'msg' => 'Kérlek írj valamit az üzenetbe.']));
       $this->runValidation(new MinValidator($this,['field'=>'message','rule'=>5,'msg'=>'Az üzenetnek legalább 5 karakterből kell állnia.']));

  }

  public static function findByProductId($product_id) {
      $db = self::getDb();
      return $db->query("SELECT messages.*, users.username FROM messages LEFT JOIN users ON messages.user_id = users.id WHERE product_id = '".$product_id."'")->results();
  }

  public static function findByUserId($user_id) {
      $conditions = [
          'conditions' => "user_id = ?",
          'bind' => [$user_id]
      ];
      return self::findFirst($conditions);
  }

}
