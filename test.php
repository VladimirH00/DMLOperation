<?php

require_once "MySqlQuery.php";

use VladimirH00\ConstructSqlQuery\MySqlQuery as MySqlQuery;

$pdo = new PDO('mysql:host = localhost; dbname=' . "my_db", "mysql",
    "mysql",
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

$query = (new MySqlQuery())
    ->select(array(
        'id_person',
        array("CONCAT(first_name, second_name)" => "full_name")
    ))
    ->from(array('person' => 'p'))
    ->andWhere(array(">", "id_person", 100))
    ->orWhere(array('=', 'first_name', "1"))
    ->limit(10)->orderBy(array(array("id_type_doc")))->offset(2);


$query_text = $pdo->query($query->getRaw());
print_r($query_text->fetchAll());
echo "<br>";
echo $query->getRaw();