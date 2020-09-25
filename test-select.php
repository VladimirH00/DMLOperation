<?php

require_once "MySqlSelect.php";

use VladimirH00\DMLOperation\MySqlSelect as MySqlSelect;

$query = (new MySqlSelect())
    ->select(array(
        "table as id_person","table2 as 
         CONCAT(first_name, second_name) as full_name"
    ))
    ->from(array("table1"=>"t1","table2"=>"t2","table3"=>"t3"))->andWhere(array("id_person", "<", "100"))
    ->orWhere(array("bdate",">","1990-04-05"))
    ->limit(10)->orderBy(array("id_type_doc"))->offset(2);



echo $query->getRaw();
echo "<br>";

$query = (new MySqlSelect())
    ->select()
    ->from("table1")
    ->leftJoin("table1",array('t.id'=>'t1.user_id'))
    ->andWhere(array("age","IN",array("25", "24")))
    ->orWhere(array("name", "=", "stepan"))
    ->limit(10)->orderBy(array("id_type_doc"))->offset(2);
echo $query->getRaw();


echo "<br>";

$query = (new MySqlSelect())
    ->select(array("table1 as t1"))
    ->from("table2")
    ->innerjoin(array("table1"=>"t1"),array("table2.id"=>"t1.id"))
    ->andWhere(array("table1.id", ">", "100"))
    ->orWhere(array("id", '=', "1"))
    ->limit(10)->groupBy(array("id_type_doc"))->offset(2);
echo $query->getRaw();