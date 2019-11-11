<?php
  namespace App\Controllers;
  use Core\Controller;
  use App\Models\Users;
  use App\Models\Brands;
  use Core\H;


  class AdminBrandsController extends Controller {

    public function onConstruct() {
      $this->view->setLayout('admin');
      $this->currentUser = Users::currentUser();
    }

    public function indexAction() {
      $brand = new Brands();

      $this->view->brand = $brand;
      $this->view->formErrors = $brand->getErrorMessages();
      $this->view->brands = Brands::find(['order'=>'name']);
      $this->view->render('adminbrands/index');
    }

    public function saveAction(){
      if($this->request->isPost()){ 
        $brand_id =   $this->request->get('brand_id');
        $brand = ($brand_id == 'new')? new Brands() : Brands::findFirst(['conditions' => 'id = ?', 'bind' => [$id]]);;
        $brand->name = $this->request->get('name');
        if($brand){
          $brand->user_id = $this->currentUser->id;
          $brand->name = $this->request->get('name');
          if($brand->save()){
            $resp = ['success'=>true, 'brand'=>$brand->data()];
           } else {
            $resp = ['success'=>false,'errors'=>$brand->getErrorMessages()];
          }
        }
      }
      $this->jsonResponse($resp);
    }

      public function deleteAction() {

        if($this->request->isPost()) {
          $id = (int)$this->request->get('id');
          $brand = Brands::findFirst([
            'conditions' => 'id = ?',
            'bind' => [$id]
          ]);
          $resp = ['success' => false];
          if($brand) {
            $brand->delete();
            $resp['success'] = true;
            $resp['mode_id'] = $id;
          }
          $this-> jsonResponse($resp);
        }
      }
      public function getBrandByIdAction(){
        if($this->request->isPost()){
          $id = (int)$this->request->get('id');
          $brand = Brands::findFirst([
            'conditions' => 'id = ?',
            'bind' => [$id]
          ]);
          $resp = ['success'=>false];
          if($brand){
            $resp['success'] = true;
            $resp['brand'] = $brand->data();
          }
          $this->jsonResponse($resp);
        }
      }

  }
