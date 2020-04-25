<?php
  namespace App\Controllers\Admin;
  use Core\Controller;
  use App\Models\Users;
  use App\Models\Products;
  use App\Models\Categories;
  use Core\H;
  use Core\Session;
  use Core\Router;
  use Core\Database;;


  class AdminCategoriesController extends Controller {

    public function onConstruct() {
      $this->view->setLayout('admin');
      $this->currentUser = Users::currentUser();
    }

    public function indexAction() {
      $this->view->categories = Categories::allCategories();
      $this->view->render('admin/adminCategories/index');
    }

    public function addAction() {
      $categories = new Categories();
      if($this->request->isPost()) {
        $this->request->csrfCheck();
        $categories->assign($this->request->get());
        $categories->save();
        if($categories->validationPassed()) {
          Session::addMsg('success', 'Új kategoria hozzáadva');
          Router::redirect('adminCategories');
        }
      }
      $this->view->category_parent = Categories::getCategoryParentForForm();
      $this->view->formAction = PROOT . 'adminCategories/add';
      $this->view->displayErrors = $categories->getErrorMessages();
      $this->view->categories = $categories;
      $this->view->render('admin/adminCategories/add');
    }

    public function editAction($id) {
      $categories = Categories::findById((int)$id);
      if($categories->parent == '') {
          Session::addMsg('danger', 'Főkategória nem módosítható.');
          Router::redirect('adminCategories');
      }
      if($this->request->isPost()) {
        $this->request->csrfCheck();
        $categories->assign($this->request->get());
        $categories->save();
        if($categories->validationPassed()) {
          Session::addMsg('success', 'Sikeresen módosítottad a kategóriát.');
          Router::redirect('adminCategories');
        }
      }
      $this->view->parent = Categories::getCategoryParentForForm();
      $this->view->categories = $categories;
      $this->view->displayErrors = $categories->getErrorMessages();
      $this->view->render('admin/adminCategories/edit');
    }

    public function deleteAction(){
        $resp = ['success'=>false,'msg'=>'Valami nincs rendben...'];
        if($this->request->isPost()){
            $id = $this->request->get('id');
            $category = Categories::findById($id);
            $products = Products::findByCategory($category->id);
            $parent = Categories::findParentById($id);
            if($products || $parent) {
                $resp = ['success' => false, 'msg' => 'A kategória nem törölhető!', 'model_id' => $id];
                $this->jsonResponse($resp);
            }
            if($category){
                $category->delete();
                $resp = ['success' => true, 'msg' => 'A kategória törölve lett.','model_id' => $id];
            }
        }
        $this->jsonResponse($resp);
    }
  }
