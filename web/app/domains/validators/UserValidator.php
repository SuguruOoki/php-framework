<?php

/**
 * Userについてのバリデーションを行うクラス。
 * TODO: PostValidatorと同様キモいので後々役割をしっかりと分けるようにする。
 */
class UserValidator
{
    
    //   TODO: 全てのvalidationに後ほどSQLインジェクション対策を入れる。
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
    
    /**
    * 入力された値が規定の文字数の範囲内に収まっているかをvalidation
    *
    * @param int $min_str_length 文字数の下限
    * @param int $max_str_length 文字数の上限
    * @param string $target_str 対象文字列
    * @return bool
    */
    public function strLenBetween(int $min_str_length, int $max_str_length, string $target_str) {
        
        if (strlen($target_str) < $min_str_length || strlen($target_str) > $max_str_length) {
            return false;
        }
        
        return true;
    }
    
    
    /**
    * ユーザ名が規定どおりとなっているかvalidation
    *
    * @param  string     $posted_username validationするusername
    * @return bool
    */
    public function userNameStrBetween(string $posted_username) {
        
        if ($this->strLenBetween(self::USER_NAME_LEN_MIN, self::USER_NAME_LEN_MAX, $posted_username) === false) {
            $this->errors[] = 'ユーザ名の文字数が不正です。1文字以上32文字以内で設定してください。';
            return false;
        }
        
        return true;
    }
    
    
    /**
    * メールアドレスがRFC822に従っているかをvalidation
    *
    * @param  string     $posted_email_address メールアドレス
    * @return bool
    */
    public function isEmail(string $posted_email_address) {
        // TODO: ここのエラーメッセージは後ほどユーザにわかりやすいように直す。
        if (filter_var($posted_email_address, FILTER_VALIDATE_EMAIL, FILTER_FLAG_EMAIL_UNICODE) === false) {
            $this->errors[] = 'メールアドレスが不正です。';
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
     * 空かどうかを判定
     *
     * @param string $email メールアドレス
     * @return bool 空であれば、true, そうでなければfalse
     */
    public function isEmpty($content) {
        return $content === "" ? true : false;
    }
    
    
    /**
    * 秘密の質問のIDが規定値範囲以外が入力されていないかを確認するvalidation
    *
    * @param  int     $posted_secret_question 秘密の質問のIDを格納
    * @return bool
    */
    public function secretQuestionIdBetween(int $posted_secret_question) {
        // 登録された値以外のところが入力されていないかをチェックする
        // TODO: DatabaseのLastInsertIdを取ってきて1~その値までのvalidationに後々変更する (frontのoptionもそのようになるように変更する)
        if ($posted_secret_question < self::SECRET_QUESTION_LEN_MIN && self::SECRET_QUESTION_LEN_MAX < $posted_secret_question) {
            $this->errors[] = '秘密の質問が用意されているものではありません。HTMLを編集しないでください。';
            return false;
        }
        
        return true;
    }
    
    /**
    * 秘密の質問の答えに関するvalidation
    *
    * @param  string     $posted_secret_answer validationする秘密の質問への答えを格納
    * @return bool
    */
    public function secretAnswerStrLenBetween(string $posted_secret_answer) {
        
        if ($this->strLenBetween(self::SECRET_ANSWER_LEN_MIN, self::SECRET_ANSWER_LEN_MAX, $posted_secret_answer) === false) {
            $this->errors[] = '秘密の質問の答えが不正です。1文字以上32文字以下としてください。';
            
            return false;
        }
        
        return true;
    }
    
    /**
     * バリデーションするときに保存したエラーを取得する
     *
     * @return array
     */
    public function getError() {
        return $this->errors;
    }
}