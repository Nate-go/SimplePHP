<?php 
namespace App\Controllers;
use App\Services\CategoryService;
use App\Services\ItemService;
use App\Util;
use App\Models\Item;
use App\Dtos\TreeItem;
use Symfony\Component\Routing\RouteCollection;

class HomeController extends BaseController
{
    const DELETE_ITEM = 0;
    const DELETE_CATEGORY = 1;
    const FINISH = 2;
    private $itemService; 
    private $categoryService;

    public function __construct(){
        $this->itemService = new ItemService();
        $this->categoryService = new CategoryService();
    }

    public function loadHome(RouteCollection $routes)
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'POST':
              $this->postMethodHome($routes);
              break;
            case 'GET':
              $this->getMethodHome($routes);
              break;
        }
    }

    private function postMethodHome(RouteCollection $routes){
        if(isset($_POST['model'])) {
            $model = $_POST['model'];
            $id = $_POST['id'];
            
            switch ($model) {
                case self::DELETE_ITEM:
                    $this->deleteItem($id);
                    break;
                case self::DELETE_CATEGORY:
                    $this->deleteCategory($id);
                    break;
                case self::FINISH:
                    $this->finishItem($id);
                    break;
            }
        }
        $this->getMethodHome($routes);
    }

    private function getMethodHome(RouteCollection $routes){
        $todayItems = $this->itemService->getTodayItems();
        $allItems = $this->itemService->getAll();
        $allCategories = $this->categoryService->getAll();
        $categories = array();
        foreach ($allCategories as $category) {
            $categories[$category->getId()] = $category->getContent();                                 
        }
        require_once $this->loadView('home.php');
    }

    private function deleteItem($id){
        $this->itemService->delete(intval($id));
    }

    private function deleteCategory($id){
        $this->categoryService->delete(intval($id));
    }

    private function finishItem($id){
        $this->itemService->finishItem($id);
    }
}