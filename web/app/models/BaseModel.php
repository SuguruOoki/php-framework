<?php

class BaseModel
{
    function getPDO() {
        $DEVELOPMENT_CONNECTION_INFO = [
            'dbname'   => '2018_training',
            'host'     => 'db',
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
            // MySQLでホストが127.0.0.1のdevelopment_dbというDBに対してユーザ名root、パスワードrootでアクセスする。エラーが起きたら例外を投げる。
            $app_env = getenv('APP_ENV');
            if($app_env == 'development') {
                // 開発環境のDB接続情報でDB接続する
                $info = $DEVELOPMENT_CONNECTION_INFO;
            } else if($app_env == 'production') {
                // 本番環境のDB接続情報でDB接続する
                $info = $PRODUCTION_CONNECTION_INFO;
            }
            
            $dsn      = "mysql:dbname={$info['dbname']};host={$info['host']}";
            $user     = $info['user'];
            $password = $info['password'];
            
            $pdo = new PDO($dsn, $user, $password);
            return $pdo;
        } catch(Exception $e) {
            
            // DBサーバへ接続に失敗した場合
            // 1. ホスト名が間違っている、MySQLが起動していない
            // 2. 指定されたデータベースが存在しない
            // 3. ユーザ名、パスワードを間違えている など。
            
            echo '接続失敗: ' . $e->getMessage(); // 例外のメッセージを取得
        }
    }
}