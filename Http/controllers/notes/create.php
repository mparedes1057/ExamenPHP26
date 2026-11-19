<?php
use \Http\controllers\notes\NotesController;
dd(NotesController::$instance);
NotesController::$instance->create();