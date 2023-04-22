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

    public function run(): void
    {
        $noteData = [];

        switch ($this->action()) {
            case 'create':
                $page = 'create';
                if ($this->request->hasPost()) {
                    $noteData = $this->request->getParams('post', []);
                    $this->database->createNote($noteData);
                    header('Location: /?before=created');
                }
                break;
            case 'show':
                $page = 'show';
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
                $noteData = [
                    'note' => $note
                ];
                break;
            default:
                $page = 'list';
                $data = $this->request->getParams('get', []);
                $noteData = [
                    'notes' => $this->database->getNotes(),
                    'before' => $data['before'] ?? null,
                    'error' => $data['error'] ?? null
                ];
        }
        $this->view->render($page, $noteData);
    }
    private function action(): string
    {
        $action = $this->request->getParams('get');
        if (!$action['action'])  return self::DEFAULT_ACTION;
        return $action['action'];
    }
}
