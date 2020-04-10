<?php
namespace App\Models;
use Core\Model;
use Core\Validators\RequiredValidator;
use Core\Validators\EmailValidator;
use Core\Validators\MinValidator;
use Core\Validators\MaxValidator;
use Core\Validators\MatchesValidator;
use Core\Validators\UniqueValidator;
use Core\H;

class Messages extends Model {
  public $message_id, $message, $product_id, $user_id;
  protected static $_table = 'messages';

  public function validator(){
       $this->runValidation(new RequiredValidator($this,['field' => 'message', 'msg' => 'Kérlek írj valamit az üzenetbe.']));
  }

  public static function findByProductId($product_id) {
      $db = self::getDb();
      return $db->query("SELECT messages.*, users.username FROM messages LEFT JOIN users ON messages.user_id = users.id WHERE product_id = '".$product_id."'")->results();
  }

}
