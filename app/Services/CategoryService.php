<?php
namespace App\Services;
use App\Models\Category;
use App\Repositories\CategoryRepository;

class CategoryService{
    private $categoryRepository; 
    
    public function __construct(){
        $this->categoryRepository = new CategoryRepository();
    }

    private function mappingData($list){
        $array = array();
        foreach($list as $element) {
            $category = new Category();
            $category->setByArr($element);
            $array[] =  $category;
        }
        return $array;
    }

    public function getAll(){
        $categories = $this->mappingData($this->categoryRepository->findAll());
        return $categories;
    }

    public function getById($id){
        $categories = $this->mappingData($this->categoryRepository->read($id));
        if(count($categories) > 0){
            return $categories[0];
        } else {
            return new Category();
        }
    }

    public function add($content) {
        $category = new Category($content);
        $date = date('Y-m-d H:i:s');
        $category->setCreateTime($date);
        $category->setUpdateTime($date);
        $id = $this->categoryRepository->create($category);
        if($id > 0) {
            return $this->getById($id);
        }
        return $id;
    }

    public function update($id, $content) {
        $category = new Category($content);
        $category->setId($id);
        $date = date('Y-m-d H:i:s');
        $category->setUpdateTime($date);
        $result = $this->categoryRepository->update($category);
        return $result;
    }

    public function delete($id) {
        $result = $this->categoryRepository->delete($id);
        return $result;
    }
}