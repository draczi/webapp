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



}
