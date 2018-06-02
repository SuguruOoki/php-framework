<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">ログインフォーム</h3>
            </div>
            <div class="modal-body">
                <form action="app/models/auth.php" method="POST">
                    <div class="form-group">
                        <label for="login-email">email</label>
                        <input type="text" class="form-control" id="login-email" name="email" aria-describedby="emailHelp" placeholder="メールアドレスを入力してください">
                        <small id="emailHelp" class="form-text text-muted">ユーザ登録時に入力した個別の内容です。</small>
                    </div>
                    <div class="form-group">
                        <label for="login-password">パスワード</label>
                        <input type="password" class="form-control" id="login-password" name="password" placeholder="パスワードを入力してください">
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg btn-block">ログイン</button>
                </form>
            </div>
        </div>
    </div>
</div>
