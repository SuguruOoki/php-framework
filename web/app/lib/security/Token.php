<?php

class Token
{
    const KEY_TOKEN   = 'dual_trans_token';
    private $one_time_ticket;
    
    public function __construct() {
        $this->one_time_ticket = '';
    }
    
    /**
    * set済みの二重送信防止用のtokenを取得する
    *
    * @return string set済みの二重送信防止token
    */
    public function get() : String {
        return $this->one_time_ticket;
    }
    
    /**
    * 二重送信防止用のtokenを作成し、$_SESSIONにset
    *
    * @return void 
    */
    public function set() {
        $this->one_time_ticket = md5(uniqid(rand(), true));
        $_SESSION[self::KEY_TOKEN] = $this->one_time_ticket;
    }
    
    /**
    * 作成したTokenを削除する
    *
    * @return void
    */
    public function free() {
        unset($_SESSION[self::KEY_TOKEN]);
    }
}