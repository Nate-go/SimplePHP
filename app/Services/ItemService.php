<?php
namespace App\Services;
use App\Dtos\TreeItem;
use App\Models\Item;
use App\Repositories\ItemRepository;

class ItemService{
    private $itemRepository; 
    
    public function __construct(){
        $this->itemRepository = new ItemRepository();
    }

    

}