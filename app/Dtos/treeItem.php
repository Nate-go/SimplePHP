<?php

namespace App\Dtos;

class TreeItem extends BaseDTO
{
    private $parentItem;
    private $subItems;

    public function __construct($item, $subItems = array()){
        $this->parentItem = $item;
        $this->subItems = $subItems;
    }

    public function addSubItem($item){
        $this->subItems[] = $item;
    }
}