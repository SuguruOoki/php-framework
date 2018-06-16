<?php 

require_once(__DIR__ . '/../session/Session.php');

/**
 * 認証情報が正しいかを判定するためのクラス
 */
class Auth
{
    /**
     * 登録されているパスワードかをチェック
     *
     * @param string $db_password    DBからSELECTしたパスワード
     * @param string $input_password ユーザが入力したパスワード
     * @return bool ユーザが入力したパスワードとDBのパスワードが一致したらtrue, そうでなければfalse
     */
    public static function isCorrectPassword(string $input_password, string $db_password) : Bool {
        
        if (password_verify($input_password, $db_password) === false) {
            return false;
        }
        
        return true;
    }
    
    /**
     * ログイン状態を確認する
     *
     * @return bool
     */
    public static function isLogin() {
        $is_session = Session::get(Session::KEY_USER_ID);
        
        if (isset($is_session) === true) {
            return true;
        }
        
        return false;
    }
    
    /**
     * ログイン状態をsetする
     *
     * @param int    $user_id   ユーザID
     * @param string $user_name ユーザ名
     * @return bool sessionのvalueがsetできたらtrue, setする値がなければfalse
     */
    public static function setLoginStatus($user_id, $user_name) {
        
        if (isset($user_id) === false || isset($user_id) === false) {
            return false;
        }
        
        Session::set(Session::KEY_USER_ID, $user_id);
        Session::set(Session::KEY_USER_NAME, $user_name);
        
        return true;
    }
    
    /**
     * ログイン状態をクリアする
     *
     * @return void
     */
    public static function clearLoginStatus() {
        
        $session_name = session_name();
        
        Session::clear();
        
        $past_time = time() - 42000;
        $cookie    = $_COOKIE[$session_name];
        
        if (isset($cookie) === true) {
            setcookie($session_name, '', $past_time, '/');
        }
    } 

}