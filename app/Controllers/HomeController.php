<?php 
namespace App\Controllers;
use App\Services\ItemService;
use Symfony\Component\Routing\RouteCollection;

class HomeController extends BaseController
{
    private $itemService; 

    public function __construct(){
        $this->itemService = new ItemService();
    }

    public function loadHome(RouteCollection $routes)
    {
        $treeItems = $this->itemService->getTreeAllItem();
        require_once $this->loadView('home.php');
    }
}