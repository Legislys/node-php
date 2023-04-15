<?php

declare(strict_types=1);

namespace App;

include_once('./src/View.php');
require_once('db.php');

class Controller 
{
    const DEFAULT_ACTION = 'list';
    private array $getData;
    private array $postData;
    private static $configuration = [];

    public function __construct(array $getData, array $postData)
    {
        $this->getData = $getData;
        $this->postData = $postData;
        $db = new Db(self::$configuration);
    }
    public static function initConfig(array $config):void
    {
        self::$configuration = $config;
    } 

    public function run():void
    {
        $viewParams = [];
        $view = new View();
        $created = false;
        $action = $this->getData['action'] ?? self::DEFAULT_ACTION;

        switch ($action){
            case 'create':
                $page = 'create';
                if (!empty($this->postData)){
                    $viewParams = $this->postData;
                    $created = true;
                }
                $viewParams['created'] = $created;
                break;
            default: 
            $page = 'list';
            break;
        }
        $view->render($page, $viewParams);
    }
}
