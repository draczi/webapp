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
use App\Models\Categories;
use App\Models\Bids;


class AdminProductsController extends Controller {

    public function onConstruct() {
        $this->view->setLayout('admin');
        $this->currentUser = Users::currentUser();
    }

    public function indexAction() {
        $search = $this->request->get('search');
        $category = $this->request->get('category');
        $vendor = $this->request->get('vendor');
        $actual = $this->request->get('actual');
        $page = (!empty($this->request->get('page'))) ? $this->request->get('page') : 1;
        $limit = 15 ;
        $offset = ($page - 1) * $limit;
        $options = [
            'search'=>$search, 'vendor' => $vendor, 'category' =>  $category, 'actual' => $actual, 'limit' => $limit, 'offset' => $offset
        ];
        $results = Products::allProducts($options, $admin=true);
        $products = $results['results'];
        $total = $results['total'];
        $this->view->page = $page;
        $this->view->totalPages = ceil($total / $limit);
        $this->view->products = $products;
        $this->view->category = $category;
        $this->view->search = $search;
        $this->view->vendor = $vendor;
        $this->view->actual = $actual;
        $this->view->categoryOptions = Categories::getOptionForForm();
        $this->view->vendorOptions = Products::getOptionVendor();
        $this->view->statusOptions = array('0' => 'Minden aukció', '-1' => 'Aktív', '1' => 'Inaktív');
        $this->view->users = $this->currentUser->id;
        $this->view->render('admin/adminProducts/index');
    }

    public function addAction() {
        $product = new Products();
        $productImage = new ProductImages();
        $auction_time = array('7' => '1 hét', '14' => '2 hét', '21' => '3 hét');
        if($this->request->isPost()) {
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
            $product->auction_end = date('Y-m-d H:i:s',date(strtotime("+".$this->request->get("auction_time")." day", strtotime(date('Y-m-d H:i:s')))));
            $product->vendor = $this->currentUser->id;
            $product->save();
            if($product->validationPassed()) {
                //upload images
                $structuredFiles = ProductImages::restructureFiles($files);
                ProductImages::uploadProductImage($product->id,$structuredFiles);
                Session::addMsg('success', 'Termék hozzáadva');
                Router::redirect('adminProducts');
            }
        }
        $this->view->categories = Categories::getOptionForForm();
        $this->view->product = $product;
        $this->view->auction_time = $auction_time;
        $this->view->formAction = PROOT . 'adminProducts/add';
        $this->view->displayErrors = $product->getErrorMessages();
        $this->view->render('admin/adminProducts/add');
    }

    public function deleteAction(){
        $resp = ['success'=>false,'msg'=>'Valami nincs rendben...'];
        if($this->request->isPost()){
            $id = $this->request->get('id');
            $product = Products::findAllById($id);
            $bids = Bids::findProductBid($product->id);
            if($bids && $product->auction_end > date('Y-m-d H:m:s')) {
                 $resp = ['success' => false, 'msg' => 'A terméket nem lehet törölni, mert aktív és érvényes licit tartozik hozzá.','model_id' => $id];
                 $this->jsonResponse($resp);
            }
            if($product){
                $bids->adminDelete();
                ProductImages::deleteImages($id, $unlink = true);
                $product->adminDelete();
                $resp = ['success' => true, 'msg' => 'A termék törölve lett.','model_id' => $id];
            }
        }
        $this->jsonResponse($resp);
    }

    public function editAction($id) {
        $product = Products::findById((int)$id);
        $auction_time = array('7' => '1 hét', '14' => '2 hét', '21' => '3 hét');
        $images = ProductImages::findByProductId($product->id);
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
                Session::addMsg('success', 'Termékadatokat módosítottad.');
                Router::redirect('adminProducts');
            }
        }
        $this->view->categories = Categories::getOptionForForm();;
        $this->view->images = $images;
        $this->view->product = $product;
        $this->view->auction_time = $auction_time;
        $this->view->displayErrors = $product->getErrorMessages();
        $this->view->render('admin/adminProducts/edit');
    }

    function deleteImageAction(){
        $resp = ['success'=>false,'msg'=>'Valami nincs rendben...'];
        if($this->request->isPost()){
            $id = $this->request->get('id');
            $image = ProductImages::findById($id);
            $product = Products::findById($image->product_id);
            if($product && $image){
                ProductImages::deleteById($image->id);
                $resp = ['success' => true, 'msg' => 'A kép törölve lett.','model_id' => $image->id];
            }
        }
        $this->jsonResponse($resp);
    }

}
