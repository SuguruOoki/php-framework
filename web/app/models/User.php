<?php

class User extends BaseModel
{
    
    /**
    * usersテーブルへのinsertを行うメソッド。
    *
    * @return void
    */
    public function insert() {
        
        try {
            
            $pdo = getPDO();
            $pdo->beginTransaction();
            
            $sql = "INSERT INTO `users` (`name`, `password`, `email`, `access_token`) VALUES ('$posted_username', '$hashed_password', '$posted_email_address', 'access_token')";
            
            $register_user = $pdo->prepare($sql);
            
            if (!$register_user) {
                echo "\nPDO::errorInfo():\n";
                throw new PdoException($pdo->errorInfo());
                exit();
            }
            
            $register_user->execute();
            $pdo->commit();
            
            // TODO: ログインページへ遷移させる処理を書く。ひとまずtopページに戻すように書く。
            // ステータスコードを出力
            http_response_code( 301 ) ;
            
            // リダイレクト
            header( "Location: /" );
            exit ;
            
        } catch(PDOException $e) {
            $pdo->rollback();
            echo 'DBにおけるエラー: ' . $e;
        }
    }
}