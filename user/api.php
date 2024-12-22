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
$token = false;
if (isset($_COOKIE['token'])) {
    $token = $_COOKIE['token'];
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
        if (!preg_match('/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/', $data['email'])) {
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
        $ip = Tools::getIp();
        require_once("{$_SERVER['DOCUMENT_ROOT']}/lib/mysql.php");
        $mysql = new mysql();
        $existUser = $mysql->Select(['user', 1, 'OR'], ['username', $data['username']], ['email', $data['email']]);
        if (count($existUser) != 0) {
            die(json_encode(['code' => 0, 'msg' => '用户名/邮箱已存在']));
        }
        require_once("{$_SERVER['DOCUMENT_ROOT']}/lib/tools.php");
        $randomToken = Tools::randomToken();
        $insertResult = $mysql->Insert('user', ['username' => $data['username'], 'email'=>$data['email'],'password' => $pass, 'token' => $randomToken,"regip"=>$ip]);
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
    case 'userinfo':
        if(!$token){
            die(json_encode(['code' => 0, 'msg' => '请先登录',"rl"=>true]));
        }
        require_once("{$_SERVER['DOCUMENT_ROOT']}/lib/tools.php");
        if(!Tools::matchtoken($token)){//token格式不符
            Tools::removecookie('token');
            die(json_encode(['code' => 0, 'msg' => '请先登录',"rl"=>true]));
        }
        require_once("{$_SERVER['DOCUMENT_ROOT']}/lib/mysql.php");
        $mysql = new mysql();
        $existUser = $mysql->Select(['user', 1], ['token', $token]);
        if (count($existUser) == 0) {
            die(json_encode(['code' => 0, 'msg' => '用户不存在']));
        }
        require_once("{$_SERVER['DOCUMENT_ROOT']}/lib/redis.php");
        $redis = new _Redis();
        $userredis = $redis->get(\config\get('userredis'),$token,["left"=>$existUser['left'],"time"=>-1,"fail"=>0]);
        $left = $userredis['left'];
        $lastTime = $userredis["time"];
        $redissuccess = $existUser['left']-$left;//redis中还未统计的成功次数
        $used = $existUser['used']+$redissuccess+$userredis['fail'];//数据库中的使用次数+redis中还未统计的成功次数+redis中的失败次数
        $success = $existUser['success']+$redissuccess;//数据库中的成功次数+redis中还未统计的成功次数
        die(json_encode(['code' => 1, 'msg' => '成功','data'=>["left"=>$left,"used"=>$used,"success"=>$success]]));
}
