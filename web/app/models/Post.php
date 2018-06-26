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
    * @return string|bool insertに成功したら、最後にinsertした行のidを取得。失敗したらfalse
    */
    public function insertGetId(int $user_id, string $title, string $content) {
        
        $this->pdo->beginTransaction();
        
        $sql = "INSERT INTO `posts` (`user_id`, `title`, `content`)
        VALUES (:user_id, :title, :content)";
        
        try {
            
            $is_exist = $this->pdo->prepare($sql);
            
            if ($is_exist === false) {
                return false;
            }
            
            $is_exist->bindParam('user_id', $user_id);
            $is_exist->bindParam('title', $title);
            $is_exist->bindParam('content', $content);
            
            $is_success     = $is_exist->execute();
            $last_insert_id = $this->pdo->lastInsertId('id');
            $this->pdo->commit();
            
            return $last_insert_id;
            
        } catch(PDOException $e) {
            $this->pdo->rollback();
            echo 'DBにおけるエラー: ' . $e;
        }
    }
    
    public function search($search_word) {
        
        $sql = "SELECT `title` FROM `posts` WHERE `title` LIKE :keyword";
        $keyword = "%".$search_word."%";
        $stmt = $this->pdo->prepare($sql);
        
        $stmt->bindParam(':keyword', $keyword);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    }
}