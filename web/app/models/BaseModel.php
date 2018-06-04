<?php

class BaseModel
{
    protected $pdo;
    
    protected function __construct() {
        $this->pdo = $this->getPDO();
    }
    
    protected function getPDO() {
        $DEVELOPMENT_CONNECTION_INFO = [
            'dbname'   => '2018_training_test', 'host'     => 'db',
            'user'     => 'root',
            'password' => 'root',
        ];
        
        $PRODUCTION_CONNECTION_INFO = [
            'dbname'   => 'd9cdes7se0eu4dil',
            'host'     => 'xq7t6tasopo9xxbs.cbetxkdyhwsb.us-east-1.rds.amazonaws.com',
            'user'     => 'l5kjq0zznd4yjz2n',
            'password' => 'd9cdes7se0eu4dil',
        ];
        
        try {
            $app_env = getenv('APP_ENV');
            if($app_env == 'development') {
                $info = $DEVELOPMENT_CONNECTION_INFO;
            } else if($app_env == 'production') {
                $info = $PRODUCTION_CONNECTION_INFO;
            }
            
            $dsn      = "mysql:dbname={$info['dbname']};host={$info['host']}";
            $user     = $info['user'];
            $password = $info['password'];
            
            $pdo = new PDO($dsn, $user, $password);
            return $pdo;
        } catch(Exception $e) {
            echo '接続失敗: ' . $e->getMessage(); // 例外のメッセージを取得
        }
    }
}