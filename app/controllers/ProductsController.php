<?php
  namespace App\Controllers;
  use Core\Controller;
  use Core\H;
  use Core\Router;
  use Core\Session;
  use App\Models\Users;
  use App\Models\Products;

  class ProductsController extends Controller{

    public function detailsAction($product_id) {
     $product = Products::findById((int)$product_id);
     if(!$product) {
       Session::addMsg('danger', "Ooops ... that product isn't available.");
       Router::redirect('/home');
     }
     //:dnd($product);
     $this->view->product = $product;
     $this->view->images = $product->getImages();//H::dnd($this->view->images);
     $this->view->render('home/products/details');

  }
  }
