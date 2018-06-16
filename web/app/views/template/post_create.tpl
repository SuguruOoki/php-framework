<!DOCTYPE html>
<html lang="ja" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>新規投稿画面</title>
    </head>
    <body>
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