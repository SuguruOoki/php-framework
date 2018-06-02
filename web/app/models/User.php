<?php

class User 
{
    
    /**
    * usersテーブルへのinsertを行うメソッド。
    *
    * @return void
    */
    function insert() {
        
        $error_message = [];        
        $posted_username = $_POST["username"];
        $posted_email_address = $_POST["email"];
        $posted_password = $_POST["password"];
        $posted_re_password = $_POST["re-password"];
        $posted_secret_question = $_POST["secret-question"];
        $posted_secret_answer = $_POST["secret-answer"];
        
        $validator = new UserValidator();
        $validator->validateUserName($posted_username);
        $validator->validateEmailAddress($posted_email_address);
        $validator->validatePassword($posted_password, $posted_re_password);
        $validator->validateSecretQuestion($posted_secret_question);
        $validator->validateSecretAnswer($posted_secret_answer);
        
        $error_message = $validator->getError();
        
        if (count($error_message) > 0 || is_null($error_message) === true) {
            // TODO: 登録ページを再表示したいが、まだ諸々作成していないため、var_dumpでエラー文を出すにとどめる。
            // modalを使っている関係上、ajaxで送信を行い、返却したエラー文を表示されるように後々変更する。
            var_dump($error_message);
            exit;
        }
        
        // TODO: パスワードの認証時にはpassword_verifyを使う予定
        // 参考: https://qiita.com/rana_kualu/items/3ef57485be1103362f56
        $hashed_password = password_hash($posted_password, PASSWORD_BCRYPT);
        
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