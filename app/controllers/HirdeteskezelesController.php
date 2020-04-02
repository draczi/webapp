<?php
  namespace App\Controllers;
  use Core\Controller;
  use Core\H;
  use Core\Session;
  use Core\Router;
  use App\Models\Users;
  use App\Models\Products;
  use App\Models\ProductImages;
  use App\Models\Categories;

  class HirdeteskezelesController extends Controller {
    public function onConstruct() {
      $this->view->setLayout('default');
      $this->currentUser = Users::currentUser();
    }
    public function indexAction() {
      $this->view->users = $this->currentUser->id;
      $this->view->products = Products::findByUserIdAndImages($this->currentUser->id);
      $this->view->render('hirdeteskezeles/index');
    }

    public function lezartarveresekAction() {
      $this->view->users = $this->currentUser->id;
      $this->view->noSolds = Products::auctionEndNotSold($this->currentUser->id);
      $this->view->solds = Products::auctionEndSold($this->currentUser->id);
      $this->view->render('hirdeteskezeles/lezartarveresek');
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
        $this->request->csrfCheck();//H::dnd($this->request->get());
        $product->assign($this->request->get(), Products::blackList);
        $product->vendor = $this->currentUser->id;
        $product->auction_end = date('Y-m-d H:i:s',date(strtotime("+".$this->request->get("auction_time")." day", strtotime(date('Y-m-d H:i:s')))));
        $product->save();
        if($product->validationPassed()) {
          //upload images
          $structuredFiles = ProductImages::restructureFiles($files);
          ProductImages::uploadProductImage($product->id,$structuredFiles);
          Session::addMsg('success', 'Product Added');
          Router::redirect('hirdeteskezeles');
        }
      }
      $this->view->categories = Categories::getOptionForForm();
      $this->view->product = $product;
      $this->view->formAction = PROOT . 'hirdeteskezeles/add';
      $this->view->auction_time = $auction_time;
      $this->view->displayErrors = $product->getErrorMessages();
      $this->view->render('hirdeteskezeles/add');
    }

    public function editAction($id) {
      $user = Users::currentUser();
      $product = Products::findByIdAndUserId((int)$id, $user->id);
      if(!$product) {
        Session::addMsg('danger', 'You not have permission to edit that product');
        Router::redirect('hirdeteskezeles');
      }
      $auction_time = array('7' => '1 hét', '14' => '2 hét', '21' => '3 hét');
      $images = ProductImages::findByProductId($product->id);//H::dnd($images);
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
          Router::redirect('hirdeteskezeles');
        }
      }
      $this->view->categories = Categories::getOptionForForm();
      $this->view->images = $images;
      $this->view->product = $product;
      $this->view->auction_time = $auction_time;
      $this->view->displayErrors = $product->getErrorMessages();
      $this->view->render('hirdeteskezeles/edit');
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

    public function deleteAction($id) {

        $product = Products::findByIdAndUserId($id, $this->currentUser->id);
        if($product){
        //  ProductImages::deleteImages($id);
          $product->delete($product->id);
          Session::addMsg('success', 'A terméket sikeresen törölted.');
        }
       Router::redirect('hirdeteskezeles');
    }


  }
