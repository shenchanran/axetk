<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/lib/view.php');
$view = new view();
$viewconfig = $view->viewconfig();
include $view->index();