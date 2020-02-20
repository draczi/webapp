<?php
  namespace App\Controllers;
  use Core\Controller;
  use Core\H;
  use App\Models\Users;
  use App\Models\Products;
  use App\Models\Binds;
  use App\Models\Categories;

  class HomeController extends Controller{

    public function indexAction() {
      $search = $this->request->get('search');
      $min_price = $this->request->get('min_price');
      $max_price = $this->request->get('max_price');
      $category = $this->request->get('category');
      $page = (!empty($this->request->get('page'))) ? $this->request->get('page') : 1;
      $limit = 6 ;
      $offset = ($page - 1) * $limit;
      $options = [
        'search'=>$search, 'min_price' => $min_price, 'max_price' => $max_price, 'category' =>  $category, 'limit' => $limit, 'offset' => $offset
      ];
     $results = Products::allProducts($options); //H::dnd($results);
     $products = $results['results'];
     $total = $results['total'];
     $this->view->page = $page;
     $this->view->totalPages = ceil($total / $limit);
     $this->view->products = $products;
     $this->view->min_price =$min_price;
     $this->view->max_price = $max_price;
     $this->view->category = $category;
     $this->view->search = $search;
     $this->view->hasFilters = Products::hasFilters($options);
     $this->view->categoryOptions = Categories::getOptionForForm();
     $this->view->render('home/index');
   }

   public function detailsAction($product_id) {
     $optionBid[] = '';
     $optionVendor[] = '';
     $user = Users::currentUser();
     $product = Products::findById((int)$product_id);
     $bid = Bids::findProductBind($product->id);
     if ($bid) {
        $bidUser = Users::findUserName($bid->user_id);
        $optionBid = ['bid' => $bid->bid_amount, 'bid_user' => $bidUser->username ];
        $this->view->bid = $optionBid;
     }
     $vendor = Users::findUserName($product->vendor);
     $optionVendor = ['vendor' => $vendor->username, 'login_date' => $vendor->login_date];

    if(!$product) {
      Session::addMsg('danger', "Ooops ... that product isn't available.");
      Router::redirect('home');
    }

    $this->view->product = $product;
    $this->view->vendor = $optionVendor;
    $this->view->user = $user;
    $this->view->images = $product->getImages();//H::dnd($this->view->images);
    $this->view->render('home/details');

 }

  }
