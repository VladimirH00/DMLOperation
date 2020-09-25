<?php


require_once "MySqlUpdate.php";


use VladimirH00\DMLOperation\MySqlUpdate as MySqlUpdate;


$query = (new MySqlUpdate())->from(array("table"))
    ->set(array(array("table.name","'Stepa'"),array("table.money",560)))
    ->where(array("age",">", 15));

echo $query->getRaw();

echo "<br>";
$query = (new MySqlUpdate())->from(array("table1"=>"t1", "table2"=>"t2"))
    ->set(array(array("table.name","'Stepa'"),array("table.money",560)))
    ->andWhere(array("table.age","<", 15));
echo $query->getRaw();

echo "<br>";
$query = (new MySqlUpdate())->from(array("table"=>"t1", "table2"=>"t2"))
    ->set(array(array("table.name","'Stepa'"),array("table.money",560)))
    ->andWhere(array("table.age","=", 15))
    ->orWhere(array("table2.pole1","NOT in",array(123,534543,67876)));
echo $query->getRaw();