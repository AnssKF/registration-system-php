<?php

require_once './includes/fun.php';

require_once './models/db.model.php';
require_once './models/user.model.php';

require_once './controllers/home.controller.php';
require_once './controllers/member.controller.php';


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


session_start();

Db::connect();


if(isset($_COOKIE['loggedInUser'])){
    $user = new User();
    $user->getById($_COOKIE['loggedInUser']);
    $_SESSION['loggedInUser'] = $user;
}