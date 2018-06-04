<?php
class Dispatcher
{
    private $system_root;
    
    public function setSystemRoot($path) {
        $this->system_root = rtrim($path, '/');
    }
    
    public function dispatch() {
        $request_uri = ltrim($_SERVER['REQUEST_URI'], '/');
        if ($request_uri === '/index.php' || $request_uri === '/' || $request_uri === '') {
            $this->run();
            return;
        }
        
        $action_params = explode('/', $request_uri);
        $controller = ucfirst($action_params[0]).'Controller';
        $action = lcfirst(ucwords($action_params[1])).'Action';
        
        $this->run($controller, $action);
        
    }
    
    public function run($class_name = 'IndexController', $action_method = 'indexAction') {
        require_once $this->system_root . '/controllers/' . $class_name . '.php';
        
        $controller_instance = new $class_name();    
        $controller_instance->$action_method();
    }
}
