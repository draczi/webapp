<?php

  namespace App\Models;
  use Core\Model;
  use Core\Validators\{RequiredValidator,UniqueValidator};
  use Core\H;

  class Brands extends Model {
    public $id, $created_at, $updated_at, $name, $deleted = 0;
    protected static $_table = "brands";
    protected static $_softDelete = true;

    public function beforeSave() {
      $this->timeStamps();
    }

    public function validator() {
      $this->runValidation(new RequiredValidator($this,['field' => 'name', 'msg' => 'Brand name is Required']));
      $this->runValidation(new UniqueValidator($this,['field' => ['name', 'deleted'],'msg' => 'The Brand name already exists']));
    }

    public static function getBradsForForm() {
      $brands = self::find([
        'columns' => 'id, name',
        'order' => 'name'
      ]);
      $brandsAry = ['' =>' Select Brand'];
      foreach($brands as $brand) {
        $brandsAry[$brand->id] = $brand->name;
      }
      return $brandsAry;

    }
  }
