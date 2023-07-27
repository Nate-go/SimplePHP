<?php
namespace App\Repositories;
use PDO;
use PDOException;
require_once '../config/config.php';
class DataBase
{
    private static $instance = NULl;
    public static function getInstance() {
      if (!isset(self::$instance)) {
        try {
          self::$instance = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
          self::$instance->exec("SET NAMES 'utf8'");
        } catch (PDOException $ex) {
          die($ex->getMessage());
        }

        self::createData();
      }
      return self::$instance;
    }

    private static function createData(){

      $stmtItems = self::$instance->prepare("SELECT COUNT(*) FROM items");
      $stmtItems->execute();
      $rowCountItems = $stmtItems->fetchColumn();

      if($rowCountItems > 0) {
        return;
      }
      
      $numberOfCategories = 4;
      $numberOfParentItems = 6;
      $numberOfItems = 12; 

      for ($i = 1; $i <= $numberOfCategories; $i++) {
          $currentDateTime = date('Y-m-d H:i:s');
          $sql = "INSERT INTO categories (content, createTime, updateTime) VALUES ('Catetogy$i', '$currentDateTime', '$currentDateTime')";
          self::$instance->exec($sql);
      }

      $categories = array();
      $randDays = array();

      for ($i = 1; $i <= $numberOfParentItems; $i++) {
          $categoryId = mt_rand(1, $numberOfCategories);
          $categories[] = $categoryId;
          $currentDateTime = date('Y-m-d H:i:s');
          $randDay = mt_rand(1, 30);
          $randDays[] = $randDay;
          $finishTime = date('Y-m-d H:i:s', strtotime('+ ' . $randDay . ' days'));
          $status = mt_rand(0, 3);

          $sql = "INSERT INTO items (parentId, title, content, categoryId, createTime, updateTime, finishTime, status) 
                  VALUES (null, 'ParentItem$i', 'ParentItemContent$i', $categoryId, '$currentDateTime', '$currentDateTime', '$finishTime', $status)";
          self::$instance->exec($sql);
      }

      for ($i = 1; $i <= $numberOfItems; $i++) {
        $parentId = mt_rand(1, $numberOfParentItems);
        $categoryId = $categories[$parentId-1];
        $currentDateTime = date('Y-m-d H:i:s');
        $finishTime = date('Y-m-d H:i:s', strtotime('+ ' . mt_rand(1, $randDays[$parentId-1]) . ' days'));
        $$status = mt_rand(0, 3);

        $sql = "INSERT INTO items (parentId, title, content, categoryId, createTime, updateTime, finishTime, status) 
                VALUES ($parentId, 'Item$i', 'ItemContent$i', $categoryId, '$currentDateTime', '$currentDateTime', '$finishTime', $status)";
        self::$instance->exec($sql);
      }
    }
}
