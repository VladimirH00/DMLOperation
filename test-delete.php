<?php


require_once "MySqlDelete.php";


use VladimirH00\DMLOperation\MySqlDelete as MySqlDelete;


$query = (new MySqlDelete())->from(array("table","table2"))->andWhere(array("age","IN", array(9,8,7)))
    ->orWhere(array("age", "NOT in", array(34, 24, 56)));

echo $query->getRaw();
echo "<br>";
$query = (new MySqlDelete())->from("`tb`")->andWhere(array("age", "=", 24))
    ->orWhere(array("age", ">", 46));

echo $query->getRaw();

echo "<br>";
$query = (new MySqlDelete())->from(array("table1 as T1"))->orWhere(array("price","<", 24))
    ->andWhere(array("price", ">", 46));

echo $query->getRaw();
