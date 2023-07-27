<?php

namespace App\Models;
use BadMethodCallException;

class Category extends Model
{
    private $id;
    private $content;

    public function __construct($content=null){
        $this->content = $content;
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