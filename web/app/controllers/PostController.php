<?php

require_once(__DIR__ . '/../lib/mytemplate/class/MyTemplate.class.php');
require_once(__DIR__ . '/../lib/security/Token.php');
require_once(__DIR__ . '/../lib/auth/Auth.php');
require_once(__DIR__ . '/../lib/session/Session.php');
require_once(__DIR__ . '/../models/Post.php');
require_once(__DIR__ . '/../domains/validators/PostValidator.php');
require_once(__DIR__ . '/../domains/models/PostService.php');

/**
 * 記事に関する制御を行うController
 * ログインが確認できない場合には基本的にTop画面へ遷移する。
 */
class PostController
{
    private $mytemplate;
    private $service;
    private $validator;
    private $token;
    private $errors;
    
    const KEY_TITLE     = 'title';
    const KEY_CONTENT   = 'content';
    const KEY_TOKEN     = 'dual_trans_token';
    
    public function __construct(PDO $pdo) {
        $this->mytemplate = new MyTemplate();
        $this->post       = new Post($pdo);
        $this->service    = new PostService($pdo);
        $this->validator  = new PostValidator();
        $this->token      = new Token();
        $this->errors     = [];
    }
    
    /**
     * 記事新規投稿画面の表示
     *
     * @return void
     */
    public function createAction() {
        
        $is_login = Auth::isLogin();
        
        if ($is_login === false) {
            header('Location: /');
            return;
        }
        
        $this->mytemplate->setTemplate('post_create.tpl');
        $this->mytemplate->show();
    }
    
    /**
     * 記事新規投稿の内容確認の処理
     *
     * @return void
     */
    public function confirmAction() {
        
        $is_login = Auth::isLogin();
        
        if ($is_login === false) {
            header('Location: /');
            return;
        }
        
        
        // TODO: ここのチェックについてはきり出せそうな気がしているが、別の機会に切り出すこととする。
        if ($this->validator->isCorrectPost() === false) {
            $this->mytemplate->showError('入力されるべき値がありません。');
            return;
        }
        
        $is_empty_title   = $this->validator->isEmptyStr($_POST[self::KEY_TITLE]);
        $is_empty_content = $this->validator->isEmptyStr($_POST[self::KEY_CONTENT]);
        
        if ($is_empty_title === true || $is_empty_content === true) {
            $this->mytemplate->showError('タイトルか内容が空欄です。');
            return;
        }
        
        $title            = $_POST[self::KEY_TITLE];
        $content          = $_POST[self::KEY_CONTENT];
        
        $this->token->set();
        $dual_trans_token = $this->token->get();
        
        $this->mytemplate->setTemplate('post_confirm.tpl');
        $this->mytemplate->assign(self::KEY_TITLE, $title);
        $this->mytemplate->assign(self::KEY_CONTENT, $content);
        $this->mytemplate->assign(self::KEY_TOKEN, $dual_trans_token);
        $this->mytemplate->show();
    }
    
    /**
     * 記事新規投稿する処理
     *
     * @return void
     */
    public function registerAction() {
        
        $is_login = Auth::isLogin();
        
        if ($is_login === false) {
            header('Location: /');
            return;
        }
        
        // TODO: ここのチェックについてはきり出せそうな気がしているが、別の機会に切り出すこととする。
        if ($this->validator->isCorrectPost() === false) {
            $this->mytemplate->showError('入力されるべき値がありません。');
            return;
        }
        
        if ($this->validator->isCorrectToken() === false) {
            $this->mytemplate->showError('二重送信です。');
            return;
        }
        
        $this->token->free();
        
        $template_message = '記事の登録';
        
        $user_id = (int)Session::get(Session::KEY_USER_ID);
        $title   = $_POST[self::KEY_TITLE];
        $content = $_POST[self::KEY_CONTENT];
        
        $last_insert_id = $this->post->insertGetId($user_id, $title, $content);
        
        if (is_string($last_insert_id) === false) {
            $this->listAction();
            return;
        }
        
        header("Location: /post/detail/{$last_insert_id}");
        return;
    }
    
    /**
     * 記事一覧を表示する処理。
     * 基本的にはログイン後のTop画面となる。
     *
     * @return void
     */
    public function listAction() {
        
        $is_login = Auth::isLogin();
        
        if ($is_login === false) {
            header('Location: /');
            return;
        }
        
        $posts     = $this->service->getForPostList();
        $user_name = Session::get(Session::KEY_USER_NAME);
        
        $this->mytemplate->setTemplate('post_list.tpl');
        $this->mytemplate->assign(Session::KEY_USER_NAME, $user_name);
        $this->mytemplate->assign('posts', $posts);
        $this->mytemplate->show();
    }
    
    /**
     * 記事の詳細画面
     * TODO: とりあえずの実装でここにコメントを入れたが、果たしてここでいいのかわからない
     *
     * @param  string $post_id Dispatcherの処理の都合上都合が良いのでstringとする
     * @return void
     */
    public function detailAction($post_id) {
        
        $is_login = Auth::isLogin();
        
        if ($is_login === false) {
            header('Location: /');
            return;
        }
        
        if (isset($post_id) === false) {
            header('Location: /post/list');
            return;
        }
        
        $post     = $this->service->getForPostDetail($post_id);
        $comments = $this->service->getCommentsByPostId($post_id);
        
        $this->token->set();
        $dual_trans_token = $this->token->get();
        
        $this->mytemplate->setTemplate('post_detail.tpl');
        $this->mytemplate->assign('post', $post);
        $this->mytemplate->assign('comments', $comments);
        $this->mytemplate->assign('dual_trans_token', $dual_trans_token);
        $this->mytemplate->show();
        
        return;
    }
    
    
    public function searchAction($search_word) {
        $post = $this->post->search($search_word);
        
        echo json_encode($post);
    }
}