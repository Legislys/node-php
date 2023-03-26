<?php

declare(strict_types=1);
namespace App;

/* 
    include - uruchomi się gdy plik będzie istniał. Jeśli nie istnieje, to da warning, ale będzie działał
    include_once
    require 
    require_once - program uruchomi się tylko kiedy dany plik będzie istniał
*/

include_once('./src/Controller.php');
include_once('./src/View.php');

$controller = new Controller($_GET, $_POST);
$controller->run();

SELECT * FROM `students` WHERE `id` IS NULL
SELECT 'firstName', 'age' FROM `students` 
SELECT 'firstName', 'age' FROM `students` WHERE 'age' <> 2 //is not


... WHERE 'age' > 21 
... WHERE 'id' in(1,3)

... ORDER BY 'firstName'  // DEFAULT ascending 
... ORDER BY 'firstName' DESC //DESCENDING  

... LIMIT 3 

SELECT * FROM `cars` WHERE `brand` = 'Mitsubishi';
SELECT * FROM `cars` WHERE `brand` <> 'Mitsubishi';
SELECT * FROM `cars` WHERE `registry number` = 'ZKN802524';

