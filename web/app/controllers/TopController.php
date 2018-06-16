<?php 

require_once(__DIR__ . '/../lib/mytemplate/class/MyTemplate.class.php');

/**
 * ログイン前のTop画面についての制御を行うController
 */
class TopController
{
    private $mytemplate;
    
    public function __construct() {
        $this->mytemplate = new MyTemplate();
    }
    
    /**
     * サイト全体のTop画面のアクション
     *
     * @return void
     */
    public function indexAction() {
        $this->mytemplate->setTemplate('top.php');
        $this->mytemplate->show();
    }
}