<div class="row">
    <h3>コメント</h3>
    <div class="comments">
        <?php foreach($comments as $comment) {?> 
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <td>
                            <span><?=nl2br($comment['content'])?></span>
                        </td>
                        <td>
                            <span><?=$comment['user_name']?></span>
                        </td>
                        <td>
                            <span><?=$comment['created_at']?></span>
                        </td>
                    </tr>
                </tbody>
            </table>
        <?php } ?>
    </div>
</div>
<div class="comment_form">
    <form class="" action="/comment/create" method="post">
        <div class="form-group">
            <label for="comment"></label>
            <textarea type="text" id="comment" class="form-control" rows="3" name="content" value=""></textarea>
        </div>
        <input type="hidden" name="dual_trans_token" value="<?=$dual_trans_token?>">
        <button type="submit" class="btn btn-primary pull-right">コメントを投稿</button>
    </form>
</div>
