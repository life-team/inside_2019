<?php

function autoloader($class) {
    require_once 'classes/'.$class . '.php';
}
spl_autoload_register('autoloader');

session_start();


$Settings = new Settings();
$Note = new Note($Settings->myslqi());


$a = explode('/',$_SERVER['SCRIPT_NAME']);
$script = explode('?',$a[count($a)-1])[0];

if(Session::is_auth()){
    if($script=='auth.php' || $script=='registration.php'){
        header("Location: add_note.php");
    }
}else{
    if($script!='auth.php') {
        if($script!='registration.php') {
            header("Location: registration.php");
            exit;
        }
    }
}

