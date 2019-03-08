<?php

class Note
{
    private $mysqli;
    public function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }
    public function create($title,$desc)
    {
        $title = htmlspecialchars($title);
        $desc = htmlspecialchars($desc);
        $user_id = (int)Session::get_user_id();
        $this->mysqli->query('INSERT INTO `note`(`user_id`, `title`, `description`) VALUES ('.$user_id.',"'.$this->mysqli->escape_string($title).'","'.$this->mysqli->escape_string($desc).'")');
        return true;
    }
    private function check_user($user_id)
    {
        if($this->mysqli->query('SELECT name FROM users WHERE id='.(int)$user_id)->num_rows!=0)
        {
            return true;
        }else{
            return false;
        }
    }


    public function get_my_note_items()
    {
        $user_id = (int)Session::get_user_id();
        $notes = $this->mysqli->query('SELECT * FROM note WHERE user_id = ' . $user_id)->fetch_all(MYSQLI_ASSOC);

        return $notes;

    }
}