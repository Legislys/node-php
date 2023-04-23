<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\NotFoundException;

class NoteController extends AbstractController
{
    public function createAction()
    {
        if ($this->request->hasPost()) {
            $noteData = $this->request->getParams('post', []);
            $this->database->createNote($noteData);
            $this->redirect('/', ['before' => 'created']);
        }
        $this->view->render('create');
    }

    public function showAction()
    {
        $data = $this->request->getParams('get', []);
        $noteId = (int) $data['id'] ?? null;
        if (!$noteId) {
            $this->redirect('/', ['error' => 'missingNoteId']);
        }
        try {
            $note = $this->database->getNote($noteId);
        } catch (NotFoundException $err) {
            $this->redirect('/', ['error' => 'noteNotFound']);
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
