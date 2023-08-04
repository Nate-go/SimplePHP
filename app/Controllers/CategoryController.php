<?php 
namespace App\Controllers;
use App\Services\CategoryService;
use App\Services\ItemService;
use Symfony\Component\Routing\RouteCollection;

class CategoryController extends BaseController
{
    private $categoryService; 
    private $itemService;

    public function __construct(){
        $this->categoryService = new CategoryService();
        $this->itemService = new ItemService();
    }

    public function loadAddCategory(RouteCollection $routes){
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'POST':
              $this->postMethodAddCategory($routes);
              break;
            case 'GET':
              $this->getMethodAddCategory($routes);
              break;
        }
    }
    private function getMethodAddCategory(RouteCollection $routes){
        require_once $this->loadView('addCategory.php');
    }
    private function postMethodAddCategory(RouteCollection $routes){
        if(isset($_POST['content'])) {
            $content = $_POST['content'];

            $this->categoryService->add($content);
        }
        $this->getMethodAddCategory($routes);
    }

    public function loadInfoCategory($id, RouteCollection $routes){
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'POST':
              $this->postMethodInfoCategory($id, $routes);
              break;
            case 'GET':
              $this->getMethodInfoCategory($id, $routes);
              break;
        }
    }

    private function postMethodInfoCategory($id, RouteCollection $routes) {
        if(isset($_POST['content'])) {
            $content = $_POST['content'];

            $this->categoryService->update($id, $content);
        } else {
            $this->deleteItem();
        }
        $this->getMethodInfoCategory($id, $routes);
    }

    private function deleteItem() {
        $modelId = $_POST['id'];
        $this->itemService->delete(intval($modelId));
    }

    private function getMethodInfoCategory($id, RouteCollection $routes) {
        $allItems = $this->itemService->getByCategory($id);
        $category = $this->categoryService->getById($id);
        $allCategories = $this->categoryService->getAll();
        $categories = array();
        foreach ($allCategories as $category) {
            $categories[$category->getId()] = $category->getContent();                                 
        }
        require_once $this->loadView('infoCategory.php');
    }
}