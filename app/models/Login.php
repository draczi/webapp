<?php
namespace App\Models;
use Core\Model;
use Core\Validators\RequiredValidator;
use Core\H;

class Login extends Model {
  public $username, $password, $remember_me;
  protected static $_table = 'tmp_fake';

  public function validator(){
    $this->runValidation(new RequiredValidator($this,['field'=>'username','msg'=>'Username is required.']));
    $this->runValidation(new RequiredValidator($this,['field'=>'password','msg'=>'Password is required.']));
  }

  public function getRememberMeChecked(){
    return $this->remember_me == 'on';
  }
  public function belepesDate() {
    $belepes_at = $now = date('Y-m-d H:i:s');
    $a = $this->query("UPDATE users SET belepes_at = ' .$belepes_at . ' where id = 1");
    return $a;
  }
}
