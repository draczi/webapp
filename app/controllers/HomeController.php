<?php
  namespace App\Controllers;
  use Core\Controller;
  use Core\H;
  use App\Models\Users;
  use App\Models\Products;

  class HomeController extends Controller{

    public function indexAction() {
      $search = $this->request->get('search');
      $min_price = $this->request->get('min_price');
      $max_price = $this->request->get('max_price');
      $brand = $this->request->get('brand');
      $page = (!empty($this->request->get('page'))) ? $this->request->get('page') : 1;
      $limit = 6 ;
      $offset = ($page - 1) * $limit;
      $bids = $this->request->get('bids');H::dnd($bids);
      $options = [
        'search'=>$search, 'min_price' => $min_price, 'max_price' => $max_price, 'brand' => $brand, 'limit' => $limit, 'offset' => $offset
      ];

     $results = Products::allProducts($options); //H::dnd($results);
     $products = $results['results'];
     $total = $results['total'];
     $this->view->page = $page;
     $this->view->totalPages = ceil($total / $limit);
     $this->view->products = $products;
     $this->view->min_price =$min_price;
     $this->view->max_price = $max_price;
     $this->view->brand = $brand;
     $this->view->search = $search;
     $this->view->hasFilters = Products::hasFilters($options);
     $this->view->brandOptions = [];
     $this->view->render('home/index');
   }

    // public function testAjaxAction() {
    //   $resp = ['success' => true, 'data' => ['id' =>23, 'name' => 'Isi', 'favorite_food' => 'pizza']];
    //   $this->jsonResponse($resp);
    // }
  }
