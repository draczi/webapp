<?php
namespace App\Controllers;
use Core\Controller;
use Core\H;
use Core\Emails;
use Core\Model;
use App\Models\Users;
use App\Models\Products;
use App\Models\Binds;
use App\Models\Categories;

class HomeController extends Controller{

    public function indexAction() {
        Products::closedAuctions();

        (!empty($_GET))?$search = $_GET['search'] : $search = '';
        (!empty($_GET))?$min_price = $_GET['min_price'] : $min_price = '';
        (!empty($_GET))?$max_price = $_GET['max_price'] : $max_price = '';
        (!empty($_GET))?$category = $_GET['category'] : $category = '';
        $page = (!empty($_GET['page'])) ? $_GET['page'] : 1;
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
