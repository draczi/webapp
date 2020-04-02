<?php
namespace App\Models;
use Core\Model;
use Core\Validators\RequiredValidator;
use Core\H;

class Login extends Model {
  public $username, $password, $remember_me;
  protected static $_table = 'tmp_fake';

  public function validator(){
    $this->runValidation(new RequiredValidator($this,['field'=>'username','msg'=>'Nem adott meg a felhasználónevet.']));
    $this->runValidation(new RequiredValidator($this,['field'=>'password','msg'=>'Nem adott meg a jelszavat.']));
  }

}
