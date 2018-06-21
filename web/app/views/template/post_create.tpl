<!DOCTYPE html>
<html lang="ja" dir="ltr">
<?php require_once(__DIR__ . '/../header/header.php') ?>
    <body>
        <?php require_once(__DIR__ . '/../header/after_login_body_header.tpl') ?>
        <form action="/post/confirm" method="post">
            <div>
                <label for="post_title">記事タイトル</label>
                <input type="text" id="post_title" name="title" value="">
            </div>
            <div>
                <label for="post_content">記事内容</label>
                <input type="textarea" id="post_content" name="content" value="">
            </div>
            <button type="submit" value="send">確認画面へ</button>
        </form>
    </body>
</html>