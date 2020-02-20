<?php
  namespace App\Controllers\Admin;
  use Core\Controller;
  use Core\Model;
  use Core\Session;
  use Core\Router;
  use Core\H;
  use App\Models\Products;
  use App\Models\ProductImages;
  use App\Models\Users;
  use App\Models\Categories;


  class AdminproductController extends Controller {

    public function onConstruct() {
      $this->view->setLayout('admin');
      $this->currentUser = Users::currentUser();
    }

    public function indexAction() {
      $this->view->users = $this->currentUser->id;
      $this->view->products = Products::find();
      $this->view->render('admin/adminproduct/index');
    }

    public function addAction() {
      $product = new Products();
      $productImage = new ProductImages();
      $auction_time = array('7' => '1 hét', '14' => '2 hét', '21' => '3 hét');
      if($this->request->isPost()) {
        $files = $_FILES['productImages'];
        $imagesErrors = $productImage->validateImages($files);
        if(is_array($imagesErrors)) {
          $msg = "";
          foreach($imagesErrors as $name => $message) {
            $msg .= $message . " ";
          }
          $product->addErrorMessage('productImages', trim($msg));
        }
        $this->request->csrfCheck();
        $product->assign($this->request->get(), Products::blackList);
        $product->auction_end = date('Y-m-d H:i:s',date(strtotime("+".$this->request->get("auction_time")." day", strtotime(date('Y-m-d H:i:s')))));
        $product->vendor = $this->currentUser->id;
        $product->save();
        if($product->validationPassed()) {
          //upload images
          $structuredFiles = ProductImages::restructureFiles($files);
          ProductImages::uploadProductImage($product->id,$structuredFiles);
          Session::addMsg('success', 'Product Added');
          Router::redirect('adminproduct');
        }
      }
      $this->view->categories = Categories::getOptionForForm();
      $this->view->product = $product;
      $this->view->auction_time = $auction_time;
      $this->view->formAction = PROOT . 'adminproduct/add';
      $this->view->displayErrors = $product->getErrorMessages();
      $this->view->render('admin/adminproduct/add');
    }

    public function deleteAction() {
      $resp = ['success' => false, 'msg' => "Something went wrong..."];
      if($this->request->isPost()) {
        $id = $this->request->get('id');
        $product = Products::findByIdAndUserId($id, $this->currentUser->id);
        if($product) {
        //  ProductImages::deleteImages($id, true);
          $product->delete();
          $resp = ['success' => true, 'msg' => 'Product Deleted.', 'model_id' => $id];
        }
      }
      $this->jsonResponse($resp);
    }

    public function editAction($id) {
      $user = Users::currentUser();
      $product = Products::findByIdAndUserId((int)$id, $user->id);
      $auction_time = array('7' => '1 hét', '14' => '2 hét', '21' => '3 hét');
      if(!$product) {
        Session::addMsg('danger', 'You not have permission to edit that product');
        Router::redirect('admin/adminproduct');
    }
      $images = ProductImages::findByProductId($product->id);
      if($this->request->isPost()) {
        $this->request->csrfCheck();
        $files = $_FILES['productImages'];
        $isFiles = $files['tmp_name'][0] != '';
        if($isFiles) {
          $productImage = new ProductImages();
          $imagesErrors = $productImage->validateImages($files);
          if(is_array($imagesErrors)) {
            $msg = "";
            foreach($imagesErrors as $name => $message) {
              $msg .= $message . " ";
            }
            $product->addErrorMessage('productImages', trim($msg));
          }
        }
        $product->assign($this->request->get(), Products::blackList);
        $product->user_id = $this->currentUser->id;
        $product->save();
        if($product->validationPassed()) {
          if($isFiles) {
            $structuredFiles = ProductImages::restructureFiles($files);
            ProductImages::uploadProductImage($product->id,$structuredFiles);
          }
          ProductImages::updateSortByProductId($product->id, json_decode($_POST['images_sorted']));
          Session::addMsg('success', 'Product Edited');
          Router::redirect('adminproduct');
        }
      }
      $this->view->categories = Categories::getOptionForForm();;
      $this->view->images = $images;
      $this->view->product = $product;
      $this->view->auction_time = $auction_time;
      $this->view->displayErrors = $product->getErrorMessages();
      $this->view->render('admin/adminproduct/edit');
    }
    public function deleteImageAction() {
      $resp = ['success' => false];
      if($this->request->isPost()) {
        $user = Users::currentUser();
        $id = $this->request->get('image_id');
        $image = ProductImages::findById($id);
        $product = Products::findByIdAndUserId($image->product_id, $user->id);
        if($product && $image) {
          ProductImages::deleteByid($image->id);
          $resp = ['success'=> true, 'model_id'=>$image->id];
        }
      }
      $this->jsonResponse($resp);
    }


  }
