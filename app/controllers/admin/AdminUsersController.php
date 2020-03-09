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
        $limit = 6 ;
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
        $this->view->hasFilters = Users::hasFilters($options);
      $this->view->acls = Users::getOptionForForm();

      $this->view->render('admin/adminUsers/index');
    }

    public static function szotar($string) {
        switch ($string) {
            case "Admin": $acl_name = "Adminisztrátor"; break;
            case "Seller": $acl_name = "Eladó"; break;
            case "Registered": $acl_name = "Regisztrált Felhasználó"; break;
        }
        return $acl_name;
    }

    public function addAction() {
        $newUser = new Users();
        if($this->request->isPost()) {

          $this->request->csrfCheck();
          $newUser->assign($this->request->get(),Users::blackListedFormKeys);
          $newUser->confirm =$this->request->get('confirm');
          if($newUser->save()){
              if($this->request->get('address') != '' || $this->request->get('city') != '' || $this->request->get('country') != '' || $this->request->get('phone') != '' || $this->request->get('mobile_phone') != '' || $this->request->get('ostermelo_id') != '' || $this->request->get('adoszam') != '' || $this->request->get('zip_code') != '') {
                $newContact = new Contacts();
                $newContact -> assign($this->request->get());
                $newContact->user_id = Model::getDb()->lastID();
                $newContact->save();
              }
              Router::redirect('admin/adminUsers/index');
          }
        }
        $acl = $this->request->get('acl');
        $this->view->acls = Users::getOptionForForm($new = true);
        $this->view->acl = $acl;
        $this->view->formAction = PROOT . 'adminUsers/add';
        $this->view->newUser = $newUser;
        $this->view->displayErrors = $newUser->getErrorMessages();
        $this->view->render('admin/adminUsers/add');
    }

    public function deleteAction() {
      $resp = ['success' => false, 'msg' => "Something went wrong..."];
      if($this->request->isPost()) {
        $id = $this->request->get('id');
        $product = Products::findByIdAndUserId($id, $this->currentUser->id);
        if($product) {
        //  ProductImages::deleteImages($id, true);
          $product->delete();
          $resp = ['success' => true, 'msg' => 'Product Deleted.', 'model_id' => $id];
        }
      }
      $this->jsonResponse($resp);
    }

    public function editAction($id) {
     $user = Users::findById($id);
     //$contact = Contacts::findByUserId($id);
      if($this->request->isPost()) {
        $this->request->csrfCheck();
        $files = $_FILES['productImages'];
        $isFiles = $files['tmp_name'][0] != '';
        if($isFiles) {
          $productImage = new ProductImages();
          $imagesErrors = $productImage->validateImages($files);
          if(is_array($imagesErrors)) {
            $msg = "";
            foreach($imagesErrors as $name => $message) {
              $msg .= $message . " ";
            }
            $product->addErrorMessage('productImages', trim($msg));
          }
        }
        $product->assign($this->request->get(), Products::blackList);
        $product->user_id = $this->currentUser->id;
        $product->save();
        if($product->validationPassed()) {
          if($isFiles) {
            $structuredFiles = ProductImages::restructureFiles($files);
            ProductImages::uploadProductImage($product->id,$structuredFiles);
          }
          ProductImages::updateSortByProductId($product->id, json_decode($_POST['images_sorted']));
          Session::addMsg('success', 'Product Edited');
          Router::redirect('adminproduct');
        }
      }
      $acl = $this->request->get('acl');
      $this->view->acls = Users::getOptionForForm($new = true);
      $this->view->acl = $acl;
      $this->view->formAction = PROOT . 'adminUsers/edit';
      $this->view->user = $user;
      //$this->view->contact = $contact;
      $this->view->displayErrors = $user->getErrorMessages();
      $this->view->render('admin/adminUsers/edit');
    }

  }