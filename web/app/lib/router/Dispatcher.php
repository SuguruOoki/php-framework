<?php
class Dispatcher
{
    private $system_root;
    private $controller_level;
    private $action_level;
    
    private function setSystemRoot($path) {
        $this->system_root = rtrim($path, '/');
    }
    
    /**
     * dispatchを始めるディレクトリの階層を指定する
     * 0はwebrootの階層を示す
     *
     * @param int $level Dispatchを始める階層。
     * @return void
     */
    private function setFirstDispatchLevel($level = 0) {
        $this->controller   = $level;
        $this->action_level = $level + 1;
    }
    
    /**
     * dispatchを行う
     * TODO: 現在は記事などのIDが入った時の処理を考慮していないため、入れたのちにはそこの処理を実装する
     *
     * @return void
     */
    public function dispatch() {
        $request_uri = ltrim($_SERVER['REQUEST_URI'], '/');
        if ($request_uri === '/index.php' || $request_uri === '/' || $request_uri === '') {
            $this->run();
            return;
        }
        
        $action_params = explode('/', $request_uri);
        $controller = ucfirst($action_params[$this->controller_level]).'Controller';
        $action = lcfirst(ucwords($action_params[$this->action_level])).'Action';
        
        $this->run($controller, $action);
        
    }
    
    /**
     * actionメソッドを実行する。
     * TODO: 記事の詳細を表示する場合などの考慮が足りないかも。
     *
     * @param  string $controller 実行するコントローラー
     * @param  string $action     実行するアクションメソッド
     * @return void
     */
    private function run($controller = 'TopController', $action = 'indexAction') {
        require_once $this->system_root . '/controllers/' . $controller . '.php';
        
        $controller_instance = new $controller();
        $controller_instance->$action_method();
    }
}
