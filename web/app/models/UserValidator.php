<?php

class UserValidator
{
    
    //   TODO: 全てのvalidationに後ほどSQLインジェクション対策を入れる。そのため、
    
    private $errors = [];
    const USER_NAME_LEN_MIN = 1;
    const USER_NAME_LEN_MAX = 32;
    const PASSWORD_LEN_MIN = 8;
    const PASSWORD_LEN_MAX = 64;
    const SECRET_QUESTION_LEN_MIN = 1;
    const SECRET_QUESTION_LEN_MAX = 3;
    const SECRET_ANSWER_LEN_MIN = 1;
    const SECRET_ANSWER_LEN_MAX = 32;
    const KEY_EMAIL = 'email';
    const KEY_PASSWORD = 'password';
    const KEY_RE_PASSWORD = 're-password';
    const KEY_USERNAME = 'username';
    const KEY_SECRET_QUESTION = 'secret-question';
    const KEY_SECRET_ANSWER = 'secret-answer';
    
    /**
    * 入力された値が規定の文字数の範囲内に収まっているかをvalidation
    *
    * @param int $min_str_length POSTされてきた文字数の下限
    * @param int $max_str_leng POSTされてきた文字数の上限
    * @param string $target_str POSTされてきた対象文字列
    * @return bool
    */
    public function strLenBetween(int $min_str_length, int $max_str_leng, string $target_str) {
        
        if (strlen($target_str) < $min_str_length || strlen($target_str) > $max_str_leng) {
            return false;
        }
        
        return true;
    }
    
    /**
     * すでに登録されているかをチェックする。TODO: 現在はpasswordとemailのみだが、リファクタリング時に他の値にも対応できるよう変更予定。
     *
     * @param  array     $target_columns         登録されているか確認する値の連想配列。キーはDBのカラム名。
     * @return bool
     */
    public function canLogin(array $target_columns) {
        
        require_once('ConnectEnvironment.php');
        $pdo = getPDO();
        $email_key = 'email';
        $password_key = 'password';
        
        $sql = "SELECT email, password FROM `users` WHERE `email` = :email AND `password` = :password LIMIT 1";
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindparam(':email', $target_columns[$email_key]);
        $stmt->bindparam(':password', $target_columns[$password_key]);
        
        $stmt->execute();
        $result = $stmt->fetch();
        
        if ($result === false) {
            return false;
        }
        
        return true;
    }
    
    /**
     * これから登録する値が規定のフォーマットになっているかをチェックする。
     * TODO: 本当にこの形で良いのか、確認が必要
     *
     * @param  array     $target_columns         登録されているか確認する値の連想配列。キーはDBのカラム名。
     * @return bool validationが全て通ったらtrue, 通らなかったらfalseを返す
     */
    public function canSignup(array $target_columns) {
        if (
        $this->isUserNameStrLenBetween($target_columns[self::KEY_USERNAME]) || 
        $this->isCorrectEmailForRfc822($target_columns[self::KEY_EMAIL]) || 
        $this->isCorrectPasswordFormat($target_columns[self::KEY_PASSWORD], $target_columns[self::KEY_RE_PASSWORD]) ||
        $this->isSecretQuestionIdBetween($target_columns[self::KEY_SECRET_QUESTION]) ||
        $this->secretAnswerStrBetween($target_columns[self::KEY_SECRET_ANSWER])) {
            return false;
        }
        
        return true;
    }
    
    /**
    * ユーザ名が規定どおりとなっているかvalidation
    *
    * @param  string     $posted_username POSTされてきたusername
    * @return bool
    */
    public function isUserNameStrLenBetween(string $posted_username) {
        
        if ($this->strLenBetween(self::USER_NAME_LEN_MIN, self::USER_NAME_LEN_MAX, $posted_username) === false) {
            $this->errors[] = 'ユーザ名の文字数が不正です。1文字以上32文字以内で設定してください。';
            return false;
        }
        
        return true;
    }
    
    
    /**
    * メールアドレスがRFC822に従っているかをvalidation
    *
    * @param  string     $posted_email_address POSTされたメールアドレス
    * @return bool
    */
    public function isCorrectEmailForRfc822(string $email) {
        // TODO: ここのエラーメッセージは後ほどユーザにわかりやすいように直す。
        if (filter_var($email, FILTER_VALIDATE_EMAIL, FILTER_FLAG_EMAIL_UNICODE) === false) {
            $this->errors[] = 'メールアドレスが不正です。RFC822に反しています。';
            return false;
        }
        
        return true;
    }
    
    
    /**
    * Passwordが半角大文字小文字英数字記号、指定の文字数範囲内となっているかvalidation
    *
    * @param  string     $posted_password    最初に入力したパスワード
    * @param  string     $posted_re_password 再入力したパスワード
    * @return bool
    */
    public function isCorrectPasswordFormat(string $posted_password, string $posted_re_password) {
        
        $match_pattern = '/\A(?=.*?[a-zA-Z])(?=.*?\d)(?=.*?[!-\/:-@[-`{-~])[!-~]{'.self::PASSWORD_LEN_MIN.','.self::PASSWORD_LEN_MAX.'}+\z/';
        
        if (!preg_match($match_pattern, $posted_password)) { 
            $this->errors[] = 'パスワードの値が不正です。8文字以上64文字以内で半角英数字記号を使って入力してください。'; 
            return false; 
        } 
        
        if ($posted_password !== $posted_re_password) {
            $this->errors[] = 'パスワードが一致していません。';
            return false;
        } 
        
        return true;
    }
    
    /**
    * 秘密の質問についてのvalidation
    *
    * @param  string     $posted_secret_question      POSTされた秘密の質問を格納
    * @return bool
    */
    public function isSecretQuestionIdBetween(string $posted_secret_question) {
        // 登録された値以外のところが入力されていないかをチェックする
        // TODO: DatabaseのLastInsertIdを取ってきて1~その値までのvalidationに後々変更する (frontのoptionもそのようになるように変更する)
        if ($posted_secret_question < self::SECRET_QUESTION_LEN_MIN  || self::SECRET_QUESTION_LEN_MAX < $posted_secret_question) {
            $this->errors[] = '秘密の質問が不正です。HTMLの書換を行わないでください。';
            return false;
        }
        
        return true;
    }
    
    /**
    * 秘密の質問の答えに関するvalidation
    *
    * @param  string     $posted_secret_answer validationするPOSTされてきた秘密の質問への答えを格納
    * @return bool
    */
    public function secretAnswerStrBetween(string $posted_secret_answer) {
        
        if ($this->strLenBetween(self::SECRET_ANSWER_LEN_MIN, self::SECRET_ANSWER_LEN_MAX, $posted_secret_answer) === false) {
            $this->errors[] = '秘密の質問の答えが不正です。1文字以上32文字以下としてください。';
            
            return false;
        }
        
        return true;
    }
    
    /**
     * バリデーションするときに保存したエラーを取得する
     *
     * @return Array
     */
    public function getError() {
        return $this->errors;
    }
}