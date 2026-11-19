<?php

namespace Inteficies;

interface NotesDAO
{
    public function getAllByUser(int $userId): array;
    public function getById(int $id);
    public function create(int $userId, string $body): void;
    public function update(int $id, string $body): void;
    public function delete(int $id): void;
}