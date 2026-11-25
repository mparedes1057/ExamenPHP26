<?php

use Core\App;
use Core\Container;
use Core\Database;
use \Http\controllers\notes\NotesController;
use \DAO\DAOFactory;

$container = new Container();

$container->bind('Core\Database', function () {
    $config = require base_path('config.php');

    return new Database($config['database']);
});

$container->bind('Http\controllers\notes\NotesController', function () {
    return new NotesController(DAOFactory::createNotesDAO());
});
//132430Wm
App::setContainer($container);
