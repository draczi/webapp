<?php
namespace App\Controllers\Admin;
use Core\Controller;
use Core\Model;
use Core\Session;
use Core\Router;
use Core\H;
use App\Models\Products;
use App\Models\ProductImages;
use App\Models\Users;
use App\Models\Bids;
use App\Models\Contacts;
use App\Models\Categories;


class AdminUsersController extends Controller {

    public function onConstruct() {
        $this->view->setLayout('admin');
        $this->currentUser = Users::currentUser();
    }

    public function indexAction() {
        $search = $this->request->get('search');
        $acl = $this->request->get('acl');
        $page = (!empty($this->request->get('page'))) ? $this->request->get('page') : 1;
        $limit = 15 ;
        $offset = ($page - 1) * $limit;
        $options = [
            'search'=>$search, 'acl' =>  $acl, 'limit' => $limit, 'offset' => $offset
        ];

        $results = Users::allUsers($options);
        $users = $results['results'];
        $total = $results['total'];
        $this->view->page = $page;
        $this->view->totalPages = ceil($total / $limit);
        $this->view->users = $users;
        $this->view->acl = $acl;
        $this->view->search = $search;
        $this->view->acls = Users::getOptionAcls();
        $this->view->render('admin/adminUsers/index');
    }

    public static function szotar($string) {
        switch ($string) {
            case "Administrator": $acl_name = "Adminisztrátor"; break;
            case "Seller": $acl_name = "Eladó"; break;
            case "Registered": $acl_name = "Regisztrált Felhasználó"; break;
        }
        return $acl_name;
    }

    public function deleteAction(){
        $resp = ['success'=>false,'msg'=>'Valami nincs rendben...'];
        if($this->request->isPost()){
            $id = $this->request->get('id');
            $user = Users::findById($id);
            $product = Products::findByUserIdAndImages($user->id);
            $bids = Bids::findUserBid($user->id);
            if ($product || $bids) {
                $resp = ['success' => false, 'msg' => 'a felhasználót nem lehet törölni.','model_id' => $id];
                $this->jsonResponse($resp);
            } else if ($this->currentUser->id == $user->id) {
                $resp = ['success' => false, 'msg' => 'A saját fiókod nem törölheted!','model_id' => $id];
                $this->jsonResponse($resp);
            }
            if($user){
                if($product) Products::deleteProducts($user->id);
                $user->delete();
                $resp = ['success' => true, 'msg' => 'A felhasználó törölve lett.','model_id' => $id];
            }
        }
        $this->jsonResponse($resp);
    }

    public function editAction($id) {
        $user = Users::findById($id);
        if($this->request->isPost()) {
            $this->request->csrfCheck();
            $user->assign($this->request->get(),Users::blackListedFormKeys);
            $user->confirm =$this->request->get('confirm');
            if($user->save()){
                Session::addMsg('success', 'Sikeresen megváltoztattad ' .$user->username . ' adatait.');
                Router::redirect('adminUsers');
            }
        }
        $acl = $this->request->get('acl');
        $this->view->acls = Users::getOptionAcls($new = true);
        $this->view->acl = $acl;
        $this->view->user = $user;
        $this->view->displayErrors = $user->getErrorMessages();
        $this->view->render('admin/adminUsers/edit');
    }

}
