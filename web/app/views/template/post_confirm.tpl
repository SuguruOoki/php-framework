<!DOCTYPE html>
<html lang="ja" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>投稿確認画面</title>
    </head>
    <body>
        <form action="/post/register" method="post">
            <div>確認内容をここに表示します。</div>
            <div class="title">
                <?=$title?>
                <input type="hidden" name="title" value="<?=$title?>">
            </div>
            <div class="content">
                <?=$content?>
                <input type="hidden" name="content" value="<?=$content?>">
            </div>
            <input type="hidden" name="dual_trans_token" value="<?=$dual_trans_token?>">
            <button type="submit" value="send">投稿</button>
        </form>
    </body>
</html>