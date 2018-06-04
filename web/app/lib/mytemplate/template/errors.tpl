<!DOCTYPE html>
<html lang="ja" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>エラー</title>
    </head>
    <body>
        <div>
            <ul>
                <?php foreach($errors as $error){echo "<li>$error</li>";} ?>
            </ul>
        </div>
    </body>
</html>