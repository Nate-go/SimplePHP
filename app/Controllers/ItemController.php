<?php 
namespace App\Controllers;
use App\Services\CategoryService;
use App\Services\ItemService;
use Symfony\Component\Routing\RouteCollection;

class ItemController extends BaseController
{
    private $itemService; 
    private $categoryService;
    public function __construct(){
        $this->itemService = new ItemService();
        $this->categoryService = new CategoryService();
    }

    public function addItem($id=null, RouteCollection $routes){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $content = $_POST['content'];
            $category = $_POST['category'];
            $status = $_POST['status'];
            $finishedTime = $_POST['finishedTime'];
        
            $this->itemService->add($title, $content, $category, $status, $finishedTime, $id);

            $home = new HomeController();
            $home->loadHome($routes);
        } else {
            $allCategories = $this->categoryService->getAll();
            require_once $this->loadView('addItem.php');
        }
        
    }

    public function deleteItem($id, RouteCollection $routes){
        $this->itemService->delete($id);
        $home = new HomeController();
        $home->loadHome($routes);
    }
}