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

    public function addAction() {

      $bid = new Bids();
      $db = DB::getInstance();
      if($this->request->isPost()) {
        $bid->assign($this->request->get());
        $lastLicit = Bids::findProductBind($bid->product_id);
        if (!$lastLicitUser = Bids::findProductAndUserBind($bid->product_id, $bid->user_id)) {
          $bid->save();
          $errorM = $bid->getErrorMessages();
          if($bid->validationPassed()) {
            if($lastLicit) $db->query("UPDATE bids SET deleted = 1 WHERE id = ".$lastLicit->id);
            Session::addMsg('success', 'Gratulálunk, sikeresen licitált a termékre.');

          } else {
            foreach($errorM as $error => $val) {
              Session::addMsg('danger',  $val);
            }

          }
        } else {
          Session::addMsg('danger', "Korábban már licitált, Ön vezeti a licitet.");
        }
          Router::redirect('products/details/'.$bid->product_id);

       H::dnd($bid->getErrorMessages());

      }
    }

}
