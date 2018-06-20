<?php

require_once(__DIR__ . '/BaseModel.php');

class User extends BaseModel
{
    private $pdo;
    
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }
    
    /**
     * usersテーブルへinsertを行う。単一レコードのみ。
     *
     * @param  string $username        POSTされたusername
     * @param  string $hashed_password password_hashが済んでいるpassword
     * @param  string $email           POSTされたemail
     * @return bool
     */
    public function insertSingleRecord(string $username, string $hashed_password, string $email) : Bool {
        
        try {
            $this->pdo->beginTransaction();
            
            $sql = "INSERT INTO `users` (`name`, `password`, `email`, `access_token`) VALUES ('$username', '$hashed_password', '$email', 'access_token')";
            
            $is_already_exist = $this->pdo->prepare($sql);
            
            if ($is_already_exist === false) {
                return false;
            }
            
            $is_success = $is_already_exist->execute();
            $this->pdo->commit();
            
            return $is_success;
            
        } catch(PDOException $e) {
            $this->pdo->rollback();
            echo 'DBにおけるエラー: ' . $e;
        }
    }
    
    /**
     * Emailでユーザのパスワードを取得する
     * 
     * @param  string $email パスワードを取得するためのメールアドレス
     * @return array|bool SELECTに成功したら結果の連想配列、失敗したらfalse
     */
    public function getPasswordByEmail($email) {
        
        $sql  = "SELECT `password` FROM `users` WHERE `email` = :email LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        
        $stmt->bindparam(':email', $email);
        
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result;
    }
    
    /**
     * すでに存在しているユーザかをチェックする
     *
     * @param  string $email ユニークなキーであるemailでチェック
     * @return bool SELECTを行い、すでに同じemailが１件以上あればtrue, なければfalse
     */
    public function isExistByEmail($email) {
        
        $sql  = "SELECT COUNT(`email`) AS `count` FROM `users` WHERE `email` = :email";
        $stmt = $this->pdo->prepare($sql);
        
        $stmt->bindparam(':email', $email);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result['count'] > 0) {
            return true;
        }
        
        return false;
    }
    
    
    /**
     * emailからIdを取得する
     *
     * @param  string $email ユニークなキーであるemailでチェック
     * @return array|bool SELECTに成功した場合は結果の配列, なければfalse
     */
    public function getIdByEmail($email) {
        
        $sql  = "SELECT `id` FROM `users` WHERE `email` = :email";
        $stmt = $this->pdo->prepare($sql);
        
        $stmt->bindparam(':email', $email);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result;
    }
    
    /**
     * emailからnameを取得する
     *
     * @param  string $email ユニークなキーであるemailでチェック
     * @return array|bool SELECTに成功した場合は結果の配列, なければfalse
     */
    public function getNameByEmail($email) {
        
        $sql  = "SELECT `name` AS `user_name` FROM `users` WHERE `email` = :email";
        $stmt = $this->pdo->prepare($sql);
        
        $stmt->bindparam(':email', $email);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result;
    }
}