<?php 
namespace App\Controllers;
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

    public function addItem($id=null, RouteCollection $routes){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $content = $_POST['content'];
            $category = $_POST['category'];
            $status = $_POST['status'];
            $finishedTime = $_POST['finishedTime'];
        
            $this->itemService->add($title, $content, $category, $status, $finishedTime, $id);
        } 
        $allCategories = $this->categoryService->getAll();
        require_once $this->loadView('addItem.php');
    }

    public function getInfoItem($id, RouteCollection $routes){
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(isset($_POST['model'])) {
                $model = $_POST['model'];
                $id = $_POST['id'];

                if($_POST-> $model === self::ITEM_MODEL) {
                    $this->itemService->delete(intval($id));
                } elseif($model === self::CATEGORY_MODEL) {
                    $this->categoryService->delete(intval($id));
                }
            } else {
                $content = $_POST['content'];
                $title = $_POST['title'];
                $category = $_POST['category'];
                $status = $_POST['status'];
                $finishTime = $_POST['finishTime'];
                $this->itemService->update($id, $title, $content, $category, $status, $finishTime, null);
            }
        }
        $mainItem = $this->itemService->getById($id);
        $subItems = $this->itemService->getSubItems($id);
        $parentItems = [$this->itemService->getById($mainItem->getParentId())];
        $allCategories = $this->categoryService->getAll();
        require_once $this->loadView('infoItem.php');
    }
}