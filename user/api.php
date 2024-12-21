<?php
header('Content-Type: application/json');
$jsonData = file_get_contents('php://input');
if (!$jsonData) {
    die(json_encode(['code' => 0, 'msg' => '参数错误']));
}
$data = json_decode($jsonData, true); // 第二个参数为 true 表示解析为关联数组
if (json_last_error() !== JSON_ERROR_NONE) {
    die(json_encode(['code' => 0, 'msg' => '参数错误']));
}
if(!isset($data['act'])){
    die(json_encode(['code' => 0, 'msg' => '参数错误']));
}
$act = $data['act'];
switch ($act) {
    case 'reg':
        if (!$data || !isset($data['email']) || !isset($data['username']) || !isset($data['password']) || !isset($data['captchacode'])) {
            die(json_encode(['code' => 0, 'msg' => '参数错误']));
        }
        if (!preg_match('/\d{6}/', $data['captchacode'])) {
            die(json_encode(['code' => 0, 'msg' => '验证码错误']));
        }
        /*
        这里是验证码验证，暂未完成
        */
        if (!preg_match('/^[A-Za-z0-9\u4e00-\u9fa5]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/', $data['email'])) {
            die(json_encode(['code' => 0, 'msg' => '邮箱格式不符']));
        }
        if (strlen($data['password']) < 6 || strlen($data['password']) > 16) {
            die(json_encode(['code' => 0, 'msg' => '密码长度不符']));
        }
        if (!preg_match('/[0-9a-zA-Z]{6,16}/', $data['username'])) {
            die(json_encode(['code' => 0, 'msg' => '用户名格式不符']));
        }
        require_once("{$_SERVER['DOCUMENT_ROOT']}/lib/tools.php");
        $pass = Tools::encryptPassword($data['password']);
        require_once("{$_SERVER['DOCUMENT_ROOT']}/lib/mysql.php");
        $mysql = new mysql();
        $existUser = $mysql->Select(['user', 1, 'OR'], ['username', $data['username']], ['email', $data['email']]);
        if (count($existUser) != 0) {
            die(json_encode(['code' => 0, 'msg' => '用户名/邮箱已存在']));
        }
        require_once("{$_SERVER['DOCUMENT_ROOT']}/lib/tools.php");
        $randomToken = Tools::randomToken();
        $insertResult = $mysql->Insert('user', ['username' => $data['username'], 'email'=>$data['email'],'password' => $pass, 'token' => $randomToken]);
        if (!$insertResult) {
            die(json_encode(['code' => 0, 'msg' => '注册失败，请重试']));
        }
        Tools::setcookie('token',$randomToken,604800);
        die(json_encode(['code' => 1, 'msg' => '注册成功']));
    case 'login':
        if (!$data || !isset($data['username']) || !isset($data['password']) || !isset($data['captchacode'])) {
            die(json_encode(['code' => 0, 'msg' => '参数错误']));
        }
        if (!preg_match('/\d{6}/', $data['captchacode'])) {
            die(json_encode(['code' => 0, 'msg' => '验证码错误']));
        }
        /*
        这里是验证码验证，暂未完成
        */
        require_once("{$_SERVER['DOCUMENT_ROOT']}/lib/tools.php");
        $pass = Tools::encryptPassword($data['password']);
        require_once("{$_SERVER['DOCUMENT_ROOT']}/lib/mysql.php");
        $mysql = new mysql();
        $existUser = $mysql->Select(['user', 1, 'OR'], ['username', $data['username']], ['email', $data['username']]);
        if (count($existUser) == 0) {
            die(json_encode(['code' => 0, 'msg' => '用户不存在']));
        }
        if($pass!=$existUser['password']){
            die(json_encode(['code' => 0, 'msg' => '密码错误']));
        }
        $token = $existUser['token'];
        Tools::setcookie('token',$token,604800);
        die(json_encode(['code' => 1, 'msg' => '登陆成功']));
    case 'logout':
        require_once("{$_SERVER['DOCUMENT_ROOT']}/lib/tools.php");
        Tools::removecookie('token');
        die(json_encode(['code' => 1, 'msg' => '您已退出登录']));
}
