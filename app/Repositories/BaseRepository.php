<?php
namespace App\Repositories;
use App\Util\DBService;
use App\Util\StringService;
use BadMethodCallException;
use App\Models\Item;

spl_autoload_register(function ($className) {
    echo $className;
    $filePath = ROOT_PATH . '\\' . 'Models' . '\\' . strtolower($className) . '.php';
    echo $filePath;
    // Check if the file exists and load it if it does
    if (file_exists($filePath)) {
        require_once $filePath;
    }
});

class BaseRepository{
    private $db;

    private $tableName;

    public function __construct(){

        $this->db = DataBase::getInstance();
        $className = StringService::getClassName(get_called_class());
        $this->tableName = strtolower($className) . 's';
    }

    public function findAll() {
        $list = [];
        $req = $this->db->query('SELECT * FROM ' . $this->tableName);

        foreach ($req->fetchAll() as $item) {
            $list[] = $item;
        }

        return $list;
    }

    public function create($data)
    {
        [$id, $fields, $values] = DBService::getInsertQuery($data);

        $query = "INSERT INTO $this->tableName ($fields) VALUES ($values)";
        $result = $this->db->exec($query);
        if($result > 0) {
            return $this->db->lastInsertId();
        }
        return $result;
    }

    public function update($data)
    {
        [$id, $updateFields] = DBService::getUpdateQuery($data);

        $query = "UPDATE $this->tableName SET $updateFields WHERE id = $id";
        $result = $this->db->exec($query);
        
        return $result;
    }

    public function delete($id)
    {
        $query = "DELETE FROM $this->tableName WHERE id = " . addslashes($id);
        $result = $this->db->exec($query);

        return $result;
    }

    public function read($id)
    {
        $list = [];
        $req = $this->db->query('SELECT * FROM ' . $this->tableName . ' WHERE id = ' . addslashes($id));

        foreach ($req->fetchAll() as $item) {
            $list[] = $item;
        }

        return $list; 
    }

    public function __call($method, $args) {
        $property = lcfirst(substr($method, 5));
        
        if (!property_exists($this->getObject(), $property)) {
            throw new BadMethodCallException("Method $method does not exist.");
        }

        $list = [];
        $req = $this->db->query('SELECT * FROM ' . $this->tableName . ' WHERE'. $property . '=' . addslashes($args[0]));

        foreach ($req->fetchAll() as $item) {
            $list[] = $item;
        }
        return $list; 
    }
}