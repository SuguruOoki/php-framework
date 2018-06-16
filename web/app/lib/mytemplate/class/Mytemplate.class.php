<?php

/**
 * テンプレートエンジンとして利用するクラス。
 * TODO: 今後できればCacheなども実装してみたい。また、VIEWとテンプレートの役割分けをしっかりと行う。
 */
class MyTemplate
{
    // テンプレート内で使用する変数を保存する
    private $vars     = [];
    private $template = '';
    public $base_dir  = '';
    
    public function __construct() {
        $this->base_dir = dirname(__FILE__, 4) . "/views/template/";
    }
    
    /**
     * テンプレートをセットし、showメソッドの使用前に使うテンプレートを指定する。
     *
     * @param string $template 使用するテンプレートのアプソリュートパス
     */
    public function setTemplate($template) {
        $absolute_path            = $this->base_dir . $template;
        $normalized_absolute_path = realpath($absolute_path);
        
        if (is_file($normalized_absolute_path) === false) {
            // TODO: 将来的にはこのエラーログをロガーで出して、404などをユーザ側に表示させるようにしたい。
            // とりあえずはerrorのテンプレートを入れておくこととする
            $this->template = $this->base_dir . 'error.tpl';
        }

        $this->template = $normalized_absolute_path;
    }
    
    /**
     * テンプレート内で使用する変数をセットする
     *
     * @param  string $key   テンプレート内で使用する変数名
     * @param  mixed $value 上記の変数に格納するvalue
     * @return void
     */
    public function assign($key, $value) {
        $this->vars[$key] = $this->escapeHtml($value);
    }

    /**
     * 変数を展開し、テンプレートを表示する
     *
     * @return void
     */
    public function show() {
        
        // TODO: setTemplateのエラー処理を変更する場合はこちらも変更する可能性大
        if ($this->template === 'error.tpl' && $this->vars === []) {
            $this->vars[] = "指定したテンプレートが存在しませんでした: {$template}";
        }
        
        extract($this->vars);
        require_once $this->template;
    }
    
    /**
     * エラーメッセージを渡し、エラーを表示させるためのメソッド
     * @param string|array 表示させるエラーメッセージ
     * @return void
     */
    public function showError($errors) {
        $display_errors = [];
        
        $this->setTemplate('error.tpl');
        
        if (gettype($errors) === string) {
            $display_errors[] = $errors;
        } else {
            $display_errors = $errors;
        }
        
        $this->assign('errors', $display_errors);
        extract($this->vars);
        require_once $this->template;
    }
    
    /**
     * テンプレートに渡す文字列をエスケープする。
     * TODO: すっと入ってこないのでなんか違う気がする。
     *
     * @param  string|array $pre_escape エスケープ前の文字列
     * @return string|array 文字列で渡されたらエスケープ済の文字列、配列だったら中身をエスケープした配列
     */
    public static function escapeHtml($pre_escape) {
        
        if (is_array($pre_escape) === true) {
            $call_back_method = __METHOD__;
            return array_map($call_back_method, $pre_escape);
        }
        
        return htmlspecialchars($pre_escape, ENT_QUOTES);
    }
}