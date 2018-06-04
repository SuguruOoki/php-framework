<?php

require_once(dirname(__FILE__, 2).'/models/User.php');
require_once(dirname(__FILE__, 2).'/models/UserValidator.php');
require_once(dirname(__FILE__, 2).'/lib/mytemplate/class/Mytemplate.class.php');

class UserController
{
    private $errors;
    
    public function __construct() {
        $this->errors = [];

        $this->mytemplate = new Mytemplate();
        $this->user = new User();
    }
    
    public function loginAction() {
        
        $is_success = $this->user->getByEmail($_POST['email']);
        if ($is_success === false) {
            $this->errors[] = 'ユーザの検索に失敗しました。';
            $this->mytemplate->displayError($errors);
            return;
        }
        
        $is_valid_password = $this->user->isCorrectPassword($_POST['email'], $is_success['email']);
        
        if ($is_valid_password === false) {
            $this->errors[] = 'パスワードが間違っています。';
            $this->mytemplate->displayError($errors);
            return;
        }
        
        $this->mytemplate->setTemplate('top.tpl');
        $this->mytemplate->display();
    }
    
    public function signUpAction() {
        $validate_columns = [
            'username' => $_POST['username'],
            'password' => $_POST['password'],
            'email' => $_POST['email'],
            're-password' => $_POST['re-password'],
            'secret-question' => $_POST['secret-question'],
            'secret-answer' => $_POST['secret-answer']
        ];
        
        $validator = new UserValidator();
        $is_valid = $validator->canSignup($validate_columns);
        
        if ($is_valid === false) {
            // TODO: 登録ページを再表示したいが、まだ諸々作成していないため、var_dumpでエラー文を出すにとどめる。
            // modalを使っている関係上、ajaxで送信を行い、返却したエラー文を表示されるように後々変更する。
            $this->errors = $validator->getError();
            $this->mytemplate->displayError($this->errors);
            return;
        }
        
        // TODO: パスワードの認証時にはpassword_verifyを使う予定
        // 参考: https://qiita.com/rana_kualu/items/3ef57485be1103362f56
        $hashed_password = password_hash($posted_password, PASSWORD_BCRYPT);
        $is_success = $this->user->insertSingleRecord($validate_columns['username'], $hashed_password, $validate_columns['email']);
        
        if ($is_success === false) {
            $this->errors[] = 'ユーザの登録に失敗しました。';
            $this->mytemplate->displayError($this->errors);
            return;
        }
        
        $this->mytemplate->setTemplate('top.tpl');
        $this->mytemplate->assign('username', $validate_columns['username']);
        $this->mytemplate->display();
    }
}