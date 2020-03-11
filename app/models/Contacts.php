<?php
namespace App\Models;
use Core\Model;
use App\Models\Users;
use App\Models\UserSessions;
use Core\Cookie;
use Core\Session;
use Core\DB;
use Core\Validators\MinValidator;
use Core\Validators\MaxValidator;
use Core\Validators\RequiredValidator;
use Core\Validators\EmailValidator;
use Core\Validators\MatchesValidator;
use Core\Validators\UniqueValidator;
use App\Controllers\Admin\AdminUsersController;
use Core\H;

class Contacts extends Model {
  protected static $_table='contact', $_softDelete = true;
  public static $currentLoggedInUser = null;
  public $user_id,$address,$city,$phone,$mobile_phone,$country,$zip_code, $adoszam, $ostermelo_id;

  // public function validator(){
  //   $this->runValidation(new RequiredValidator($this,['field'=>'fname','msg'=>'First Name is required.']));
  //   $this->runValidation(new RequiredValidator($this,['field'=>'lname','msg'=>'Last Name is required.']));
  //   $this->runValidation(new RequiredValidator($this,['field'=>'email','msg'=>'Email is required.']));
  //   $this->runValidation(new EmailValidator($this, ['field'=>'email','msg'=>'You must provide a valid email address']));
  //   $this->runValidation(new MaxValidator($this,['field'=>'email','rule'=>150,'msg'=>'Email must be less than 150 characters.']));
  //   $this->runValidation(new MinValidator($this,['field'=>'username','rule'=>6,'msg'=>'Username must be at least 6 characters.']));
  //   $this->runValidation(new MaxValidator($this,['field'=>'username','rule'=>150,'msg'=>'Username must be less than 150 characters.']));
  //   $this->runValidation(new UniqueValidator($this,['field'=>['username','deleted'],'msg'=>'That username already exists. Please choose a new one.']));
  //   $this->runValidation(new RequiredValidator($this,['field'=>'password','msg'=>'Password is required.']));
  //   $this->runValidation(new MinValidator($this,['field'=>'password','rule'=>6,'msg'=>'Password must be a minimum of 6 characters.']));
  //   if($this->isNew()){
  //     $this->runValidation(new MatchesValidator($this,['field'=>'password','rule'=>$this->confirm,'msg'=>"Your passwords do not match."]));
  //   }
  // }

  public static function findByUserId($user_id) {
     $db = DB::getInstance();
     $sql = "SELECT * FROM contact where user_id =" .$user_id;
     return $db->query($sql)->results();
  }

  public static function getOptionForForm() {
    $db = DB::getInstance();
    $acls = $db->query("SELECT id, user_level FROM acls")->results();
    $aclsAry = ['0' =>' Összes'];
    foreach($acls as $acl) {
      $aclsAry[$acl->id] = AdminUsersController::szotar($acl->user_level);
    }
    return $aclsAry;
  }

}
