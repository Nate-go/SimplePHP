<?php

class Model {
    public function setByArr($arr) {
        foreach ($arr as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }
}