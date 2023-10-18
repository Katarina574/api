<?php
use Phalcon\Mvc\Model;

class FileModel extends Model
{
    public $id;
    public $name;
    public $link;
    public $uploadTime;
    public $temperature;
    public $weatherDescription;
    public $deletedAt;
}
