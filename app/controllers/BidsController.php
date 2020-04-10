<?php
  namespace App\Controllers;
  use Core\Controller;
  use Core\H;
  use Core\Router;
  use Core\Session;
  use App\Models\Users;
  use App\Models\Products;
  use App\Models\Bids;

  class BidsController extends Controller{

    public function onConstruct() {
      $this->view->setLayout('default');
      $this->currentUser = Users::currentUser();
    }

    //licit megvalósítása
    public function addAction() {
      $bid = new Bids();
      if($this->request->isPost()) {
        $bid->assign($this->request->get());
        $product = Products::findById($bid->product_id);
          $lastBid = Bids::findProductBid($bid->product_id);
          $bid->save();
          if($bid->validationPassed()) {
            if($lastBid) $lastBid->delete($lastBid->id);
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

}
