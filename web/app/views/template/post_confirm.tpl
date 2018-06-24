<!DOCTYPE html>
<html lang="ja" dir="ltr">
<?php require_once(__DIR__ . '/../header/header.php') ?>
    <body>
        <?php require_once(__DIR__ . '/../header/after_login_body_header.tpl') ?>
        <form action="/post/register" method="post">
            <div>確認内容をここに表示します。</div>
            <div class="title">
                <?=$title?>
                <input type="hidden" name="title" value="<?=$title?>">
            </div>
            <div class="content">
                <?=nl2br($content)?>
                <input type="hidden" name="content" value="<?=$content?>">
            </div>
            <input type="hidden" name="dual_trans_token" value="<?=$dual_trans_token?>">
            <button type="submit" value="send">投稿</button>
        </form>
    </body>
</html>