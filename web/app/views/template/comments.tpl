<div class="row">
    <h2>コメント</h2>
    <div class="comments">
        <?php foreach($comments as $comment) {?> 
            <div class="card">
                <div class="card-body">
                    <div class="Comment_Item card-title">
                        <div class="card-footer text-muted">
                            <div>
                                <span><?=nl2br($comment['content'])?></span>
                            </div>
                            <div>
                                <span><?=$comment['user_name']?></span>
                            </div>
                            <div>
                                <span><?=$comment['created_at']?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<div class="comment_form">
    <form class="" action="/comment/create" method="post">
        <div class="form-group">
            <label for="comment"></label>
            <textarea type="text" id="comment"  class="form-control" rows="3" name="content" value=""></textarea>
        </div>
        <input type="hidden" name="dual_trans_token" value="<?=$dual_trans_token?>">
        <button type="submit" class="btn btn-primary pull-right">コメントを投稿</button>
    </form>
</div>
