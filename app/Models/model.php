<?php
namespace App\Models;
use BadMethodCallException;
use FFI\Exception;

class Model {

    protected $createTime;

    protected $updateTime;

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
        
        if (property_exists($this, $property)) {
            if (strncasecmp($method, 'get', 3) === 0) {
                try {
                    $temp = $this->$property;
                    return $this->$property;
                } catch(e) {
                    return null;
                }
            } elseif (strncasecmp($method, 'set', 3) === 0) {
                try {
                    $temp = $this->$property;
                    $this->$property = $args[0];
                } catch(e) {
                    return null;
                }
            }
        } else {
            throw new BadMethodCallException("Method $method does not exist.");
        }
    }
}