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
  public $id, $email, $token, $resetPassword, $password, $confirm;
  protected static $_table = 'reset_password';

  public function validator(){
    if($this->resetPassword != null) {
        $this->runValidation(new RequiredValidator($this,['field'=>'email','msg'=>'Kérlek adj meg egy email címet.']));
        $this->runValidation(new EmailValidator($this, ['field'=>'email','msg'=>'Nem megfelelő az email cím formátuma.']));
    }
    $this->runValidation(new MatchesValidator($this,['field'=>'password','rule'=>$this->confirm,'msg'=>"Your passwords do not match."]));
    $this->runValidation(new MinValidator($this,['field'=>'password','rule'=>6,'msg'=>'Password must be a minimum of 6 characters.']));
    $this->runValidation(new RequiredValidator($this,['field'=>'password','msg'=>'Password is required.']));


  }

  public static function findByToken($token) {
      return self::findFirst([
          'conditions' => 'token = ?',
          'bind' => [$token]
      ]);
  }

}
