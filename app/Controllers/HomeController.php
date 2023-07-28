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
    private $itemService; 
    private $categoryService;

    public function __construct(){
        $this->itemService = new ItemService();
        $this->categoryService = new CategoryService();
    }

    public function loadHome(RouteCollection $routes)
    {
        $todayItems = $this->itemService->getTodayItems();
        $allItems = $this->itemService->getAll();
        $allCategory = $this->categoryService->getAll();
        require_once $this->loadView('home.php');
    }
}