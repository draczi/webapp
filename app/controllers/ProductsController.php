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

  public static function closeBidsAction($product_id) {
    $db = DB::getInstance();
    return $db->query("UPDATE products SET deleted = 1 WHERE id= " .$product_id );
  }
}
