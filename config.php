<?php

session_start();

class Config {

    const DATABASE = [
        'host'      => 'localhost',
        'port'      => '3360',
        'name'      => 'regsys',
        'username'  => 'root',
        'password'  => ''
    ];


    const DIRS = [
    ];

}

require_once './includes/fun.php';

require_once './models/db.model.php';
require_once './models/user.model.php';

require_once './controllers/home.controller.php';
require_once './controllers/member.controller.php';



