<?php

require_once(dirname(__FILE__, 2) . '/lib/mytemplate/class/Mytemplate.class.php');

class TopController
{
    public function __construct() {
        $this->mytemplate = new MyTemplate();
    }
    
    public function indexAction() {
        $this->mytemplate->setTemplate('top.php');
        $this->mytemplate->assign('status', 'なにやら成功');
        $this->mytemplate->display();
    }
}