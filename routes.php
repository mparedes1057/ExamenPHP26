<?php

$router->get('/', 'index.php');
$router->get('/about', 'about.php');
$router->get('/contact', 'contact.php');

$notesController = 'Http\controllers\notes\NotesController';
$router->get('/notes', $notesController . '@index')->only('auth');
$router->get('/note', $notesController . '@show');
$router->delete('/note', $notesController . '@destroy');

$router->get('/note/edit', $notesController . '@edit');
$router->patch('/note', $notesController . '@update');

$router->get('/notes/create', $notesController . '@create')->only('auth');
$router->post('/notes', $notesController . '@store');

$router->get('/register', 'registration/create.php')->only('guest');
$router->post('/register', 'registration/store.php')->only('guest');

$router->get('/login', 'session/create.php')->only('guest');
$router->post('/session', 'session/store.php')->only('guest');
$router->delete('/session', 'session/destroy.php')->only('auth');
