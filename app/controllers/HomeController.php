<?php
  namespace App\Controllers;
  use Core\Controller;
  use Core\H;
  use App\Models\Users;
  use App\Models\Products;

  class HomeController extends Controller{

    public function indexAction() {
     $pModel = new Products();
     $products = $pModel->allProducts();
     $this->view->products = $products;
     $this->view->render('home/index');
   }

    // public function testAjaxAction() {
    //   $resp = ['success' => true, 'data' => ['id' =>23, 'name' => 'Isi', 'favorite_food' => 'pizza']];
    //   $this->jsonResponse($resp);
    // }
  }
