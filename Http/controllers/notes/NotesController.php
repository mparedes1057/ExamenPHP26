<?php

namespace Http\controllers\notes;
use Core\App;
use Core\Validator;
use Inteficies\NotesDAO;

class NotesController
{
    private $currentUserId;
    private NotesDAO $notesDao;

    /**
     * @param $currentUserId
     */
    public function __construct(NotesDAO $notesDAOImpl)
    {
        $this->currentUserId = $_SESSION['user']['id'];
        $this->notesDao = $notesDAOImpl;
    }

    /**
     * @param mixed $currentUserId
     */


    public function create()
    {
        view("notes/create.view.php", [
            'heading' => 'Create Note',
            'errors' => []
        ]);
    }

    public function destroy()
    {
        $note = $this->notesDao->getById($_POST['id']);

        authorize($note['user_id'] === $this->currentUserId);

        $this->notesDao->delete($_POST['id']);

        header('location: /notes');
        exit();

    }

    public function edit()
    {
        $note = $this->notesDao->getById($_GET['id']);

        authorize($note['user_id'] === $this->currentUserId);

        view("notes/edit.view.php", [
            'heading' => 'Edit Note',
            'errors' => [],
            'note' => $note
        ]);
    }

    public function index()
    {
        $notes = $this->notesDao->getAllByUser($this->currentUserId);

        view("notes/index.view.php", [
            'heading' => 'My Notes',
            'notes' => $notes
        ]);
    }

    public function show()
    {
        $note = $this->notesDao->getById($_GET['id']);

        authorize($note['user_id'] === $this->currentUserId);

        view("notes/show.view.php", [
            'heading' => 'Note',
            'note' => $note
        ]);

    }

    public function store()
    {
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

        $this->notesDao->create($this->currentUserId, $_POST['body']);

        header('location: /notes');
        die();

    }

    public function update()
    {
// find the corresponding note
        $note = $this->notesDao->getById($_POST['id']);

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

        $this->notesDao->update($_POST['id'], $_POST['body']);

// redirect the user
        header('location: /notes');
        die();

    }
}