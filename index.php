<?php

declare(strict_types=1);
namespace App;

/* 
    include - uruchomi się gdy plik będzie istniał. Jeśli nie istnieje, to da warning, ale będzie działał
    include_once
    require 
    require_once - program uruchomi się tylko kiedy dany plik będzie istniał
*/

include_once('./src/utils/debug.php');
include_once('./src/View.php');

$action = $_GET['action'] ?? null;

$view = new View();
$view->render($action);