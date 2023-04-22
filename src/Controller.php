<?php

declare(strict_types=1);

namespace App;

use App\Exception\NotFoundException;
use App\View;

include_once('src/View.php');
require_once('db.php');

class Controller
{
    const DEFAULT_ACTION = 'list';
    private Request $request;
    private View $view;
    private static $configuration = [];
    private Db $database;

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

    public function createAction()
    {
        if ($this->request->hasPost()) {
            $noteData = $this->request->getParams('post', []);
            $this->database->createNote($noteData);
            header('Location: /?before=created');
            exit;
        }
        $this->view->render('create');
    }

    public function showAction()
    {
        $data = $this->request->getParams('get', []);
        $noteId = (int) $data['id'] ?? null;
        if (!$noteId) {
            header('Location: ?error=noteNotFound');
            exit;
        }
        try {
            $note = $this->database->getNote($noteId);
        } catch (NotFoundException $err) {
            header('Location: ?error=noteNotFound');
            exit;
        }
        $this->view->render('show', ['note' => $note]);
    }

    public function listAction()
    {
        $this->view->render('list', [
            'notes' => $this->database->getNotes(),
            'before' => $data['before'] ?? null,
            'error' => $data['error'] ?? null
        ]);
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
