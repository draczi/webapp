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

class Users extends Model {
  protected static $_table='users', $_softDelete = true;
  public static $currentLoggedInUser = null;
  public $id,$username,$email,$password,$fname,$lname,$acl,$deleted = 0,$confirm, $login_date, $create_date;
  const blackListedFormKeys = ['id','deleted'];

  public function validator(){
    $this->runValidation(new RequiredValidator($this,['field'=>'fname','msg'=>'First Name is required.']));
    $this->runValidation(new RequiredValidator($this,['field'=>'lname','msg'=>'Last Name is required.']));
    $this->runValidation(new RequiredValidator($this,['field'=>'email','msg'=>'Email is required.']));
    $this->runValidation(new EmailValidator($this, ['field'=>'email','msg'=>'You must provide a valid email address']));
    $this->runValidation(new MaxValidator($this,['field'=>'email','rule'=>150,'msg'=>'Email must be less than 150 characters.']));
    $this->runValidation(new MinValidator($this,['field'=>'username','rule'=>6,'msg'=>'Username must be at least 6 characters.']));
    $this->runValidation(new MaxValidator($this,['field'=>'username','rule'=>150,'msg'=>'Username must be less than 150 characters.']));
    $this->runValidation(new UniqueValidator($this,['field'=>['username','deleted'],'msg'=>'That username already exists. Please choose a new one.']));
    $this->runValidation(new RequiredValidator($this,['field'=>'password','msg'=>'Password is required.']));
    $this->runValidation(new MinValidator($this,['field'=>'password','rule'=>6,'msg'=>'Password must be a minimum of 6 characters.']));
    if($this->isNew()){
      $this->runValidation(new MatchesValidator($this,['field'=>'password','rule'=>$this->confirm,'msg'=>"Your passwords do not match."]));
    }
  }

  public function beforeSave(){
    $this->timeStamps();
    if($this->isNew()){
      $this->password = password_hash($this->password, PASSWORD_DEFAULT);
    }
  }

  public static function findByUsername($username) {
    return self::findFirst(['conditions'=> "username = ?", 'bind'=>[$username]]);
  }

  public static function currentUser() {
    if(!isset(self::$currentLoggedInUser) && Session::exists(CURRENT_USER_SESSION_NAME)) {
      self::$currentLoggedInUser = self::findById((int)Session::get(CURRENT_USER_SESSION_NAME));
    }
    return self::$currentLoggedInUser;
  }

  public function login($rememberMe=false) {
    Session::set(CURRENT_USER_SESSION_NAME, $this->id);
    if($rememberMe) {
      $hash = md5(uniqid() + rand(0, 100));
      $user_agent = Session::uagent_no_version();
      Cookie::set(REMEMBER_ME_COOKIE_NAME, $hash, REMEMBER_ME_COOKIE_EXPIRY);
      $fields = ['session'=>$hash, 'user_agent'=>$user_agent, 'user_id'=>$this->id];
      self::$_db->query("DELETE FROM users_sessions WHERE user_id = ? AND user_agent = ?", [$this->id, $user_agent]);
      $us = new UserSessions();
      $us->assign($fields);
      $us->save();
      //self::$_db->insert('user_sessions', $fields);
    }
  }

  public static function loginUserFromCookie() {
    $userSession = UserSessions::getFromCookie();
    if($userSession && $userSession->user_id != '') {
      $user = self::findById((int)$userSession->user_id);
      if($user) {
        $user->login();
      }
      return $user;
    }
    return;
  }

  public function logout() {
    $userSession = UserSessions::getFromCookie();
    if($userSession) $userSession->delete();
    Session::delete(CURRENT_USER_SESSION_NAME);
    if(Cookie::exists(REMEMBER_ME_COOKIE_NAME)) {
      Cookie::delete(REMEMBER_ME_COOKIE_NAME);
    }
    self::$currentLoggedInUser = null;
    return true;
  }

  public function acls() {
    if(empty($this->acl)) return [];
    $sql = $this->query("SELECT acls.user_level as acl FROM users JOIN acls ON acls.id = users.acl WHERE users.id =" .$this->id)->results();
    return $sql[0]->acl;
  }

  public static function addAcl($user_id,$acl){
    $user = self::findById($user_id);
    if(!$user) return false;
    $acls = $user->acls();
    if(!in_array($acl,$acls)){
      $acls[] = $acl;
      $user->acl = json_encode($acls);
      $user->save();
    }
    return true;
  }

  public static function removeAcl($user_id, $acl){
    $user = self::findById($user_id);
    if(!$user) return false;
    $acls = $user->acls();
    if(in_array($acl,$acls)){
      $key = array_search($acl,$acls);
      unset($acls[$key]);
      $user->acl = json_encode($acls);
      $user->save();
    }
    return true;
  }

  public function belepesDate($user_id) {
    $user = self::findById($user_id);
    $date = date('Y-m-d H:i:s');
    $user->login_date = $date;
    $user->save();
    return true;
  }

  public static function findUserName($user_id) {
    return self::findFirst([
      'column' => 'username',
      'conditions' => 'id = ?',
      'bind' => [$user_id]
    ]);
  }

  public static function getOptionForForm($new=false) {
    $db = DB::getInstance();
    $acls = $db->query("SELECT id, user_level FROM acls")->results();
    $aclsAry = ['0' =>' Összes'];
    if ($new==true) $aclsAry = [];
    foreach($acls as $acl) {
      $aclsAry[$acl->id] = AdminUsersController::szotar($acl->user_level);
    }
    return $aclsAry;
  }
  public static function allUsers($options) {
   $db = DB::getInstance();
   $limit = (array_key_exists('limit', $options) && !empty($options['limit'])) ? $options['limit'] : 4;
   $offset = (array_key_exists('offset',$options) && !empty($options['offset']))? $options['offset'] : 0;
   $where = "users.deleted = 0";
   $binds = [];
   if(array_key_exists('search',$options) && !empty($options['search'])) {
     $where .= " AND (users.username LIKE ? OR users.fname LIKE ? OR users.lname LIKE ?)";
     $binds[] = "%" . $options['search'] . "%";
     $binds[] = "%" . $options['search'] . "%";
     $binds[] = "%" . $options['search'] . "%";
   }
   if(array_key_exists('acl',$options) && !empty($options['acl'])) {
     $where .= " AND users.acl = ?";
     $binds[] = $options['acl'];
   }

   $select = "SELECT COUNT(*) as total";
   $sql = " FROM users
           JOIN acls
           ON users.acl = acls.id
           WHERE {$where}
           ";
   $total = $db->query($select . $sql, $binds)->first()->total;
   $select = "SELECT users.*, acls.user_level as acl";
   $pager = " LIMIT ? OFFSET ?";
   $binds[] = $limit;
   $binds[] = $offset;
   $results = $db->query($select . $sql . $pager, $binds)->results();
   return ['results' => $results, 'total' => $total];
 }

 public static function hasFilters($options){
       foreach($options as $key => $value){
         if(!empty($value) && $key != 'limit' && $key != 'offset') return true;
       }
       return false;
     }
}
