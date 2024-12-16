<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/lib/view.php');
$view = new view();
$showpage = 'index';
if(isset($_GET['showpage'])){
    $showpage = $_GET['showpage'];
}
include $view->user($showpage);