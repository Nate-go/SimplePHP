<?php
namespace App\Services;
use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Util\Autowired;

class ProductService{
    private $productRepository; 
    
    public function __construct(){
        $this->productRepository = new ProductRepository;
    }

    public function getProductById($id){
        $products = $this->productRepository->read($id);
        if(count($products) > 0) {
            return $products[0];
        } else {
            return new Product();
        }
    }
}