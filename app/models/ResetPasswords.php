<?php
namespace App\Models;
use Core\Model;
use Core\Validators\RequiredValidator;
use Core\Validators\EmailValidator;
use Core\H;

class ResetPasswords extends Model {
  public $id, $token, $user_id, $email, $create_date;
  protected static $_table = 'reset_passwords';

  public function validator(){
          $this->runValidation(new RequiredValidator($this,['field'=>'email','msg'=>'Kérlek adj meg egy email címet.']));
          $this->runValidation(new EmailValidator($this, ['field'=>'email','msg'=>'Nem megfelelő az email cím formátuma.']));
  }

  public static function findByToken($token) {
      return self::findFirst([
          'conditions' => 'token = ?',
          'bind' => [$token]
      ]);
  }

  public static function deleteToken($token) {
      self::getDb()->query("DELETE FROM reset_passwords WHERE token = '".$token."'");
  }
}
