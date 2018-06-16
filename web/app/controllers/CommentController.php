<?php 

require_once(__DIR__ . '/../models/Comment.php');
require_once(__DIR__ . '/../lib/security/Token.php');
require_once(__DIR__ . '/../lib/auth/Auth.php');
require_once(__DIR__ . '/../domains/validators/PostValidator.php');
require_once(__DIR__ . '/../lib/mytemplate/class/MyTemplate.class.php');

class CommentController
{
    const KEY_USER_ID = 'user_id';
    const KEY_CONTENT = 'content';
    private $comment;
    private $mytemplate;
    private $session;
    private $token;
    private $validator;
    
    public function __construct(PDO $pdo) {
        $this->comment    = new Comment($pdo);
        $this->mytemplate = new MyTemplate();
        $this->session    = new Session();
        $this->token      = new Token();
        $this->validator  = new PostValidator();
    }
    
    /**
     * コメントの新規投稿のメソッド
     * TODO: validationをPostValidatorでやっていますが、これはリファクタリングで
     * 修正する予定。
     * @return void
     */
    public function createAction() {
        
        $is_login = Auth::isLogin();
        
        if ($is_login === false) {
            header('Location: /');
            return;
        }
        
        if ($this->validator->isCorrectToken() === false) {
            $this->mytemplate->showError('正しいURLからの送信ではありません。');
            return;
        }
        
        $is_empty_comment = $this->validator->isEmptyStr($_POST[self::KEY_CONTENT]);
        
        if ($is_empty_comment === true) {
            // TODO: 今はエラーメッセージを渡せていないが、これからリファクタで渡すように
            // 修正をかける。時間が足りない場合はテンプレートで対応する。
            header("Location: {$_SERVER['HTTP_REFERER']}");
            return;
        }
        
        // TODO: 以下では入力の値をそのまま使っちゃっているが、clean_data的な奴も用意したい
        $user_id = (int)$_SESSION['user_id'];
        $post_id = (int)basename($_SERVER['HTTP_REFERER']);
        $content = $_POST[self::KEY_CONTENT]; 
        $this->comment->insertSingleRecord($user_id, $post_id, $content);
        header("Location: /post/detail/$post_id");
    }
    
    public function editAction() {
        // コメントをUPDATEして同じ/post/detailにredirectする
    }
    
    public function deleteAction() {
        // ポップアップなどでalertを出してから削除を実行する
        // 終了後同じ/post/detailにredirectする
    }
}