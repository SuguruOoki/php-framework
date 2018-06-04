<?php
class MyTemplate
{
    // $vars: テンプレートで扱う変数を保存するための配列
    private $vars = [];
    private $template = '';
    
    public function __construct() {
        $this->setBaseDir();
    }
    
    private function setBaseDir() {
        $this->base_dir = dirname(__FILE__, 2).'/template/';
    }
    
    /**
     * 使用するテンプレートを指定するメソッド。
     *
     * @param string $template テンプレートの絶対パス
     */
    public function setTemplate($template) {
        $template = realpath($this->base_dir . $template);
        
        if (!is_file($template)) {
            throw new \Exception('can\'t read file: ' . $this->base_dir . $template);
        }
        
        $this->template = $template;
    }
    
    /**
     * テンプレートで使用する変数を保存する。
     * 事前にテンプレートをsetTemplateメソッドで指定しておく必要がある。
     *
     * @see MyTemplate::setTemplate
     * @param  string     $key   テンプレートで使用する変数名
     * @param  string     $value 上記の変数に格納する値
     * @return void
     */
    public function assign($key, $value) {
        $this->vars[$key] = $value;
    }
    
    /**
     * 使うテンプレートにassignで保存した値を展開し、requireを利用して表示。
     *
     * @return void
     */
    public function display() {
        extract($this->vars);
        require_once $this->template;
    }
    
    /**
     * 使うテンプレートにassignで保存した値を展開し、requireを利用して表示。
     *
     * @param array $errors エラーメッセージの配列
     * @return void
     */
    public function displayError(array $errors) {
        $this->setTemplate('errors.tpl');
        $this->assign('errors', $errors);
        require_once $this->template;
    }
    
    /**
     * エスケープが必要な文字列をエスケープする。
     * テンプレートに展開する前に使用する。
     *
     * @param  string $pre_escape_str エスケープ前の文字列
     * @return string エスケープ済の文字列
     */
    private function escapeHtml($pre_escape_str) {
        return htmlspecialchars($pre_escape_str, ENT_QUOTES, 'UTF-8', false);
    }
}