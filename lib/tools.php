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
    static function encryptPassword($password)
    {
        return md5($password . '/*--*#%$^&*&)');
    }
    static function setcookie($name, $value, $time = 3600)
    {
        setcookie($name, $value, time() + $time, "/");
        return true;
    }
    static function removecookie($name)
    {
        setcookie($name, "", time() - 3600, "/");
        return true;
    }
    static function matchtoken($token)
    {
        if (!preg_match('/[0-9a-z]{1,10}-[0-9a-z]{32}/', $token)) {
            return false;
        }
        return true;
    }
    static function getIp()
    {
        if (isset($_SERVER['http_cf_connecting_ip'])) { // 支持Cloudflare
            $ip = $_SERVER['http_cf_connecting_ip'];
        } elseif (isset($_SERVER['REMOTE_ADDR']) === true) {
            $ip = $_SERVER['REMOTE_ADDR'];
            if (preg_match('/^(?:127|10)\.0\.0\.[12]?\d{1,2}$/', $ip)) {
                if (isset($_SERVER['HTTP_X_REAL_IP'])) {
                    $ip = $_SERVER['HTTP_X_REAL_IP'];
                } elseif (isset($_SERVER['http_x_forewarded_for'])) {
                    $ip = $_SERVER['http_x_forewarded_for'];
                }
            }
        } else {
            $ip = '127.0.0.1';
        }
        if (in_array($ip, ['::1', '0.0.0.0', '本地主机'], true)) {
            $ip = '127.0.0.1';
        }
        $filter = filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
        if ($filter === false) {
            $ip = '127.0.0.1';
        }
        return $ip;
    }
}
