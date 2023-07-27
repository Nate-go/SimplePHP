<?php

namespace App\Models;
use BadMethodCallException;

class Item extends Model
{
    private $id;
    private $title;
    private $content;
    private $category;
    private $status;
    private $finishedTime;
    private $parentId;

    public function __construct($title=null, $content=null, $category=null, $status=null, $finishedTime=null, $parentId= null){
        $this->title = $title;
        $this->content = $content;
        $this->category = $category;
        $this->status = $status;
        $this->finishedTime = $finishedTime;
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
}