<?php


require_once "MySqlUpdate.php";


use VladimirH00\SqlDml\MySqlUpdate as MySqlUpdate;


$query = (new MySqlUpdate())->from(array("table"))->set(array("name" => "Stepan", "money" => 15))
    ->andWhere(array("=", "age", 15));

echo $query->getRaw();