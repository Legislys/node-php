<?php

declare(strict_types=1);

namespace App;

use App\Exception\NotFoundException;

require_once('./src/AbstractController.php');

class NoteController extends AbstractController
{
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
}
