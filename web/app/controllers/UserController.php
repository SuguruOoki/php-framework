<?php

require_once(__DIR__ . '/../domains/validators/UserValidator.php');
require_once(__DIR__ . '/../lib/mytemplate/class/MyTemplate.class.php');
require_once(__DIR__ . '/../lib/auth/Auth.php');
require_once(__DIR__ . '/../models/User.php');
require_once(__DIR__ . '/../lib/session/Session.php');

/**
 * ユーザに関する制御を行うController
 */
class UserController
{
    const KEY_USER_NAME       = 'user_name';
    const KEY_EMAIL           = 'email';
    const KEY_PASSWORD        = 'password';
    const KEY_RE_PASSWORD     = 're-password';
    const KEY_SECRET_QUESTION = 'secret-question';
    const KEY_SECRET_ANSWER   = 'secret-answer';
    private $posted_email;
    private $posted_password;
    private $auth;
    private $session;
    private $users;
    private $mytemplate;
    private $validator;
    
    public function __construct(PDO $pdo) {
        $this->posted_email    = $_POST[self::KEY_EMAIL];
        $this->posted_password = $_POST[self::KEY_PASSWORD];
        $this->mytemplate      = new MyTemplate();
        $this->session         = new Session();
        $this->users           = new User($pdo);
        $this->validator       = new UserValidator();
    }
    
    
    /**
     * ログイン処理を行う。
     * ログインに成功したら記事一覧画面に遷移する。
     *
     * @see 遷移先 PostController::listAction
     * @return void
     */
    public function loginAction() {
        
        $is_empty_email    = $this->validator->isEmpty($this->posted_email);
        $is_empty_password = $this->validator->isEmpty($this->posted_password);
        
        if ($is_empty_email === true || $is_empty_password === true) {
            $this->mytemplate->showError('メールアドレスかパスワードが入力されていません。');
            return;
        }
        
        // TODO: 上記でメールが正しく入っていていることを前提としてしかパスワードの判定がうまく動かない
        $user_password = $this->users->getPasswordByEmail($this->posted_email);
        
        if ($user_password === false || $user_password === []) {
            $this->mytemplate->showError('メールアドレスかパスワードが間違っています。');
            return;
        }
        
        $is_correct_password = Auth::isCorrectPassword($this->posted_password, $user_password['password']);
        
        if ($is_correct_password === false) {
            $this->mytemplate->showError('メールアドレスかパスワードが間違っています。');
            return;
        }
        $user = $this->users->findByEmail($this->posted_email);
        
        $user_id   = $user->id;
        $user_name = $user->name;
        
        Auth::setLoginStatus($user_id, $user_name);
        
        header('Location: /post/list');
        return;
    }

    /**
     * ユーザの新規登録を行う。
     * 登録に成功したら記事一覧画面に遷移する。
     *
     * @see 遷移先 PostController::listAction
     * @return void
     */
    public function signUpAction() {
        
        $this->posted_username        = $_POST[self::KEY_USER_NAME];
        $this->posted_re_password     = $_POST[self::KEY_RE_PASSWORD];
        $this->posted_secret_question = $_POST[self::KEY_SECRET_QUESTION];
        $this->posted_secret_answer   = $_POST[self::KEY_SECRET_ANSWER];
        
        $this->validator->userNameStrBetween($this->posted_username);
        $this->validator->isEmail($this->posted_email);
        $this->validator->isCorrectPasswordFormat($this->posted_password, $this->posted_re_password);
        $this->validator->secretQuestionIdBetween($this->posted_secret_question);
        $this->validator->secretAnswerStrLenBetween($this->posted_secret_answer);
        
        $errors = $this->validator->getError();
        
        if (count($errors) > 0) {
            // TODO: 登録ページを再表示したいが、まだ諸々作成していないため、エラー文を出すにとどめる。
            // modalを使っている関係上、ajaxで送信を行い、返却したエラー文を表示されるように後々変更する。
            $this->mytemplate->showError($errors);
            return;
        }
        
        $hashed_password = password_hash($this->posted_password, PASSWORD_BCRYPT);
        $transition      = $this->users->insertSingleRecord($this->posted_username, $hashed_password, $this->posted_email);
        
        if ($transition === false) {
            $this->mytemplate->showError('登録に失敗しました。運営に問い合わせてください。');
            return;
        }
        
        $user = $this->users->findByEmail($this->posted_email);
        $user_id   = $user->id;
        $user_name = $user->name;
        
        Auth::setLoginStatus($user_id, $user_name);
        
        header('Location: /post/list');
        return;
    }
    
    /**
     * ログアウトを行う処理
     *
     * @return void
     */
    public function logoutAction() {
        Auth::clearLoginStatus();
        
        header('Location: /');
        return;
   }
}