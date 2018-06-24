<!DOCTYPE html>
<html lang="ja" dir="ltr">
<?php require_once(__DIR__ . '/../header/header.php') ?>
<body>
    <?php require_once(__DIR__ . '/../header/after_login_body_header.tpl') ?>
    <div class="container">
        <h1>投稿内容の確認</h1>
        <form action="/post/register" method="post">
            <div class="title form-group">
                <h2><?=$title?></h2>
                <input type="hidden" name="title" value="<?=$title?>">
            </div>
            <div class="content form-group">
                <h3>
                    <?=nl2br($content)?>
                </h3>
                <input type="hidden" name="content" value="<?=$content?>">
            </div>
            <input type="hidden" name="dual_trans_token" value="<?=$dual_trans_token?>">
            <button type="submit" class="btn-lg btn-primary pull-right" value="">投稿</button>
        </form>
    </div>
</body>
</html>