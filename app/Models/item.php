<?php

namespace App\Models;

class Item extends Model
{
    private $id;
    private $title;
    private $content;
    private $category;
    private $status;
    private $finishedTime;
    private $parentId;
}