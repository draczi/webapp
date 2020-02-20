<?php
  namespace App\Controllers\Admin;
  use Core\Controller;
  use App\Models\Users;
  use App\Models\Categories;
  use Core\H;
  use Core\Session;
  use Core\Router;
  use Core\DB;


  class AdminCategoriesController extends Controller {

    public function onConstruct() {
      $this->view->setLayout('admin');
      $this->currentUser = Users::currentUser();
    }

    public function indexAction() {
      $categories = Categories::allCategories();

      $this->view->categories = $categories;
      //$this->view->formErrors = $brand->getErrorMessages();
    //  $categories = Categories::getCategoryParentForForm();
      //$this->view->categories = $categories; //H::dnd($this->view->categories);
      //$this->view->formErrors = $brand->getErrorMessages();
    //  $this->view->brands = Brands::find(['order'=>'name']);

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

      $categories = Categories::categoryId((int)$id);
      if(!$categories) {
        Session::addMsg('danger', 'Nincs jogod módosítani a kategóriát.');
        Router::redirect('adminCategories');
      }
      if($this->request->isPost()) {
        $this->request->csrfCheck();
        $categories->assign($this->request->get());
        $db = DB::getInstance();
      //  $db->query("UPDATE categories SET category_name = '{$categories->category_name}', parent_id = '{$categories->parent_id}' where id = " .$categories->id);
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



  }
