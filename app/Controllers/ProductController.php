<?php 
namespace App\Controllers;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Symfony\Component\Routing\RouteCollection;

class ProductController
{
    public $productRepo; 

    public function showAction(int $id, RouteCollection $routes)
    {
        $this->productRepo = new ProductRepository();
        $products = $this->productRepo->read($id);
        if (count($products) > 0) {
            $product = $products[0];
        } else {
            $product = new Product;
        }
        

        require_once APP_ROOT . '/views/product.php';
    }
}