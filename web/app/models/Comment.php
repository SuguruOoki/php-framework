<?php

require_once(__DIR__ . '/BaseModel.php');

class Comment extends BaseModel
{
    private $pdo;
    
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }
    
    /**
     * commentsテーブルへinsertを行う。
     *
     * @param  int    $user_id コメントを投稿するユーザのId
     * @param  int    $post_id 記事のId
     * @param  string $content コメントの内容
     * @return bool
     */
    public function insertSingleRecord(int $user_id, int $post_id, string $content) : Bool {
        
        try {
            
            $this->pdo->beginTransaction();
            
            $sql      = "INSERT INTO `comments` (`user_id`, `post_id`, `content`)
                        VALUES (:user_id, :post_id, :content)";
            
            $is_exist = $this->pdo->prepare($sql);
            
            if ($is_exist === false) {
                return false;
            }
            
            $is_exist->bindParam('user_id', $user_id);
            $is_exist->bindParam('post_id', $post_id);
            $is_exist->bindParam('content', $content);
            
            $is_success = $is_exist->execute();
            $this->pdo->commit();
            
            return $is_success;
            
        } catch(PDOException $e) {
            $this->pdo->rollback();
            echo 'DBにおけるエラー: ' . $e;
        }
    }
    
    /**
     * コメントをpost_idから取得
     *
     * @param  int $post_id 記事のId
     * @return array|bool SELECTに成功したら結果の連想配列, 失敗したらfalse
     */
    public function getByPostId($post_id) {
        
        $sql = "SELECT `user_id`, `content`, `created_at`
                FROM `comments`
                WHERE `post_id` = :post_id
                LIMIT 50";
        
        $stmt = $this->pdo->prepare($sql);
        
        $stmt->bindparam(':post_id', $post_id);
        
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    }
    
    /**
     * すでに存在しているユーザかをチェックする
     *
     * @param  string $email ユニークなキーであるemailでチェック
     * @return bool SELECTを行い、すでに同じemailが１件以上あればtrue, なければfalse
     */
    public function isExistByPostId($post_id) {
        
        $sql  = "SELECT COUNT(`id`) AS `count`
                FROM `comments`
                WHERE `post_id` = :post_id";
        
        $stmt = $this->pdo->prepare($sql);
        
        $stmt->bindparam(':post_id', $post_id);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result['count'] > 0) {
            return true;
        }
        
        return false;
    }
}