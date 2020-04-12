<?php
namespace App\Controllers;
use Core\Controller;
use Core\H;
use App\Models\Users;
use App\Models\Products;
use App\Models\Binds;
use App\Models\Categories;

class HomeController extends Controller{
    
    public function indexAction() {
        Products::closedAuctions();
        $search = $this->request->get('search');
        $min_price = $this->request->get('min_price');
        $max_price = $this->request->get('max_price');
        $category = $this->request->get('category');
        $page = (!empty($this->request->get('page'))) ? $this->request->get('page') : 1;
        $limit = 6 ;
        $offset = ($page - 1) * $limit;
        $options = [
            'search'=>$search, 'min_price' => $min_price, 'max_price' => $max_price, 'category' =>  $category, 'limit' => $limit, 'offset' => $offset
        ];
        $results = Products::allProducts($options);
        $products = $results['results'];
        $total = $results['total'];
        $this->view->page = $page;
        $this->view->totalPages = ceil($total / $limit);
        $this->view->products = $products;
        $this->view->min_price =$min_price;
        $this->view->max_price = $max_price;
        $this->view->category = $category;
        $this->view->search = $search;
        $this->view->categoryOptions = Categories::getOptionForForm();
        $this->view->render('home/index');
    }
}
