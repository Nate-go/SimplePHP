<?php

namespace App\Models;
use BadMethodCallException;

class Item extends Model
{
    private $id;
    private $title;
    private $content;
    private $categoryId;
    private $status;
    private $finishTime;
    private $parentId;

    public function __construct($title=null, $content=null, $categoryId=null, $status=null, $finishTime=null, $parentId= null){
        $this->title = $title;
        $this->content = $content;
        $this->categoryId = $categoryId;
        $this->status = $status;
        $this->finishTime = $finishTime;
        $this->parentId = $parentId;
    }

    public function setByArr($array) {
        foreach ($array as $key => $value) {
            if(!is_numeric($key)) {
                $this->$key = $value; 
            }
        }
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

    public function getListVariable(){
        return get_object_vars($this);
    }
}