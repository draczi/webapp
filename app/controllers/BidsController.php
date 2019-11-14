<?php
  namespace App\Controllers;
  use Core\Controller;
  use App\Models\Users;
  use App\Models\Products;

  class BidsController extends Controller {
    public function onConstruct() {
      $this->view->setLayout('default');
      $this->currentUser = Users::currentUser();
    }

    public function detailsAction() {
      $product = new bids();
      if($this->request->isPost()) {
        $a = 'hello';
      }H::dnd($a);

      $this->view->formAction = PROOT . 'products/details';
      //$this->view->displayErrors = $product->getErrorMessages();
      $this->view->render('hirdeteskezeles/add');
    }

}
