<!DOCTYPE html>
<html lang="ja">
<?php require_once(__DIR__ . '/../header/header.php'); ?>
<body>
    <?php require_once(__DIR__ . '/../header/after_login_body_header.tpl'); ?>
    <h1 class="alert alert-success" role="alert">ログイン成功</h1>
    <div class="container">
        <div class="row">
            <h1>ようこそ <?=$user_name?>さん！</h1>
        </div>
        <div class="row">
            <table class="table table-striped">
                <tbody>
                    <?php foreach($posts as $post) {?> 
                        <tr class="table-row">
                            <td class="table-column">
                                <a href="/post/detail/<?=$post['id']?>">
                                    <?=$post['title']?>
                                </a>
                            </td>
                            <td class="table-column">
                                <div>
                                    <a href="/post/detail/<?=$post['user_id']?>"><?=$post['user_name']?></a>
                                </div>
                            </td>
                            <td class="table-column">
                                <span><?=$post['created_at']?></span>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>