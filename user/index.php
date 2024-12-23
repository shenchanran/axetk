<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/lib/view.php');
$view = new view();
$showpage = 'index';
if(isset($_GET['sp'])){
    $showpage = $_GET['sp'];
}
include $view->user($showpage);