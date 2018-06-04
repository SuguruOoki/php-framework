<?php

require_once __DIR__ . '/BaseModel.php';

class User extends BaseModel
{
    public function __construct() {
        parent::__construct();
    }
    
    /**
    * usersテーブルへのinsertを行うメソッド。
    *
    * @param string $username ユーザ名
    * @param string $hashed_password ハッシュ済みのパスワード
    * @param string $email メールアドレス
    * @return void
    */
    public function insertSingleRecord(string $username, string $hashed_password, string $email) {
        try {
            
            $this->pdo->beginTransaction();
            
            $sql = "INSERT INTO `users` (`name`, `password`, `email`, `access_token`) VALUES ('$posted_username', '$hashed_password', '$email', 'access_token')";
            
            $register_user = $this->pdo->prepare($sql);
            
            if ($register_user === false) {
                // echo "\nPDO::errorInfo():\n";
                // throw new PdoException($this->pdo->errorInfo());
                // exit();
                return false;
            }
            
            $is_success = $register_user->execute();
            $this->pdo->commit();
            
            // TODO: ログインページへ遷移させる処理を書く。ひとまずtopページに戻すように書く。
            return $is_success;
            
        } catch(PDOException $e) {
            $pdo->rollback();
            echo 'DBにおけるエラー: ' . $e;
        }
    }
    
    /**
    * 
    * @param string $email メールアドレス
    * @return bool|array SELECTに失敗したらfalse, 成功した場合はSELECTした結果の連想配列を返す
    */
    public function getByEmail(string $email) {
        try {
            $this->pdo->beginTransaction();
            $sql = "SELECT `name`, `password`, `email` FROM `users` WHERE `email`=:email";
            $prepare_statement = $this->setPrepareState($sql);
            $prepare_statement->bindValue('email', $email);
            
            if ($prepare_statement === false) {
                return false;
            }

            $is_success = $prepare_statement->execute();
            $this->pdo->commit();
            
            // TODO: ログインページへ遷移させる処理を書く。ひとまずtopページに戻すように書く。
            return $prepare_statement->fetch(PDO::FETCH_ASSOC);
            
        } catch(PDOException $e) {
            $this->pdo->rollback();
            echo 'DBにおけるエラー: ' . $e;
        }
    }
    
    /**
     * Passwordが正しいかをチェック
     *
     * @param  string $input_password 入力されたパスワード
     * @param  string $password       DBに登録されているパスワード
     * @return bool
     */
    public function isCorrectPassword($input_password, $register_password) {
        if (strcmp($input_password, $register_password) !== 0) {
            return false;
        }
        
        return true;
    }
    
    /**
     * プリペアドステートメントを用意するだけのメソッド
     *
     * @param  string $sql プリペアドステートメントとするSQL
     * @return bool prepareに成功したらPDO::Statementオブジェクト, 失敗したらfalseを返す
     */
    public function setPrepareState(string $sql) {
        
        $is_prepare = $this->pdo->prepare($sql);
        
        if ($is_prepare === false) {
            // TODO: Loggerクラスを作ったら、そちらに出力するように変更する
            // echo "\nPDO::errorInfo():\n";
            throw new PdoException($this->pdo->errorInfo());
            // return false;
        }
        
        return $is_prepare;
    }
}