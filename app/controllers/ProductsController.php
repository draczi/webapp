<?php
  namespace App\Controllers;
  use Core\Controller;
  use Core\H;
  use Core\Router;
  use Core\Session;
  use App\Models\Users;
  use App\Models\Products;
  use App\Models\ProductImages;
  use App\Models\Categories;
  use App\Models\Bids;
  use Core\Database;
  use App\Models\Messages;


  class ProductsController extends Controller{
      public function onConstruct() {
        $this->view->setLayout('default');
        $this->currentUser = Users::currentUser();
      }

      public function indexAction() {
        $this->view->users = $this->currentUser->id;
        $this->view->products = Products::findByUserIdAndImages($this->currentUser->id);
        $this->view->render('home/products/index');
      }

      public function closedAuctionAction() {
        $this->view->users = $this->currentUser->id;
        $this->view->noSolds = Products::auctionEndNotSold($this->currentUser->id);
        $this->view->solds = Products::auctionEndSold($this->currentUser->id);
        $this->view->render('home/products/closedAuction');
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
          $product->vendor = $this->currentUser->id;
          $product->auction_end = date('Y-m-d H:i:s',date(strtotime("+".$this->request->get("auction_time")." day", strtotime(date('Y-m-d H:i:s')))));
          $product->save();
          if($product->validationPassed()) {
            //upload images
            $structuredFiles = ProductImages::restructureFiles($files);
            ProductImages::uploadProductImage($product->id,$structuredFiles);
            Session::addMsg('success', 'A terméket sikeresen feltöltötte.');
            Router::redirect('products');
          }
      }
        $this->view->categories = Categories::getOptionForForm();
        $this->view->product = $product;
        $this->view->formAction = PROOT . 'products/add';
        $this->view->auction_time = $auction_time;
        $this->view->displayErrors = $product->getErrorMessages();
        $this->view->render('home/products/add');
      }

      public function editAction($id) {
        $user = Users::currentUser();
        $product = Products::findByIdAndUserId((int)$id, $user->id);
        if(!$product) {
          Session::addMsg('danger', 'Csak a saját termékét módosíthatja.');
          Router::redirect('home/products');
        }
        $auction_time = array('7' => '1 hét', '14' => '2 hét', '21' => '3 hét');
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
            Session::addMsg('success', 'A terméket sikeresen módosította.');
            Router::redirect('products');
          }
        }
        $this->view->categories = Categories::getOptionForForm();
        $this->view->images = $images;
        $this->view->product = $product;
        $this->view->auction_time = $auction_time;
        $this->view->displayErrors = $product->getErrorMessages();
        $this->view->render('home/products/edit');
      }

      public function deleteAction(){
          $resp = ['success'=>false,'msg'=>'Valami nincs rendben...'];
          if($this->request->isPost()){
              $id = $this->request->get('id');
              $product = Products::findByIdAndUserId($id, $this->currentUser->id);
              $bids = Bids::findProductBid($product->id);
              if($bids) {
                   $resp = ['success' => false, 'msg' => 'A terméket nem lehet törölni.','model_id' => $id];
                   $this->jsonResponse($resp);
              }
              if($product){
                  $product->delete();
                  $resp = ['success' => true, 'msg' => 'A termék törölve lett.','model_id' => $id];
              }
          }
          $this->jsonResponse($resp);
      }

      function deleteImageAction(){
          $resp = ['success'=>false,'msg'=>'Valami nincs rendben...'];
          if($this->request->isPost()){
              $id = $this->request->get('id');
              $image = ProductImages::findById($id);
              $product = Products::findById($image->product_id);
              if($product && $image){
              ProductImages::deleteById($image->id);
                  $resp = ['success' => true, 'msg' => 'A kép törölve lett.','model_id' => $image->id];
              }
          }
          $this->jsonResponse($resp);
      }

    public function detailsAction($product_id) {
      $optionBid[] = '';
      $optionVendor[] = '';
      $user = Users::currentUser();
      $product = Products::findById((int)$product_id);
      $bid = Bids::findProductBid($product->id);
      if ($bid) {
         $bidUser = Users::findById($bid->user_id);
         $optionBid = ['bid' => $bid->bid_amount, 'bid_user' => $bidUser->username];
         $this->view->bid = $optionBid;
      }
      $vendor = Users::findById($product->vendor);
      $optionVendor = ['vendor' => $vendor->username, 'login_date' => $vendor->login_date, 'created_date' => $vendor->created_date, 'city' => $vendor->city];
      $min_price = $product->price + $product->bid_increment;

     if(!$product) {
       Session::addMsg('danger', "Ooops a Termék már elérhető! Valószínű lejárt az árverés.");
       Router::redirect('home');
     }

     $this->view->product = $product;
     $this->view->vendor = $optionVendor;
     $this->view->user = $user;
     $this->view->messages = Messages::findByProductId($product_id);
     $this->view->images = $product->getImages();
     $this->view->render('home/products/details');

  }

  public function addMessageAction() {
      $msg = new Messages();
      if($this->request->isPost()) {
        $msg->assign($this->request->get());
          $msg->save();
          if($msg->validationPassed()) {
            Session::addMsg('success', 'Üzenetedet rögzítettünk! Köszönjük.');
          } else {
               $errorMessage = '';
              foreach($msg->getErrorMessages() as $error => $val) {
                  $errorMessage .= $val ."<br>";
              }
            Session::addMsg('danger',  $errorMessage);
          }
          Router::redirect('products/details/'.$msg->product_id);
      }
  }
}
