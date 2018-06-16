<?php

require_once(__DIR__ . '/../../db/DbConnector.php');

class Dispatcher
{
    const KEY_CONTROLLER      = 'controller';
    const KEY_ACTION          = 'action';
    private $sys_root;
    private $controller_level  = 0;
    private $action_level      = 1;
    private $action_attr_level = 2;
    
    /**
     *  /で分割。GETパラメータを無視するため、パラメーター取得（末尾,先頭の / は削除）
     *
     * @return void
     */
    public function dispatch() {
        
        $action_params = $this->getActionParamsByRequestUri();
        
        if (array_search('', $action_params, true) !== false || $action_params === []) {
            $this->run();
            return;
        }
        
        // TODO: この辺り書き方が冗長な気がしています。何かあれば指摘お願いします。
        // また、実行するコントローラーとメソッドが存在するかのチェックは後ほど実装します。
        $exec_params = $this->getControllerAndMethodByActionParams($action_params);
        $exec_attr   = $this->getActionAttr($action_params);
        
        $this->run($exec_params[self::KEY_CONTROLLER], $exec_params[self::KEY_ACTION], $exec_attr);
    }
    
    
    /**
     * REQUEST_URIから実行するcontrollerとactionの配列を取得する
     *
     * @return array
     */
    private function getActionParamsByRequestUri() {
        
        if (isset($_SERVER['REQUEST_URI']) === false) {
            return [];
        }
        
        $request_uri = ltrim($_SERVER['REQUEST_URI'], "/");
        
        return $action_params = explode('/', $request_uri);
    }
    
    
    /**
     * 指定されたURLから実行するcontrollerとactionを取得する
     *
     * @param  array  $action_params baseurlを省いたactionのurlの配列。
     * @return array 実行するControllerとActionMethodを連想配列で返す。
     *               $action_paramsの要素数が足りていない時は空の配列を返す。
     */
    private function getControllerAndMethodByActionParams(array $action_params) {
        $result = [];
        
        if (count($action_params) < $this->action_level) {
            return [];
        }
        
        
        $result[self::KEY_CONTROLLER] = ucfirst($action_params[$this->controller_level]);
        $result[self::KEY_ACTION] = $action_params[$this->action_level];
        
        return $result;
    }
    
    /**
     * 指定されたURLから実行する際に必要な引数を取得する
     * 例: PostController detailAction
     *
     * @param  array  $action_params baseurlを省いたactionのurlの配列。
     * @return string 実行するものの中にControllerとAction以外の要素があったらその要素を返す
     */
    private function getActionAttr(array $action_params) {
        
        if (count($action_params) < 3) {
            return '';
        }
        
        return $action_params[$this->action_attr_level];
    }
    
    
    /**
     * Actionを実行する
     *
     * @param  string $controller    実行するController
     * @param  string $action 実行するActionメソッド
     * @param  string $detail_id Actionの引数に使用する。存在しない時は空とする。
     * @return void
     */
    private function run($controller = 'Top', $action = 'index', $detail_id = '') {
        $exec_controller = $controller . 'Controller';
        $exec_action     = $action . 'Action';
        
        require_once $this->sys_root . '/controllers/' . $exec_controller . '.php';
        
        $controller_instance = new $exec_controller(DbConnector::getPdo());
        
        if ($detail_id === '') {
            $controller_instance->$exec_action();
            return;
        }
        
        $controller_instance->$exec_action($detail_id);
    }
    
    
    /**
     * webrootを設定するためのメソッド。
     *
     * @param string $path
     * @return void
     */
    public function setSystemRoot($path) {
        $this->sys_root = rtrim($path, '/');
    }
    
    
    /**
     * URLの階層設定。webディレクトリ以降のどの階層からをパラメータとして解釈するか。
     * 0であれば、webrootを指定しているのと同義。
     * @param int $dir_level パラメータのcontrollerとactionをdispatchに認識させる役割
     * @return void
     */
    public function setPramLevel($dir_level) {
        $this->controller_level = $dir_level;
        $this->action_level = $dir_level + 1;
    }
}