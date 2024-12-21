<?php
require_once("{$_SERVER['DOCUMENT_ROOT']}/config.php");
class Tools
{
    static function randomToken()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 32; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return \config\get('tokenPre') . '-' . $randomString;
    }
    static function encryptPassword($password){
        return md5($password . '/*--*#%$^&*&)');
    }
    static function setcookie($name,$value,$time=3600){
        setcookie($name, $value, time() + $time, "/");
        return true;
    }
    static function removecookie($name){
        setcookie($name, "", time() - 3600, "/");
        return true;
    }
}
