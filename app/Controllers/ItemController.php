<?php 
namespace App\Controllers;
use App\Models\Item;
use App\Services\CategoryService;
use App\Services\ItemService;
use Symfony\Component\Routing\RouteCollection;

class ItemController extends BaseController
{
    const ITEM_MODEL = 0;
    const CATEGORY_MODEL = 1;
    private $itemService; 
    private $categoryService;
    public function __construct(){
        $this->itemService = new ItemService();
        $this->categoryService = new CategoryService();
    }

    public function loadAddItem($id=null, RouteCollection $routes){
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'POST':
              $this->postMethodAddItem($id,$routes);
              break;
            case 'GET':
              $this->getMethodAddItem($id, $routes);
              break;
        }
    }

    private function getMethodAddItem($id, RouteCollection $routes){
        $allCategories = $this->categoryService->getAll();
        $categories = array();
        foreach ($allCategories as $category) {
            $categories[$category->getId()] = $category->getContent();                                 
        }
        $parentItem = $id === null ? new Item() : $this->itemService->getById($id);
        require_once $this->loadView('addItem.php');
    }

    private function postMethodAddItem($id, RouteCollection $routes){
        if(isset($_POST['title'])) {
            $title = $_POST['title'];
            $content = $_POST['content'];
            $category = $_POST['category'];
            $status = $_POST['status'];
            $finishedTime = $_POST['finishedTime'];

            $this->itemService->add($title, $content, $category, $status, $finishedTime, $id);
        }
        $this->getMethodAddItem($id, $routes);
    }

    public function loadInfoItem($id, RouteCollection $routes){
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'POST':
              $this->postMethodInfoItem($id,$routes);
              break;
            case 'GET':
              $this->getMethodInfoItem($id, $routes);
              break;
        }
    }

    private function postMethodInfoItem($id, RouteCollection $routes){
        if(isset($_POST['model'])) {
            $this->deleteItem();
        } else {
            $this->updateItem($id);
            $homeController = new HomeController();
            $homeController->loadHome($routes);
            return;
        }
        $this->getMethodInfoItem($id, $routes);
    }

    private function deleteItem() {
        $modelId = $_POST['id'];
        $this->itemService->delete(intval($modelId));
    }

    private function updateItem($id){
        $content = $_POST['content'];
        $title = $_POST['title'];
        $category = $_POST['category'];
        $status = $_POST['status'];
        $finishTime = $_POST['finishTime'];
        $this->itemService->update($id, $title, $content, $category, $status, $finishTime, null);
    }

    private function getMethodInfoItem($id, RouteCollection $routes){
        $mainItem = $this->itemService->getById($id);
        $subItems = $this->itemService->getSubItems($id);
        $parentItems = [$this->itemService->getById($mainItem->getParentId())];
        $allCategories = $this->categoryService->getAll();
        $categories = array();
        foreach ($allCategories as $category) {
            $categories[$category->getId()] = $category->getContent();                                 
        }
        require_once $this->loadView('infoItem.php');
    }
}