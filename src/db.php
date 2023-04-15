<?php
declare(strict_types=1);
namespace App;

use App\Exception\StorageException;
use App\Exception\ConfigurationException;
use PDO;
use PDOException;
use Throwable;

class Db 
{
    public function __construct(array $config)
    {
        try {
            $this->validateConfig($config);
            $dsn = "mysql:dbname={$config['database']};host={$config['host']}";
            $connection = new PDO($dsn, $config['user']);
        }catch (PDOException $err){
            throw new StorageException('Connection error');
        }
    } 

    private function validateConfig(array $config):void
    {
        if(empty($config['database']) || empty($config['user']) || empty($config['host'])) {
            throw new ConfigurationException('Problem z konfiguracją bazy danych - skontaktuj się z administratorem!');
        }
    }
}