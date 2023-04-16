<?php

declare(strict_types=1);

namespace App;

include_once('./src/View.php');
require_once('db.php');

class Controller
{
    const DEFAULT_ACTION = 'list';
    private array $request;
    private View $view;
    private static $configuration = [];
    private Db $database;

    public function __construct($request)
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
        $viewParams = [];
        $view = new View();
        $created = false;

        switch ($this->action()) {
            case 'create':
                $page = 'create';
                if (!empty($this->getRequest('post'))) {
                    $viewParams = $this->getRequest('post');
                    $created = true;
                    $this->database->createNote($viewParams);
                    header('Location: /');
                }
                $viewParams['created'] = $created;
                break;
            default:
                $page = 'list';
                break;
        }
        $view->render($page, $viewParams);
    }
    private function action(): string
    {
        $data = $this->getRequest('get');
        return $data['action'] ?? self::DEFAULT_ACTION;
    }
    private function getRequest(string $crud): array
    {
        return $this->request[$crud] ?? [];
    }
}
