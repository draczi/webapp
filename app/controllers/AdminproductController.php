<?php
  namespace App\Controllers;
  use Core\Controller;
  use App\Models\Products;
  use Core\H;
  use App\Models\ProductImages;
  use App\Models\Users;
  use Core\Model;

  class AdminproductController extends Controller {

    public function __construct($controller, $action) {
      parent::__construct($controller, $action);
      $this->view->setLayout('admin');
      $this->currentUser = Users::currentUser();
    }

    public function indexAction() {
      $this->view->products = Products::findByUserId($this->currentUser->id, ['order' => 'name']);
      $this->view->render('adminproduct/index');
    }

    public function addAction() {
      $product = new Products();
      $productImage = new ProductImages();
      if($this->request->isPost()) {
        $currentUser = Users::currentLoggedInUser();
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
        $product->user_id = $currentUser->id;
        $product->save();
        if($product->validationPassed()) {
          //upload images
          $structuredFiles = ProductImages::restructureFiles($files);
          ProductImages::uploadProductImage($product->id,$structuredFiles);
        }
      }
      $this->view->product = $product;
      $this->view->formAction = PROOT . 'adminproduct/add';
      $this->view->displayErrors = $product->getErrorMessages();
      $this->view->render('adminproduct/add');
    }

  }
