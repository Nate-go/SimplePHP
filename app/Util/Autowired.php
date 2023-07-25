<?php
namespace App\Util;
use BadMethodCallException;

class Autowired {
    private $object;

    private $class;
    

    public function __construct(string $class){
        $this->class = $class;
        $this->object = null;
    }

    private function createObject() {
        $path = StringService::getPath($this->class);
        echo $path;
        require_once $path;
        $this->object = new $this->class();
    }

    public function __call($name, $args) {
        if($this->object === null) {
            $this->createObject();
        }
        if (method_exists($this->object, $name)) {
            return call_user_func_array([$this->object, $name], $args);
        } else {
            throw new BadMethodCallException("Method $name does not exist in the dependency class.");
        }
    }
}
