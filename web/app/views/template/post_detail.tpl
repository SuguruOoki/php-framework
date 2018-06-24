<!DOCTYPE html>
<html lang="ja">
<?php require_once(__DIR__ . '/../header/header.php'); ?>
<!-- 仮実装とし、リファクタリングの時にフロントは全体的に整える -->
<body>
    <?php require_once(__DIR__ . '/../header/after_login_body_header.tpl'); ?>
    <div class="container">
        <div class="row">
            <h1><?=$post['title']?></h1>
        </div>
        <div class="row">
            <div class="content">
                <h4><?=nl2br($post['content'])?></h4>
            </div>
        </div>
        <div class="row">
            <div class="post_info">
                <div class="">
                    <h4><?=$post['user_name']?></h4>
                </div>
                <div class="">
                    <h4><?=$post['created_at']?></h4>
                </div>
            </div>
        </div>
        <?php require_once(__DIR__ . '/comments.tpl'); ?>
    </div>
</body>
</html>