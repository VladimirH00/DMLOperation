<?php


require_once "MySqlDelete.php";


use VladimirH00\SqlDml\MySqlDelete as MySqlDelete;


$query = (new MySqlDelete())->from(array("table","table2"))->andWhere(array("=", array("table","age"), 24))
    ->orWhere(array("not in", array("table","age"), array(34, 24, 56)));

echo $query->getRaw();
echo "<br>";
$query = (new MySqlDelete())->from("`tb`")->andWhere(array("=", array("table","age"), 24))
    ->orWhere(array(">", array("table","price"), 46));

echo $query->getRaw();

echo "<br>";
$query = (new MySqlDelete())->from(array(array("table1"=>"T1")))->andWhere(array("=", array("table","age"), 24))
    ->orWhere(array(">", array("table","price"), 46));

echo $query->getRaw();
