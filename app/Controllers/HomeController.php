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
    const ITEM_MODEL = 0;
    const CATEGORY_MODEL = 1;
    private $itemService; 
    private $categoryService;

    public function __construct(){
        $this->itemService = new ItemService();
        $this->categoryService = new CategoryService();
    }

    public function loadHome(RouteCollection $routes)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(isset($_POST['model'])) {
                $model = $_POST['model'];
                $id = $_POST['id'];
            
                if($model === self::ITEM_MODEL) {
                    $this->itemService->delete(intval($id));
                } elseif($model === self::CATEGORY_MODEL) {
                    $this->categoryService->delete(intval($id));
                }
            }
        }
        $todayItems = $this->itemService->getTodayItems();
        $allItems = $this->itemService->getAll();
        $allCategory = $this->categoryService->getAll();
        require_once $this->loadView('home.php');
    }
}