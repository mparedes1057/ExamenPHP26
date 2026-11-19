<?php

$router->get('/', 'index.php');
$router->get('/about', 'about.php');
$router->get('/contact', 'contact.php');

$router->get('/notes', $noteController->index())->only('auth');
$router->get('/note', $noteController->show());
$router->delete('/note', $noteController->destroy());

$router->get('/note/edit', $noteController->edit());
$router->patch('/note', $noteController->update());

$router->get('/notes/create', $noteController->create());
$router->post('/notes', $noteController->store());

$router->get('/register', 'registration/create.php')->only('guest');
$router->post('/register', 'registration/store.php')->only('guest');

$router->get('/login', 'session/create.php')->only('guest');
$router->post('/session', 'session/store.php')->only('guest');
$router->delete('/session', 'session/destroy.php')->only('auth');
