<?php

declare(strict_types=1);

namespace App;

use App\Exception\NotFoundException;

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
        $noteData = [];
        $view = new View();

        switch ($this->action()) {
            case 'create':
                $page = 'create';
                if (!empty($this->getRequest('post'))) {
                    $noteData = $this->getRequest('post');
                    $this->database->createNote($noteData);
                    header('Location: /?before=created');
                }
                break;
            case 'show':
                $page = 'show';
                $data = $this->getRequest('get');
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
                $data = $this->getRequest('get');
                $noteData = [
                    'notes' => $this->database->getNotes(),
                    'before' => $data['before'] ?? null,
                    'error' => $data['error'] ?? null
                ];
        }
        $view->render($page, $noteData);
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
