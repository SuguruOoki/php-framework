<?php

/**
 * sessionについて扱うクラス
 */
class Session
{
    private static $session_started = false;
    
    const KEY_USER_ID   = 'user_id';
    const KEY_USER_NAME = 'user_name';
    
    /**
     * sessionがまだstartされていなければ、startする
     *
     * @param  string $key   $_SESSIONを保存するときのキー
     * @param  string $value $_SESSIONに保存する値
     * @return void
     */
    public function start($key, $value) {
        if (self::$session_started === false) {
            session_start();
            $this->set($key, $value);
        }
    }
    
    
    /**
     * セッションに値をset
     *
     * @param  string $key   $_SESSIONを保存するときのキー
     * @param  string $value $_SESSIONに保存する値
     * @return void
     */
    public function set($key, $value) {
        self::$session_started = true;
        $_SESSION[$key] = $value;
    }
    
    
    /**
     * セッションの値を取得
     *
     * @param $key 値を取得する$_SESSIONのkey
     * @return void
     */
    public static function get($key = null) {
        
        if (is_null($key) === true) {
            return $_SESSION;
        }
        
        return $_SESSION[$key];
    }
    
    /**
     * セッションをクリアする
     *
     * @return void
     */
    public static function clear() {
        if (isset($_SESSION)) {
            $_SESSION = [];
            session_destroy();
        }
    }
}