<?php


class Settings
{
    private $mysqli;
    function __construct()
    {
        $this->mysqli = $this->connect_db();
    }
    private function connect_db(){
        $a = new mysqli('localhost', 'root', '', 'note_manager');
        if ($a->connect_error) {
            die('Ошибка подключения (' . $a->connect_errno . ') '
                . $a->connect_error);
        }
        return $a;
    }
    public function myslqi(){
        return $this->mysqli;
    }
}