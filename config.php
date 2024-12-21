<?php
namespace config;
// 定义配置参数
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "demo";
$redis_address = '127.0.0.1';
$redis_port = '6379';
$template = 'default';
$tokenPre = 'axe';//token前缀，用于识别不同题库



$mysql = [$servername, $username, $password, $dbname];
$redis = [$redis_address, $redis_port];
// 获取配置的通用方法
function get($name)
{
    global $$name;

    // 检查变量是否已定义
    if (!isset($$name)) {
        throw new \Exception("Config variable '{$name}' is not defined.");
    }

    // 返回变量值
    return $$name;
}