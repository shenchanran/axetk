<?php
namespace config;
// 定义配置参数
$servername = "localhost";
$username = "root6";
$password = "root6";
$dbname = "demo";
$redis_address = '127.0.0.1';
$redis_port = '6379';
$template = 'default';
$tokenPre = 'axe';//token前缀，用于识别不同题库
$userredis = 0;//用户数据存储的redis位置
$cdnpublic = 'https://lf3-cdn-tos.bytecdntp.com/cdn/expire-1-M/';//公共CDn地址
$sitename = 'AXE题库';//网站名
$sitekeyword = '';//网站关键词
$sitedescription = '';//网站描述
$sitekefu = 'shenchanran';


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