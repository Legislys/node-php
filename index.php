<?php

declare(strict_types=1);

spl_autoload_register(function (string $name) {
    $name = str_replace(['\\', 'App/'], ['/', ''], $name);
    $path = "src/$name.php";
    require_once($path);
});

include_once('./src/utils/debug.php');
require_once('./config/config.php');

use App\Exception\AppException;
use App\Exception\StorageException;
use App\Exception\ConfigurationException;
use App\Exception\NotFoundException;
use App\Controller\AbstractController;
use App\Controller\NoteController;
use App\Request;

$request = new Request($_GET, $_POST);

try {
    AbstractController::initConfig($configuration);
    $controller = new NoteController($request);
    $controller->run();
} catch (AppException $err) {
    echo '<h1>Wystąpił błąd w aplikacji</h1>';
    echo '<h3>' . $err->getMessage() . '</h3>';
} catch (\Throwable $err) {
    echo '<h1>Wystąpił błąd w aplikacji!</h1>';
}
