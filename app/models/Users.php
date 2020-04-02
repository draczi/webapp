<?php
namespace App\Models;
use Core\Model;
use App\Models\Users;
use App\Models\UserSessions;
use Core\Cookie;
use Core\Session;
use Core\Database;;
use Core\Validators\MinValidator;
use Core\Validators\MaxValidator;
use Core\Validators\RequiredValidator;
use Core\Validators\EmailValidator;
use Core\Validators\MatchesValidator;
use Core\Validators\UniqueValidator;
use App\Controllers\Admin\AdminUsersController;
use Core\H;

class Users extends Model {
    protected static $_table='users';
    public static $currentLoggedInUser = null;
    public $id,$username,$email,$password,$fname,$lname,$acl=1,$confirm, $login_date, $create_date;
    public $address, $city, $state,$country, $zip_code, $phone, $mobile_phone, $producer_number, $tax_number;
    const blackListedFormKeys = ['id'];

    public function validator(){
        $requiredFields = [
            'lname' => "a vezetéknevet", 'fname' => " a keresztnevet", 'email' => "az e-mailt", 'username' => "a felhasználónevet",
            'password' => "a jelszavat", 'address' => "a címet", 'city' => "a várost", 'zip_code' => "az irányítószámot",
            'country' => "az országot", 'mobile_phone' => "a mobiltelefonszámot"
        ];
        foreach($requiredFields as $field => $display) {
          $this->runValidation(new RequiredValidator($this, ['field' => $field, 'msg' => "Kérlek add meg " .$display]));
        }
        $this->runValidation(new EmailValidator($this, ['field'=>'email','msg'=>'Nem megfelelő e-mail címet adtál meg.']));
        $this->runValidation(new MaxValidator($this,['field'=>'email','rule'=>150,'msg'=>'Az e-mail cím maximum 150 karaterből állhat.']));
        $this->runValidation(new MinValidator($this,['field'=>'username','rule'=>5,'msg'=>'A felhasználónév minimum 5 karakterből állhat.']));
        $this->runValidation(new MaxValidator($this,['field'=>'username','rule'=>150,'msg'=>'A felhasználónév maximum 5 karakterből állhat.']));
        $this->runValidation(new UniqueValidator($this,['field'=>['username'],'msg'=>'Ez a felhasználónév foglalt.']));
        $this->runValidation(new UniqueValidator($this,['field'=>['email'],'msg'=>'Ez az e-mail cím már regisztrálva van.']));
        $this->runValidation(new MatchesValidator($this,['field'=>'password','rule'=>$this->confirm,'msg'=>"A megadott jelszavak nem egyeznek."]));
        $this->runValidation(new MinValidator($this,['field'=>'password','rule'=>5,'msg'=>'A jelszónak minimum 5 karakterből kell állnia.']));

    }
    public function beforeSave(){
        $this->timeStamps();
        if ($this->isNew()) {
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

    public function login() {
        Session::set(CURRENT_USER_SESSION_NAME, $this->id);
    }

    public function logout() {
        Session::delete(CURRENT_USER_SESSION_NAME);
        if(Cookie::exists(REMEMBER_ME_COOKIE_NAME)) {
            Cookie::delete(REMEMBER_ME_COOKIE_NAME);
        }
        self::$currentLoggedInUser = null;
        return true;
    }

    public function acls() {
        if(empty($this->acl)) return [];
        $sql = $this->query("SELECT acls.user_level as acl FROM users JOIN acls ON acls.acl_id = users.acl WHERE users.id =" .$this->id)->results();
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

    public static function findUserById($user_id) {
        return self::findFirst([
            'conditions' => 'id = ?',
            'bind' => [$user_id]
        ]);
    }

    public static function findByEmail($email) {
        return self::findFirst([
            'column' => 'email',
            'conditions' => 'email = ?',
            'bind' => [$email]
        ]);
    }

    public static function getOptionForForm($new=false) {
        $db = Database::getInstance();
        $acls = $db->query("SELECT acl_id, user_level FROM acls")->results();
        $aclsAry = ['0' =>' Összes'];
        if ($new==true) $aclsAry = [];
        foreach($acls as $acl) {
            $aclsAry[$acl->acl_id] = AdminUsersController::szotar($acl->user_level);
        }
        return $aclsAry;
    }
    public static function allUsers($options) {
        $db = Database::getInstance();
        $limit = (array_key_exists('limit', $options) && !empty($options['limit'])) ? $options['limit'] : 4;
        $offset = (array_key_exists('offset',$options) && !empty($options['offset']))? $options['offset'] : 0;
        $where = 'create_date < NOW()';
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
        ON users.acl = acls.acl_id
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

    public static function modifyPassword($id, $password) {
        $db = Database::getInstance();
        $query = "UPDATE users SET `password` = '".$password."' WHERE `id` = '".$id ."' LIMIT 1 " ; H::dnd( $db->query($query));
        $result = $db->query($query);
    }

    public static function hasFilters($options){
        foreach($options as $key => $value){
            if(!empty($value) && $key != 'limit' && $key != 'offset') return true;
        }
        return false;
    }
}
