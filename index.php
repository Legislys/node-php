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


const DEFAULT_ACTION = 'list';

$viewParams = [];
$created = false;
$action = $_GET['action'] ?? DEFAULT_ACTION;

if ($action === 'create'){
    $page = 'create';
    if (!empty($_POST)){
        $viewParams = $_POST;
        $created = true;
    }
    $viewParams['created'] = $created;
} else {
    $page = 'list';
}


$view = new View();
$view->render($page, $viewParams);