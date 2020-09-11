<?php

require_once "MySqlSelect.php";

use VladimirH00\DMLOperation\MySqlSelect as MySqlSelect;

$query = (new MySqlSelect())
    ->select(array(
        "table"=>'id_person',"table2"=>
        array("CONCAT(first_name, second_name)" => "full_name")
    ))
    ->from(array("table1", array("table2"=>"t2"),"table3"))->andWhere(array(">", "id_person", "100"))
    ->orWhere(array('=', array("table","age"), "1"))
    ->limit(10)->orderBy(array("id_type_doc"))->offset(2);



echo $query->getRaw();
echo "<br>";

$query = (new MySqlSelect())
    ->select()
    ->from(array("table1"))->join(array("LEFT JOIN","table2", "name", "fio"))
    ->andWhere(array(">", array("table","anyPole"), "100"))
    ->orWhere(array('=', array("table2", "anyPole2"), "1"))
    ->limit(10)->orderBy(array("id_type_doc"))->offset(2);
echo $query->getRaw();


echo "<br>";

$query = (new MySqlSelect())
    ->select(array("table1"=>array("pole1"=>"P1")))
    ->from("`table2`")->join(array("INNER JOIN", "table2", "pole1", "pole2"))
    ->andWhere(array(">", array("table","anyPole"), "100"))
    ->orWhere(array('=', array("table2", "anyPole2"), "1"))
    ->limit(10)->groupBy(array("id_type_doc"))->offset(2);
echo $query->getRaw();