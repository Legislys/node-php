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
$action = $_GET['action'] ?? DEFAULT_ACTION;

if ($action === 'create'){
    $page = 'create';
    $viewParams[$page] = 'Udało się dodać notatkę!';
} else {
    $page = 'list';
    $viewParams[$page] = 'Wyświetlamy listę notatek!';
}


$view = new View();
$view->render($page, $viewParams);