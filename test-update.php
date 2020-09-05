<?php


require_once "MySqlUpdate.php";


use VladimirH00\SqlDml\MySqlUpdate as MySqlUpdate;


$query = (new MySqlUpdate())->from(array("table"))
    ->set(array(array("table","name","'Stepa'"),array("table","money",560)))
    ->andWhere(array("=", array("table","age"), 15));

echo $query->getRaw();

echo "<br>";
$query = (new MySqlUpdate())->from(array(array("table"=>"t1"), "table2"))
    ->set(array(array("table","name","'Stepa'"),array("table","money",560)))
    ->andWhere(array("=", array("table","age"), 15));
echo $query->getRaw();

echo "<br>";
$query = (new MySqlUpdate())->from(array(array("table"=>"t1"), "table2"))
    ->set(array(array("table","name","'Stepa'"),array("table","money",560)))
    ->andWhere(array("=", array("table","age"), 15))
    ->orWhere(array("NOT in", array("table2","pole1"),array(123,534543,67876)));
echo $query->getRaw();