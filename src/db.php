<?php
declare(strict_types=1);
namespace App;

use PDO;

class Db 
{
    public function __construct(array $config)
    {
        $dsn = "mysql:dbname={$config['database']};host={$config['host']}";
        $connection = new PDO($dsn, $config['user']);
    }
}