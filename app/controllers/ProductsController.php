<?php
  namespace App\Controllers;
  use Core\Controller;
  use Core\H;
  use Core\Router;
  use Core\Session;
  use App\Models\Users;
  use App\Models\Products;
  use App\Models\Bids;
  use Core\DB;


  class ProductsController extends Controller{

    public function detailsAction($product_id) {
      $optionBid[] = '';
      $optionVendor[] = '';
      $user = Users::currentUser();
      $product = Products::findById((int)$product_id);
      $bid = Bids::findProductBind($product->id);
      if ($bid) {
         $bidUser = Users::findUserName($bid->user_id);
         $optionBid = ['bid' => $bid->bid_amount, 'bid_user' => $bidUser->username];
         $this->view->bid = $optionBid;
      }
      $vendor = Users::findUserName($product->vendor);
      $optionVendor = ['vendor' => $vendor->username, 'login_date' => $vendor->login_date];
      $min_price = $product->price + $product->bid_increment;

     if(!$product) {
       Session::addMsg('danger', "Ooops ... that product isn't available.");
       Router::redirect('home');
     }

     $this->view->product = $product;
     $this->view->vendor = $optionVendor;
     $this->view->user = $user;
     $this->view->images = $product->getImages();//H::dnd($this->view->images);
     $this->view->render('home/products/details');

  }

  public function addAction() {

    $bid = new Bids();
    $db = DB::getInstance();
    if($this->request->isPost()) {
      $bid->assign($this->request->get());
      $lastLicit = Bids::findProductBind($bid->product_id);
      if (!$lastLicitUser = Bids::findProductAndUserBind($bid->product_id, $bid->user_id)) {
        $bid->save();
        $errorM = $bid->getErrorMessages();
        if($bid->validationPassed()) {
          if($lastLicit) $db->query("UPDATE bids SET deleted = 1 WHERE id = ".$lastLicit->id);
          Session::addMsg('success', 'Gratulálunk, sikeresen licitált a termékre.');

        } else {
          foreach($errorM as $error => $val) {
            Session::addMsg('danger',  $val);
          }

        }
      } else {
        Session::addMsg('danger', "Korábban már licitált, Ön vezeti a licitet.");
      }
        Router::redirect('products/details/'.$bid->product_id);

     H::dnd($bid->getErrorMessages());

    }
  }

  public static function closeBidsAction($product_id) {
    $db = DB::getInstance();
    return $db->query("UPDATE products SET deleted = 1 WHERE id= " .$product_id );
  }
}
