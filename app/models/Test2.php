<?php
use Phalcon\Mvc\Model;
/**
 * @Table(name="test2")
 */
class Test2 extends Model
{
    public $id;
    public $name;
    public $link;
    public $weather;
    public $weatherDescription;
    public $deletedAt;

}
