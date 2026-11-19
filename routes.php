<?php

$router->get('/', 'index.php');
$router->get('/about', 'about.php');
$router->get('/contact', 'contact.php');

$router->get('/notes', 'index')->only('auth');
$router->get('/note', 'show');
$router->delete('/note', 'destroy');

$router->get('/note/edit', 'edit');
$router->patch('/note', 'update');

$router->get('/notes/create', 'create');
$router->post('/notes', 'store');

$router->get('/register', 'registration/create.php')->only('guest');
$router->post('/register', 'registration/store.php')->only('guest');

$router->get('/login', 'session/create.php')->only('guest');
$router->post('/session', 'session/store.php')->only('guest');
$router->delete('/session', 'session/destroy.php')->only('auth');
