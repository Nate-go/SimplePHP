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

    public function addCategory(RouteCollection $routes){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $content = $_POST['content'];

            $this->categoryService->add($content);
        }
        require_once $this->loadView('addCategory.php');
    }

    public function getInfoCategory($id, RouteCollection $routes){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $content = $_POST['content'];

            $this->categoryService->update($id, $content);
        }
        $category = $this->categoryService->getById($id);
        require_once $this->loadView('infoCategory.php');
    }
}