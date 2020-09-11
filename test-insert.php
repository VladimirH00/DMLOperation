<?php

require_once "MySqlInsert.php";

use VladimirH00\DMLOperation\MySqlInsert as MySqlInsert;


$query = (new MySqlInsert())->insert(array(array("hello", "world"), array("world", "hello")),array("table1"=>"T1"));

echo $query->getRaw();
echo "<br>";

$query = (new MySqlInsert())->insert(array(array("one", "insert")),"`table1`");

echo $query->getRaw();
echo "<br>";

$query = (new MySqlInsert())->insert("(column1, column2)",array("table1"=>"T1"));
echo $query->getRaw();
echo "<br>";