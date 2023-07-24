<?php
namespace App\Repositories;
use App\Util\DBService;
use App\Util\StringService;
class BaseRepository{
    public $db;

    public $name;
    public $className;

    public function __construct(){
        
        $this->db = DataBase::getInstance();
        $this->className = StringService::getClassName(get_called_class());
        $this->name = strtolower($this->className) . 's';
    }

    public function findAll() {
        $list = [];
        $req = $this->db->query('SELECT * FROM ' . $this->name);

        foreach ($req->fetchAll() as $item) {
            $cName = ucfirst($this->name);
            $object = new $cName();
            $list[] = $object->setByArr($item);
        }

        return $list;
    }

    public function create($data)
    {
        [$id, $fields, $values] = DBService::getInsert($data);

        $query = "INSERT INTO $this->name ($fields) VALUES ($values)";
        $result = $this->db->exec($query);

        return $result;
    }

    public function update($id, $data)
    {
        [$id, $updateFields] = DBService::getUpdate($data);

        $query = "UPDATE $this->name SET $updateFields WHERE id = $id";
        $result = $this->db->exec($query);

        return $result;
    }

    public function delete($id)
    {
        $query = "DELETE FROM $this->name WHERE id = " . addslashes($id);
        $result = $this->db->exec($query);

        return $result;
    }

    public function read($id)
    {
        $list = [];
        $req = $this->db->query('SELECT * FROM ' . $this->name . ' WHERE id = ' . addslashes($id));

        foreach ($req->fetchAll() as $item) {
            $cName = ucfirst($this->name);
            $object = new $cName();
            $list[] = $object->setByArr($item);
        }

        return $list; 
    }
}