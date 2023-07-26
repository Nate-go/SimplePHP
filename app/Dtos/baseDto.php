<?php
namespace App\Dtos;
use BadMethodCallException;
use FFI\Exception;

class BaseDTO {
    public function setByArr($arr) {
        foreach ($arr as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    public function __construct() {
        
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