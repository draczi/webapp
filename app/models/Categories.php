<?php

  namespace App\Models;
  use Core\Model;
  use Core\Validators\{RequiredValidator,UniqueValidator};
  use Core\H;
  use Core\DB;

  class Categories extends Model {
    public $id, $category_name, $parent;
    protected static $_table = "categories";

    public function validator() {
      $this->runValidation(new RequiredValidator($this,['field' => 'category_name', 'msg' => 'Kérlek adj meg egy kategória nevet.']));
      $this->runValidation(new UniqueValidator($this,['field' => ['category_name'],'msg' => 'Ez a kategória már létezik.']));
    }

    public static function allCategories() {
      $db = DB::getInstance();
      return $db-> query("SELECT * FROM categories")->results();
    }

    public static function categoryId($category_id) {
      return self::findFirst([
        'conditions' => 'id = ?',
        'bind' => [$category_id],
      ]);
    }

    public static function getCategoryName($category_id) {
    return self::findFirst([
        'condition' => 'id = ?',
        'bind' => [$category_id],
      ]);
    }

    public static function getCategoryParentForForm() {
      $categories = self::find([
        'columns' => 'id, category_name',
        'conditions' => 'parent is null',
        'order' => 'category_name'
      ]);
      $categoriesAry = ['0' =>' Válassz egy kategóriát'];
      foreach($categories as $category) {
        $categoriesAry[$category->id] = $category->category_name;
      }
      return $categoriesAry;
    }

    public static function getOptionForForm() {
      $categories = self::find([
        'columns' => 'id, category_name',
        'order' => 'category_name'
      ]);
      $categoriesAry = ['0' =>'Összes kategória'];
      foreach($categories as $category) {
        $categoriesAry[$category->id] = $category->category_name;
      }
      return $categoriesAry;
    }
  }
