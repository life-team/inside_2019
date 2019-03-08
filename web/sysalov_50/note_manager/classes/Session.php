<?php

class Session
{
    public static function is_auth()
    {
        if(isset($_SESSION['auth'])){
            return true;
        }else{
            return false;
        }
    }
    public static function create_auth($id)
    {
        if(!self::is_auth())
        {
            $_SESSION['auth']=$id;
        }
        return true;
    }
    public static function deauth()
    {
        unset($_SESSION['auth']);
        return true;
    }
    /*
    public static function set_define_auth()
    {
        $auth_status = false;
        if(self::is_auth()){
            $auth_status = true;
        }
        define('auth',$auth_status);
    }
    */
    public static function remove_auth()
    {
        if(self::is_auth())
        {
            unset($_SESSION['auth']);
            return;
        }
    }
    public static function get_user_id()
    {
        if(self::is_auth())
        {
            return $_SESSION['auth'];
        }
    }

}