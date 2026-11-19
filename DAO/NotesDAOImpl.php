<?php

namespace DAO;
use Core\Database;
use Core\App;
use Inteficies\NotesDAO;
class NotesDAOImpl implements NotesDAO
{
    private $db;
    public function __construct()
    {
        $this->db = App::resolve(Database::class);
    }
    public function getAllByUser(int $userId): array
    {
        return $this->db->query(
            'SELECT * FROM notes WHERE user_id = :user_id',
            ['user_id' => $userId]
        )->get();
    }
    public function getById(int $id)
    {
        return $this->db->query(
            'SELECT * FROM notes WHERE id = :id',
            [
                'id' => $id,
            ]
        )->findOrFail();
    }

    public function create(int $userId, string $body): void
    {
        $this->db->query(
            'INSERT INTO notes (body, user_id) VALUES (:body, :user_id)',
            [
                'user_id' => $userId,
                'body' => $body
            ]
        );
    }
    public function update(int $id, string $body): void
    {
        $this->db->query(
            'UPDATE notes SET body = :body WHERE id = :id',
            [
                'body' => $body,
                'id' => $id,
            ]
        );
    }
    public function delete(int $id): void
    {
        $this->db->query(
            'DELETE FROM notes WHERE id = :id',
            [
                'id' => $id,
            ]
        );
    }
}