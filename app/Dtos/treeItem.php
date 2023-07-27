<?php

namespace App\Dtos;
use BadMethodCallException;

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

    public function __call($method, $args) {
        $property = lcfirst(substr($method, 3));
        
        if (!property_exists($this, $property)) {
            throw new BadMethodCallException("Method $method does not exist.");
        } 
        
        if (strncasecmp($method, 'get', 3) === 0) {
            return $this->$property;
        } elseif (strncasecmp($method, 'set', 3) === 0) {
            $this->$property = $args[0];
        }
    }
}