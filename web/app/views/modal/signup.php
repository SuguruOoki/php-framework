<div class="modal fade" id="signUpModal" tabindex="-1" role="dialog" aria-labelledby="signUpModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="signUpModalLabel">サインアップフォーム</h3>
            </div>
            <div class="modal-body">
                <form action="user/signup" method="POST">
                    <div class="form-group">
                        <label for="user_name">ユーザ名</label>
                        <input type="text" class="form-control" id="user_name" name="user_name" aria-describedby="usernameHelp" placeholder="ユーザ名">
                        <small id="usernameHelp" class="form-text text-muted">ログイン後に表示されるユーザ名になります。</small>
                    </div>
                    <div class="form-group">
                        <label for="email">メールアドレス</label>
                        <input type="text" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="メールアドレス">
                        <small id="emailHelp" class="form-text text-muted">会社から支給されているメールアドレスを入力してください。</small>
                    </div>
                    <div class="form-group">
                        <label for="password">パスワード</label>
                        <input type="password" class="form-control" id="password" name="password" aria-describedby="passwordHelp" placeholder="パスワード">
                        <small id="passwordHelp" class="form-text text-muted">半角英数字記号を全て利用して入力してください。</small>
                    </div>
                    <div class="form-group">
                        <label for="password">パスワード(再入力)</label>
                        <input type="password" class="form-control" id="re-password" name="re-password" placeholder="再度パスワードを入力してください">
                    </div>
                    <div class="form-group">
                        <label for="secret-question">秘密の質問</label>
                        <select name="secret-question">
                            <option value="1">小さい頃に飼っていたペットの名前</option>
                            <option value="2">印象に残っている先生の名前</option>
                            <option value="3">自分史上最高の映画</option>
                        </select>
                        <input type="text" class="form-control" id="secret-answer" name="secret-answer"  aria-describedby="secretAnswerHelp" placeholder="秘密の質問の答えを入力してください">
                        <small id="secretAnswerHelp" class="form-text text-muted">パスワードを忘れた際に必要になりますので、忘れないように手元で保存してください。</small>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg btn-block">Sign UP!</button>
                </form>
            </div>
        </div>
    </div>
</div>
