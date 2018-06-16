<?php 

// TODO: こう書きたいのためのコメント。設計ミスっててDBのあたりリレーションを入れて直してからこのようにする。
// require_once(__DIR__ . '/../models/User.php');
// require_once(__DIR__ . '/../models/Post.php');

/**
 * Postをメインとしたビジネスロジックをまとめるクラス
 */
class PostService
{
    private $pdo;
    
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }
    
    // TODO: 本当はこう書きたい。かつDBにもリレーション用のテーブルなど欲しい。
    // private $user;
    // private $post;
    // 
    // public function __construct() {
    //     $this->user = new User();
    //     $this->post = new Post();
    // }
    
    /**
     * postのuser_idを利用し、UserモデルとJOINを行い、
     * そのあとに情報をとってくる。
     * 
     * TODO: 本当であれば、このような形ではなく、PostモデルとUserモデルを
     * 使ってとってくるようにロジックを組みたいが、DBにリレーションDBがない関係で
     * 難しいかも。案が思い浮かばないので、仮の対応としてこのようにする。
     *
     * @return array|false SELECTに成功したら結果の連想配列, 失敗したらfalse
     */
    public function getForPostList() {
        // ページネーションの関係で仮の値としてLIMIT 50を入れている。
        $sql = "SELECT `posts`.`id`, `users`.`name` AS `user_name`, `posts`.`title`, `posts`.`created_at`
                FROM `posts`
                INNER JOIN `users` ON `posts`.`user_id` = `users`.`id`
                ORDER BY `posts`.`created_at`
                LIMIT 50";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    }
    
    /**
     * 記事詳細画面に必要な情報(記事, ユーザ情報)を記事のIdから取得する
     *
     * @param  string $post_id 記事のIdでDispatcherの処理で都合が良いのでstring
     * @return array|bool SELECTに成功したら結果の連想配列、失敗したらfalse
     */
    public function getForPostDetail($post_id) {
        
        $sql = "SELECT `users`.`name` AS `user_name`, `posts`.`title`, `posts`.`content`, `posts`.`created_at`
                FROM `posts`
                INNER JOIN `users` ON `posts`.`user_id` = `users`.`id`
                WHERE `posts`.`id` = :post_id LIMIT 1";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindparam(':post_id', $post_id);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result;
    }
    
    /**
     * 記事詳細画面に必要なコメントをユーザ名と共に取得する
     *
     * @param  string $post_id 記事のId。リクエストで送られてくるpost_idを処理する関係上stringとする。
     * @return array|bool SELECTに成功したら結果の連想配列、失敗したらfalse
     */
    public function getCommentsByPostId($post_id) {
        $sql = "SELECT `users`.`name` AS `user_name`, `comments`.`content`, `comments`.`created_at`
                FROM `comments`
                INNER JOIN `users`
                ON `comments`.`user_id` = `users`.`id`
                WHERE `comments`.`post_id`=:post_id
                LIMIT 50";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindparam(':post_id', $post_id);
        $stmt->execute();
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    }
}