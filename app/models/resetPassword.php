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

class resetPassword extends Model {
  public $id, $token, $resetPassword, $password, $confirm;
  protected static $_table = 'reset_password';

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

}
