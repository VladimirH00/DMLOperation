<?php

require_once "MySqlInsert.php";

use VladimirH00\SqlDml\MySqlInsert as MySqlInsert;


$query = (new MySqlInsert())->from("`table`")->values(array(array("'hello'", "world")));

echo $query->getRaw();
echo "<br>";

$query = (new MySqlInsert())->from(array("name", array("123", "456")))
    ->values(array(array("hello", "world")));

echo $query->getRaw();
echo "<br>";