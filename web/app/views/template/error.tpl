<!DOCTYPE html>
<html lang="ja" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>エラー</title>
    </head>
    <body>
        <h1 class="errors">エラーが発生しました。</h1>
        <!-- のちにajaxを使うようになった場合にはこのファイルを削除する予定 -->
        <div>
            <ul><?php for($i=0; $i<count($errors); $i++){ ?>
                    <li><?php echo $errors[$i]; ?></li>
                <?php } ?>
            </ul>    
        </div>
        <div>
            <a href="/post/list">Topに戻る</a>
        </div>
    </body>
</html>

