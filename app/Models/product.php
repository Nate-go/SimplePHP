<?php 
namespace App\Models;

class Product extends Model
{
    protected $id;
    protected $title;
    protected $description;
    protected $price;
    protected $sku;
    protected $image;

    public function __construct() {
        
    }
}