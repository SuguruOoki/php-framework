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
            <div class="Post_List center-block">
                <?php foreach($posts as $post) {?> 
                    <div class="card">
                        <div class="card-body">
                            <div class="Post_Item card-title text-center">
                                <a href="/post/detail/<?=$post['id']?>">
                                    <?=$post['title']?>
                                </a>
                                <div class="card-footer text-muted">
                                    <div>
                                        <span><?=$post['user_name']?></span>
                                    </div>
                                    <div>
                                        <span><?=$post['created_at']?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</body>
</html>