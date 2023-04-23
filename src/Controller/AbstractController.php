<?php

declare(strict_types=1);

namespace App\Controller;

use App\Request;
use App\View;
use App\Db;

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
        if (!array_key_exists('action', $action))  return self::DEFAULT_ACTION;
        return $action['action'];
    }

    protected function redirect(string $to, array $params)
    {
        $location = $to;
        if (count($params)) {
            $queries = [];
            foreach ($params as $key => $value) {
                $queries[] = urlencode(strval($key)) . '=' . urlencode(strval($value));
            }
            $queries = implode('&', $queries);
        }
        return header("Location: $location");
    }
}
