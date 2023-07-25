<?php 
namespace App\Controllers;
use App\Models\Product;
use App\Repositories\ProductRepository;

use App\Services\ProductService;
use App\Util\Autowired;
use Symfony\Component\Routing\RouteCollection;

class ProductController extends BaseController
{
    private $productService; 

    public function __construct(){
        $this->productService = new ProductService();
    }

    public function productInfo(int $id, RouteCollection $routes)
    {
        $product = $this->productService->getProductById($id);
        require_once $this->loadView('product.php');
    }
}