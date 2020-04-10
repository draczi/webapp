<?php
  namespace App\Models;
  use Core\Model;
  use Core\H;
  use App\Models\Users;

  class ProductImages extends Model {
    public $id, $url, $product_id,$sort;

    protected static $_table = "product_images";

    public function validateImages($images) {
      $files = self::restructureFiles($images);
      $errors = [];
      $maxSize = 5242880;
      $allowedTypes = [IMAGETYPE_GIF,IMAGETYPE_JPEG,IMAGETYPE_PNG]; //H::dnd($files);
      if ($files[0]['name'] == '') return $errors[] = ["1" => "Legalább 1 képet töltsön fel a termékhez."];
      foreach($files as $file) {
        $name = $file['name'];

        //check filesize
        if($file['size'] > $maxSize) {
          $errors[$name] = $name . " mérete maximum 5MB lehet.";
        }

        // checking file type
        if(!in_array(exif_imagetype($file['tmp_name']),$allowedTypes)) {
          $errors[$name] = $name . " nem megfelelő típusú. Kérem .jpg, .png, .gif kiterjesztésű fájlt töltsön fel.";
        }
      }
      return (empty($errors)) ? true : $errors;
    }

    public static function uploadProductImage($product_id, $files) {
      $lastImage = self::findFirst([
        'conditions' => "product_id = ?",
        'bind' =>  [$product_id],
        'order' => 'sort DESC'
      ]);
      $lastSort = (!$lastImage) ? 0 : $lastImage->sort;
      $path = 'uploads'.DS.'product_images'.DS.'product_'.$product_id.DS;
      foreach($files as $file) {
        $parts = explode('.', $file['name']);
        $ext = end($parts);
        $hash = sha1(time().$product_id.$file['tmp_name']);
        $uploadName = $hash . '.' . $ext;
        $image = new self();
        $image->url = $path . $uploadName;
        $image->product_id = $product_id;
        $image->sort = $lastSort;
        if($image->save()) {
          if(!file_exists($path)) {
            mkdir($path);
          }
          move_uploaded_file($file['tmp_name'], ROOT.DS.$image->url);
          $lastSort++;
        }
      }
    }

    public static function restructureFiles($files) {
      $structured = [];
      foreach($files['tmp_name'] as $key => $val) {
        $structured[] =
          ['tmp_name' => $files['tmp_name'][$key],
           'name' => $files['name'][$key],
           'size' => $files['size'][$key],
           'error' => $files['error'][$key],
           'type' => $files['type'][$key]
        ];
      }
      return $structured;
    }

    public static function deleteImages($product_id, $unlink = false) {
      $images = self::find([
        'conditions' => "product_id = ? ",
        'bind' => [$product_id]
    ]);
      foreach($images as $image) {
        $image->delete();
      }
      if($unlink) {
        $dirname = ROOT. DS . 'uploads' . DS . 'product_images' . DS . 'product_' . $product_id;
        array_map('unlink', glob("$dirname/*.*"));
        rmdir($dirname);

      }
    }

    public static function deleteById($id) {
      $image = self::findById($id);
      $sort = $image->sort;
      $afterImages = self::find([
        'conditions' => "product_id = ? and sort > ?",
        'bind' => [$image->product_id, $sort]
    ]);
      foreach($afterImages as $af) {
        $af->sort = $af->sort -1;
        $af=save();
    }
      unlink(ROOT.DS.$image->url);
      return $image->delete();
    }
    public static function findByProductId($product_id) {
      return self::find([
        'conditions' => "product_id = ?",
        'bind' => [$product_id],
        'order' => 'sort'
      ]);
    }

    public static function updateSortByProductId($product_id, $sortOrder=[]) {
      $images = self::findByProductId($product_id);
      $i = 0;
      foreach($images as $image) {
        $val = 'image_'.$image->id;
        $sort = (in_array($val, $sortOrder)) ? array_search($val, $sortOrder) : $i;
        $image->sort = $sort;
        $image->save();
        $i++;
      }

    }
  }
