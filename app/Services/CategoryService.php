<?php
namespace App\Services;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\Util\Autowired;

class CategoryService{
    private $categoryRepository; 
    
    public function __construct(){
        $this->categoryRepository = new CategoryRepository();
    }

    
}