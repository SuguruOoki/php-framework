<?php

require_once(__DIR__ . '/BaseModel.php');

class Post extends BaseModel
{
    private $pdo;
    
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }
    
    /**
     * POSTテーブルへinsertを行う。
     *
     * @param  int $user_id    記事を投稿するユーザのID
     * @param  string $title   記事のタイトル
     * @param  string $content 記事の内容
     * @return bool
     */
    public function insertSingleRecord(int $user_id, string $title, string $content) : Bool {
        
        try {
            
            $this->pdo->beginTransaction();
            
            $sql = "INSERT INTO `posts` (`user_id`, `title`, `content`)
                    VALUES (:user_id, :title, :content)";
            
            $is_exist = $this->pdo->prepare($sql);
            
            if ($is_exist === false) {
                return false;
            }
            
            $is_exist->bindParam('user_id', $user_id);
            $is_exist->bindParam('title', $title);
            $is_exist->bindParam('content', $content);
            
            $is_success = $is_exist->execute();
            $this->pdo->commit();
            
            return $is_success;
            
        } catch(PDOException $e) {
            $this->pdo->rollback();
            echo 'DBにおけるエラー: ' . $e;
        }
    }
}