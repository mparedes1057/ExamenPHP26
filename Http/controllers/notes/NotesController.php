<?php

namespace Http\controllers\notes;
use Core\App;
use Core\Database;
use Core\Validator;

class NotesController
{

    private $currentUserId;
    public static $instance = self::class;

    public function create()
    {
        dd($this->currentUserId);
        view("notes/create.view.php", [
            'heading' => 'Create Note',
            'errors' => []
        ]);
    }

    public function destroy()
    {

        $db = App::resolve(Database::class);

        $note = $db->query('select * from notes where id = :id', [
            'id' => $_POST['id']
        ])->findOrFail();

        authorize($note['user_id'] === $this->currentUserId);

        $db->query('delete from notes where id = :id', [
            'id' => $_POST['id']
        ]);

        header('location: /notes');
        exit();

    }

    public function edit()
    {
        $db = App::resolve(Database::class);

        $note = $db->query('select * from notes where id = :id', [
            'id' => $_GET['id']
        ])->findOrFail();

        authorize($note['user_id'] === $this->currentUserId);

        view("notes/edit.view.php", [
            'heading' => 'Edit Note',
            'errors' => [],
            'note' => $note
        ]);
    }

    public function index()
    {
        $this->currentUserId = $_SESSION['user']['id'];

        $db = App::resolve(Database::class);
        $notes = $db->query('select * from notes where user_id = :id', [
            'id' => $this->currentUserId
        ])->get();

        view("notes/index.view.php", [
            'heading' => 'My Notes',
            'notes' => $notes
        ]);
    }

    public function show()
    {
        $db = App::resolve(Database::class);

        $note = $db->query('select * from notes where id = :id', [
            'id' => $_GET['id']
        ])->findOrFail();

        authorize($note['user_id'] === $this->currentUserId);

        view("notes/show.view.php", [
            'heading' => 'Note',
            'note' => $note
        ]);

    }

    public function store()
    {
        $db = App::resolve(Database::class);
        $errors = [];

        if (! Validator::string($_POST['body'], 1, 1000)) {
            $errors['body'] = 'A body of no more than 1,000 characters is required.';
        }

        if (! empty($errors)) {
            return view("notes/create.view.php", [
                'heading' => 'Create Note',
                'errors' => $errors
            ]);
        }

        dd($this->currentUserId);

        $db->query('INSERT INTO notes(body, user_id) VALUES(:body, :user_id)', [
            'body' => $_POST['body'],
            'user_id' => $this->currentUserId
        ]);

        header('location: /notes');
        die();

    }

    public function update()
    {
        $db = App::resolve(Database::class);

// find the corresponding note
        $note = $db->query('select * from notes where id = :id', [
            'id' => $_POST['id']
        ])->findOrFail();

// authorize that the current user can edit the note
        authorize($note['user_id'] === $this->currentUserId);

// validate the form
        $errors = [];

        if (! Validator::string($_POST['body'])) {
            $errors['body'] = 'A body of no more than 1,000 characters is required.';
        }

// if no validation errors, update the record in the notes database table.
        if (count($errors)) {
            return view('notes/edit.view.php', [
                'heading' => 'Edit Note',
                'errors' => $errors,
                'note' => $note
            ]);
        }

        $db->query('update notes set body = :body where id = :id', [
            'id' => $_POST['id'],
            'body' => $_POST['body']
        ]);

// redirect the user
        header('location: /notes');
        die();

    }
}