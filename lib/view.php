<?php
require_once("{$_SERVER['DOCUMENT_ROOT']}/config.php");
class view
{
    public $template;
    public function __construct()
    {
        $this->template = \config\get('template');
    }
    public function index()
    {
        return "{$_SERVER['DOCUMENT_ROOT']}/assets/template/{$this->template}/index.php";
    }
    public function user($showPage = 'index')
    {
        return "{$_SERVER['DOCUMENT_ROOT']}/assets/template/{$this->template}/user/{$showPage}.php";
    }
    public function viewconfig()
    {
        $config = [
            'cdnpublic' => \config\get('cdnpublic'),
            'sitename' => \config\get('sitename'),
            'sitekeyword' => \config\get('sitekeyword'),
            'sitedescription' => \config\get('sitedescription'),
            'sitekefu' => \config\get('sitekefu'),
        ];
        return $config;
    }
}
