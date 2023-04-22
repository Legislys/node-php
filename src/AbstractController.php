<?php

declare(strict_types=1);

namespace App;

use App\Request;

include_once('src/View.php');
require_once('./config/config.php');
require_once('db.php');

abstract class AbstractController
{
    const DEFAULT_ACTION = 'list';
    protected Request $request;
    protected View $view;
    protected static $configuration = [];
    protected Db $database;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->view = new View();
        $this->database = new Db(self::$configuration);
    }

    public static function initConfig(array $config): void
    {
        self::$configuration = $config;
    }

    public function run(): void
    {
        $action = $this->action() . 'Action';
        if (!method_exists($this, $action)) {
            $action = self::DEFAULT_ACTION;
        }
        $this->$action();
    }


    private function action(): string
    {
        $action = $this->request->getParams('get');
        if (!$action['action'])  return self::DEFAULT_ACTION;
        return $action['action'];
    }
}
