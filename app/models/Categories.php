<?php

  namespace App\Models;
  use Core\Model;
  use Core\Validators\{RequiredValidator,UniqueValidator,NumMinValidator};
  use Core\H;
  use Core\Database;

  class Categories extends Model {
    public $id, $category_name, $parent = NULL;
    protected static $_table = "categories";

    public function validator() {
      $this->runValidation(new RequiredValidator($this,['field' => 'category_name', 'msg' => 'Kérlek adj meg egy kategória nevet.']));
      $this->runValidation(new UniqueValidator($this,['field' => ['category_name'],'msg' => 'Ez a kategória már létezik.']));
      $this->runValidation(new NumMinValidator($this,['field'=>'parent','rule'=>1,'msg'=>'Kérlek válassz egy kategóriát.']));
    }

    public static function allCategories() {
      $db = Database::getInstance();
      return $db-> query("SELECT * FROM categories")->results();
    }

    public static function findParentById($category_id) {
      return self::findFirst([
        'conditions' => 'parent = ?',
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
        'conditions' => 'parent is not null',
        'order' => 'category_name'
      ]);
      $categoriesAry = ['0' =>'Válasszon egy kategóriát'];
      foreach($categories as $category) {
        $categoriesAry[$category->id] = $category->category_name;
      }
      return $categoriesAry;
    }
  }
