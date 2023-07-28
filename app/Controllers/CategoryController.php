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

    public function addCategory($id=null, RouteCollection $routes){
        // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //     $title = $_POST['title'];
        //     $content = $_POST['content'];
        //     $category = $_POST['category'];
        //     $status = $_POST['status'];
        //     $finishedTime = $_POST['finishedTime'];
        
        //     $this->itemService->add($title, $content, $category, $status, $finishedTime, $id);
        // } 
        // $allCategories = $this->categoryService->getAll();
        // require_once $this->loadView('addItem.php');
    }

    public function getInfoCategory($id, RouteCollection $routes){
        
        // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //     if(isset($_POST['model'])) {
        //         $model = $_POST['model'];
        //         $id = $_POST['id'];

        //         if($_POST-> $model === '0') {
        //             $this->itemService->delete(intval($id));
        //         } elseif($model === '1') {
        //             $this->categoryService->delete(intval($id));
        //         }
        //     } else {
        //         $content = $_POST['content'];
        //         $title = $_POST['title'];
        //         $category = $_POST['category'];
        //         $status = $_POST['status'];
        //         $finishTime = $_POST['finishTime'];
        //         $this->itemService->update($id, $title, $content, $category, $status, $finishTime, null);
        //     }
        // }
        // $mainItem = $this->itemService->getById($id);
        // $subItems = $this->itemService->getSubItems($id);
        // $parentItems = [$this->itemService->getById($mainItem->getParentId())];
        // $allCategories = $this->categoryService->getAll();
        // require_once $this->loadView('infoItem.php');
    }
}