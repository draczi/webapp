<?php
  namespace App\Controllers;
  use Core\Controller;
  use Core\FH;
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
       Session::addMsg('danger', "Ooops a Termék nem elérhető!!!");
       Router::redirect('home');
     }

     $this->view->product = $product;
     $this->view->vendor = $optionVendor;
     $this->view->user = $user;
     $this->view->images = $product->getImages();
     $this->view->render('home/products/details');

  }

  //licit megvalósítása
  public function addAction() {
    $bid = new Bids();
    $db = DB::getInstance();
    if($this->request->isPost()) {
      $bid->assign($this->request->get());
      $lastLicit = Bids::findProductBind($bid->product_id);
        $bid->save();
        if($bid->validationPassed()) {
          if($lastLicit) $db->query("UPDATE bids SET deleted = 1 WHERE id = ".$lastLicit->id);
          Session::addMsg('success', 'Gratulálunk, sikeresen licitált a termékre.');
        } else {
             $errorMessage = '';
            foreach($bid->getErrorMessages() as $error => $val) {
                $errorMessage .= $val ."<br>";
            }
          Session::addMsg('danger',  $errorMessage);
        }

        Router::redirect('products/details/'.$bid->product_id);
    }
  }

  public static function closeBidsAction($product_id) {
    $db = DB::getInstance();
    return $db->query("UPDATE products SET deleted = 1 WHERE id= " .$product_id );
  }
}
