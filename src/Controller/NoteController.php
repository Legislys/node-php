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
    public function editAction()
    {
        if ($this->request->requestMethod() == 'POST') {
            $noteData = $this->request->getParams('post');
            if (!$noteData) $this->redirect('/', ['error' => 'missingNoteId']);
            $this->database->editNote((int) $noteData['id'], $noteData);
            $this->redirect('/', ['before' => 'edited']);
        }
        $noteId = (int) $this->request->getParams('get')['id'];
        try {
            $note = $this->database->getNote($noteId);
        } catch (\Throwable $err) {
            var_dump($err);
            $this->redirect('/', ['error' => 'noteNotFound']);
            exit;
        }
        $this->view->render('edit', ['note' => $note]);
    }
}
