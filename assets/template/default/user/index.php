<?php
/* 此页面实现用户访问/user/目录未携带任何参数时，根据cookies判断用户是否登录，实现指定页面的跳转，请按需修改 */
$domain = $_SERVER['HTTP_HOST']; 
$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https://' : 'http://';
$uri = $_SERVER['REQUEST_URI'];
$new_url = $protocol . $domain . "/user/?sp=";
// 进行跳转
header("Location: " . $new_url);
if(!isset($_COOKIE['token'])){
    header("Location: {$new_url}login");  // 重定向到新的 URL
}else{
    header("Location: {$new_url}usercenter");  // 重定向到新的 URL
}
exit();