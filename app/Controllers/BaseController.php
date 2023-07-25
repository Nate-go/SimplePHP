<?php
namespace App\Controllers;

class BaseController{
    public function loadView($view){
        return APP_ROOT . '/views/'. $view;
    }
}