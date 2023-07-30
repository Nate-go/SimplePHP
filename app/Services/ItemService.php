<?php
namespace App\Services;
use App\Dtos\TreeItem;
use App\Models\Item;
use App\Repositories\ItemRepository;

class ItemService{
    private $itemRepository; 
    
    public function __construct(){
        $this->itemRepository = new ItemRepository();
    }

    private function mappingData($rows){
        $listItem = array();
        foreach($rows as $element) {
            $item = new Item();
            $item->setByArr($element);
            $listItem[] =  $item;
        }
        return $listItem;
    }

    public function getTreeAllItem(){
        $items = $this->mappingData($this->itemRepository->findAll());
        $treeItems = array();
        foreach($items as $item){
            if(!$item->getParentId()) {
                $treeItems[] = $this->getSubItem($item, $items);
            }
        }
        return $treeItems;
    }

    private function getSubItem($parentItem, $items){
        $parentId = $parentItem->getId();
        $treeItem = new TreeItem($parentItem);
        foreach($items as $item){
            if($item->getParentId() === $parentId) {
                $treeItem->addSubItem($item);
            }
        }
        return $treeItem;
    }

    public function getTodayItems(){
        $date = date('Y-m-d');
        $items = $this->mappingData($this->itemRepository->getByFinishTime($date));
        return $items;
    }

    public function getAll(){
        $items = $this->mappingData($this->itemRepository->findAll());
        return $items;
    }

    public function getAllParentItem() {
        $parentItems = $this->mappingData($this->itemRepository->getByParentId(null));

        return $parentItems;
    }

    public function getSubItems($parentId){
        $subItems = $this->mappingData($this->itemRepository->getByParentId($parentId));
        return $subItems;
    }


    public function getById($id){
        $items = $this->mappingData($this->itemRepository->read($id));
        if(count($items) > 0){
            return $items[0];
        } else {
            return new Item();
        }
    }

    public function add($title=null, $content=null, $category=null, $status=null, $finishedTime=null, $parentId= null) {
        $item = new Item($title, $content, $category, $status, $finishedTime, $parentId);
        $date = date('Y-m-d H:i:s');
        $item->setCreateTime($date);
        $item->setUpdateTime($date);
        $id = $this->itemRepository->create($item);
        if($id > 0) {
            return $this->getById($id);
        }
        return $id;
    }

    public function update($id, $title=null, $content=null, $category=null, $status=null, $finishedTime=null, $parentId= null) {
        $item = new Item($title, $content, $category, $status, $finishedTime, $parentId);
        $item->setId($id);
        $date = date('Y-m-d H:i:s');
        $item->setUpdateTime($date);
        $result = $this->itemRepository->update($item);
        return $result;
    }

    public function delete($id) {
        $subitems = $this->getSubItems($id);
        foreach($subitems as $item) {
            $this->delete($item->getId());
        }
        $result = $this->itemRepository->delete($id);
        return $result;
    }
}