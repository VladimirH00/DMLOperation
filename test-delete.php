<?php


require_once "MySqlDelete.php";


use VladimirH00\SqlDml\MySqlDelete as MySqlDelete;


$query = (new MySqlDelete())->from(array("table"))->andWhere(array("=", "age", 24))
    ->orWhere(array("not in", "age", array(34, 24, 56)));

echo $query->getRaw();
echo "<br>";
$query = (new MySqlDelete())->from("tb")->andWhere(array("=", "age", 24))
    ->orWhere(array(">", "price", 46));

echo $query->getRaw();
