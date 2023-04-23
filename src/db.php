<?php

declare(strict_types=1);

namespace App;

use App\Exception\StorageException;
use App\Exception\ConfigurationException;
use App\Exception\NotFoundException;
use PDO;
use PDOException;

class Db
{
    private PDO $conn;
    public function __construct(array $config)
    {
        try {
            $this->validateConfig($config);
            $this->createConnection($config);
        } catch (PDOException $err) {
            throw new StorageException('Connection error');
        }
    }

    public function createNote(array $data): void
    {
        try {
            $title = $this->conn->quote($data['title']);
            $description = $this->conn->quote($data['description']);
            $created = date('Y-m d H:i:s');
            $query = "INSERT INTO notes(title,description,created) VALUES($title, $description,'$created')";
            $this->conn->exec($query);
        } catch (\Throwable $err) {
            var_dump($err);
            throw new StorageException('Nie udało się utworzyć notatki', 400, $err);
        }
    }
    public function getNotes(): array
    {
        try {
            $notes = [];
            $query = 'SELECT id,title,created FROM notes';
            $result = $this->conn->query($query, PDO::FETCH_ASSOC);
            foreach ($result as $row) {
                $notes[] = $row;
            }
            return $notes;
        } catch (\Throwable $err) {
            throw new StorageException('Nie udało się pobrać danych', 500, $err);
        }
    }
    public function getNote(int $noteId)
    {
        try {
            $query = "SELECT * FROM notes WHERE id=$noteId";
            $result = $this->conn->query($query);
            $note = $result->fetch(PDO::FETCH_ASSOC);
        } catch (\Throwable $err) {
            throw new StorageException('Notatka o danych id nie istnieje', 400, $err);
        }
        if (!$note) {
            throw new NotFoundException("Notatka o id: $noteId nie istnieje");
        }
        return $note;
    }

    public function editNote(int $id, array $data): void
    {
        try {
            $title = $data['title'];
            $description = $data['description'];
            $query = "UPDATE notes SET title = '$title', description = '$description' WHERE id = $id";
            var_dump($title,$description,$query);
            echo '<br>';
            $this->conn->exec($query);
        } catch (\Throwable $err) {
            throw new StorageException('Nie udało się edytować notatki', 400, $err);
        }
    }

    private function validateConfig(array $config): void
    {
        if (empty($config['database']) || empty($config['user']) || empty($config['host'])) {
            throw new ConfigurationException('Problem z konfiguracją bazy danych - skontaktuj się z administratorem!');
        }
    }

    private function createConnection(array $config): void
    {
        $dsn = "mysql:dbname={$config['database']};host={$config['host']}";
        $this->conn = new PDO(
            $dsn,
            $config['user'],
            $config['password'],
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    }
}
