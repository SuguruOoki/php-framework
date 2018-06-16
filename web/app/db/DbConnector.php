<?php

require_once(__DIR__ . '/../config/reader.php');

/**
 * DBへの接続情報について扱うクラス。
 * TODO: 今後BaseModelとして扱えるようにリファクタしていきたい。
 */
class DbConnector
{
    
    private $pdo;
    private $db_config;
    const KEY_DEVELOPMENT = 'DEVELOPMENT_CONNECTION_INFO';
    const KEY_PRODUCTION  = 'PRODUCTION_CONNECTION_INFO';
    
    private function __construct() {
        $this->db_config = ConfigReader::readDbConfig();
    }
    
    /**
     * 接続情報を元にPdoオブジェクトを生成する
     *
     * @return void
     */
    private function createPdo() {
        
        if (is_null($this->pdo) === false) {
            return $this->pdo;
        }
        
        if (is_null($this->db_config) === true) {
            throw new Exception("DBの接続情報がありません");
        }
        
        try {
            $app_env = getenv('APP_ENV');
            
            if($app_env === 'development') {
                $info = $this->db_config[self::KEY_DEVELOPMENT];
            } else if($app_env === 'production') {
                $info = $this->db_config[self::KEY_PRODUCTION];
            }
            
            $dsn      = "mysql:dbname={$info['dbname']};host={$info['host']}";
            $user     = $info['user'];
            $password = $info['password'];
            
            $this->pdo = new PDO($dsn, $user, $password);
            
        } catch(Exception $e) {
            echo '接続失敗: ' . $e;
        }
    }
    
    /**
     * 外部からPDOを取得するメソッド
     * @return PDO
     * @throws Exception
     */
    final public static function getPdo()
    {
        static $instance;

        if(is_null($instance) === true) {
            $instance = new static;
        }

        if(is_null($instance->pdo)) {
            $instance->createPdo();
        }

        return $instance->pdo;
    }
    
    /**
     * 新しいinstanceを作ろうとした場合に例外を投げる。
     *
     * @return void
     */
    final public function __clone() {
        throw new Exception("これはシングルトンなので、Instanceの生成を禁止しています。");
    }

}