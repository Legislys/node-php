<?php

declare(strict_types=1);

namespace App;

require_once('./Exception/AppException.php');
require_once('./Exception/StorageException.php');
require_once('./Exception/ConfigurationException.php');
include_once('./src/Controller.php');
include_once('./src/View.php');
require_once('./config/config.php');

use App\Exception\AppException;
use App\Exception\StorageException;
use App\Exception\ConfigurationException;
use Throwable;

$request = [
    'get' => $_GET,
    'post' => $_POST
];

try {
    Controller::initConfig($configuration);
    $controller = new Controller($request);
    $controller->run();
} catch (AppException $err) {
    echo '<h1>Wystąpił błąd w aplikacji</h1>';
    echo '<h3>' . $err->getMessage() . '</h3>';
} catch (Throwable $err) {
    echo '<h1>Wystąpił błąd w aplikacji!</h1>';
}
