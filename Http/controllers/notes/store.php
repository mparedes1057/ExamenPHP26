<?php
use \Http\controllers\notes\NotesController;
use Core\App;

$noteController = App::resolve(NotesController::class);
$noteController->store();