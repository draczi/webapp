<?php
namespace App\Models;
use Core\Model;
use Core\Validators\RequiredValidator;
use Core\H;

class resetPassword extends Model {
  public $id, $email, $token;
  protected static $_table = 'reset_password';

  public function validator(){
    $this->runValidation(new RequiredValidator($this,['field'=>'email','msg'=>'Email is required.']));
  }

  public static function findByToken($token) {
      return self::findFirst([
          'conditions' => 'token = ?',
          'bind' => [$token]
      ]);
  }

}
