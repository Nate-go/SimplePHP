<?php 
namespace App\Controllers;
use App\Services\CategoryService;
use Symfony\Component\Routing\RouteCollection;

class CategoryController extends BaseController
{
    private $categoryService; 

    public function __construct(){
        $this->categoryService = new CategoryService();
    }
}