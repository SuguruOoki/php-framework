<!DOCTYPE html>
<html lang="ja" dir="ltr">
<?php require_once(__DIR__ . '/../header/header.php') ?>
<body>
    <?php require_once(__DIR__ . '/../header/after_login_body_header.tpl') ?>
    <div class="container">
        <div class="row">
            
            <form action="/post/confirm" method="post">
                <div class="form-group">
                    <label for="post_title">記事タイトル</label>
                    <input type="text" id="post_title" class="form-control" name="title" value="" required>
                </div>
                <div class="form-group">
                    <label for="post_content">記事内容</label>
                    <textarea id="post_content" class="form-control" rows="3" name="content" value="" required></textarea>
                </div>
                <button type="submit" value="send" class="btn btn-primary pull-right">確認画面へ</button>
            </form>
        </div>
    </div>
</body>
</html>