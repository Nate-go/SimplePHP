<?php 
namespace App\Controllers;
use App\Services\ItemService;
use Symfony\Component\Routing\RouteCollection;

class ItemController extends BaseController
{
    private $itemService; 

    public function __construct(){
        $this->itemService = new ItemService();
    }
}