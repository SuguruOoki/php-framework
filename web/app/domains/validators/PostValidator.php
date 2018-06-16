<?php 

/**
 * 記事投稿についてのvalidationを行うクラス。
 * TODO: Modelごとに書いているのが結構キモいので後々もう少し、役割をきっちり分ける。
 * また、$_POSTのバリデーションも入ってしまっているため、近々切り分ける。
 */
class PostValidator
{
    const ALLOW_KEYS  = ['title', 'content', 'dual_trans_token'];
    const KEY_TOKEN   = 'dual_trans_token';

    // TODO: 以降のメソッドはここにおくべきではないが、もっと別のところで使うようになった時にClassとして分離させる
    /**
    * $_POSTにsetされているべきkeyだけがセットされているか
    *
    * @return bool $_POSTにsetされているべきkeyがセットされている場合true, そうでない場合false
    */
    public function isCorrectKeys() : Bool {
        
        $post_keys = array_keys($_POST);
        $result = array_diff($post_keys, self::ALLOW_KEYS);
        
        return $result === [] ? true : false ;
    }
    
    /**
    * $_POSTの特定のkeyの中身にvalueがセットされているか
    *
    * @return bool $_POSTの指定したkeyのvalueがセットされている場合true, そうでない場合false
    */
    public function isSetPostValues() : Bool {
        
        foreach ($_POST as $key => $value) {
            if (isset($value) === false) {
                return false;
            }
        }
        
        return true;
    }
    
    /**
     * $valueで指定された値が空文字でないかを調べる
     * TODO: このメソッドに限らず、汎用的に使えるメソッドが存在するため、統合できそうなところはValidatorも
     * リファクタで統合する
     *
     * @param string $value 
     * @return bool 空文字の場合true, そうでないfalse
     */
    public function isEmptyStr($value) : Bool {
        
        if ($value === '') {
            return true;
        }
        
        return false;
    }
    
    /**
    * $_POSTが空配列かどうかを判定
    * (URL直打ち対策)
    *
    * @return bool $_POSTが空配列である場合はfalse 値を持つ配列場合はtrue
    */
    public function isEmptyPost() : Bool {
        return $_POST === [] ? false : true;
    }
    
    /**
    * POSTに正しいkeyがセットされていてその値がnullであるかを判定
    *
    * @param array $keys POSTに入っているべきkeyの配列
    * @return bool $_POSTに正しいkeyが入っていてそのvalueがnullでない場合true, そうでない場合はfalse
    */
    public function isCorrectPost() : Bool {
        return $this->isEmptyPost() && $this->isCorrectKeys() && $this->isSetPostValues();
    }
    
    /**
    * 二重送信によって登録が二回起こらないようにする確認をtokenで行う
    * ブラウザの戻るボタンで戻った場合は、セッション変数が存在しないため、
    * 2重送信とみなすことができる。また、不正なアクセスの場合もワンタイムチケットが
    * 同じになる確率は低いため、不正アクセス防止にもなる。
    *
    * @return bool $_POSTにあるtokenと$_SESSIONにあるtokenが一致した場合true, そうでない場合にはfalse
    */
    public function isCorrectToken() : Bool {
        $post_token    = isset($_POST[self::KEY_TOKEN]) ? $_POST[self::KEY_TOKEN] : '';
        $session_token = isset($_SESSION[self::KEY_TOKEN]) ? $_SESSION[self::KEY_TOKEN] : '';
        
        if ($post_token === '' || $session_token === '') {
            return false;
        }
        
        return $post_token === $session_token;
    }
}