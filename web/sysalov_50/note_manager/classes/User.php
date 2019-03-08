<?php


class User
{
    public static function create_user($mysqli,$name,$pass)
    {
        $mysqli->query('INSERT INTO `users`(`name`, `pass`) VALUES ("'.$name.'","'.self::get_pass_hash($pass).'")');
        $id = $mysqli->insert_id;
        Session::create_auth($id);
        return $id;
    }
    public static function auth_user($mysqli,$name,$pass)
    {
        $q = $mysqli->query('SELECT `id`, `pass` FROM `users` WHERE name="'.$name.'"');
        if($q->num_rows==1){
            $row = $q->fetch_assoc();
            if (self::get_pass_hash($pass) == $row['pass']) {
                $id = $row['id'];
                Session::create_auth($id);
                return $id;
            }                
        }
        return false;

    }
    private static function get_pass_hash($pass)
    {
        return hash('md5', $pass);
        return md5($pass);
    }
    public static function check_name_for_availability($mysqli,$name)
    {
        if($mysqli->query('SELECT id FROM users WHERE name="'.$name.'"')->num_rows==0){
            return true;
        }else{
            return false;
        }
    }
    public static function get_users($mysqli)
    {

        return $mysqli->query('SELECT id,name FROM `users` WHERE 1')->fetch_all(MYSQLI_ASSOC);
    }
    public static function get_user_name($mysqli,$item)
    {
        if(!is_numeric($item)) {
            $return = [];
            $item = json_decode($item, true);
            foreach ($item as $id) {
                $return[] = $mysqli->query('SELECT name FROM `users` WHERE id = ' . $id)->fetch_assoc()['name'];
            }
            if (!isset($return[1])) {
                return $return[0];
            } else {
                $out = '';
                foreach ($return as $item) {
                    $out .= $item . ', ';
                }
                return substr($out, 0, -2);
            }
        }else{
            return $mysqli->query('SELECT name FROM `users` WHERE id = ' . $item)->fetch_assoc()['name'];
        }
    }

}