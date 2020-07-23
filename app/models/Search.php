<?php
namespace App\Models;
use Core\Model;
use Core\Validators\RequiredValidator;
use Core\H;

class Search extends Model {
  public $min_price;
  protected static $_table = 'tmp_fake';

  public function validator(){
    $this->runValidation(new RequiredValidator($this,['field'=>'min_price','msg'=>'A minimum ár nem lehet nagyobb mint a maximális ár!']));
  }

}
