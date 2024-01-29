<?php

spl_autoload_register(function($classname){ 
    $repositoryFilename = "../app/repositories/" . ucfirst($classname) . ".php";
    if (file_exists($repositoryFilename)) {
        require $repositoryFilename;
    }

    $modelFilename = "../app/models/" . ucfirst($classname) . ".php";
    if (file_exists($modelFilename)) {
        require $modelFilename;
    }
});


require 'config.php';
require 'functions.php';
require 'Database.php';
require 'Model.php';
require 'Controller.php';
require 'App.php';