<div class="main-agile">
    <div class="header">
        <!-- navigation section -->
        <div class="w3_navigation">
            <div class="container">
                <nav class="navbar navbar-default">
                    <div class="navbar-header navbar-left">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <div class="logo">
                            <h1><a class="navbar-brand" href="/post/list">[社内ツール]</a></h1>
                        </div>
                    </div>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse navbar-right" id="bs-example-navbar-collapse-1">
                        <nav class="menu menu--miranda">
                            <ul class="nav navbar-nav menu__list">
                                <li class="menu__item menu__item--current">
                                    <input type="text" name="keyword" placeholder="記事のタイトル" id="search">
                                    
                                </li>
                                <li class="menu__item menu__item--current"><a href="/post/list" class="menu__link">Home</a></li>
                                <li class="menu__item"><a href="/post/create" class="menu__link">新規投稿</a></li>
                                <li class="menu__item"><a href="/user/logout" class="menu__link">Logout</a></li>
                            </ul>
                            <ul id="test"></ul>
                        </nav>
                    </div>
                </nav>	
                <div class="clearfix"></div>
            </div>	
        </div>
        <!-- /navigation section -->
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
$(function () {
    var keyupStack = [];
    $('#search').on('keyup', function () {

        keyupStack.push(1); //配列の後ろに追加

        // 指定時間後に処理を実行させる
        setTimeout(function () {

            keyupStack.pop(); //配列の中身排出

            // 最後にkeyupされてから次の入力がなかった場合
            if (keyupStack.length === 0) {

                $.ajax({
                    type: "GET",
                    url: "/post/search/"+$('#search').val(),
                }).done(function(data) {
                    // 取得したデータを処理する（ここではjsonを受け取る想定）
                    // alert(data);
                    var test_len = data.length;
                    alert(test_len);
                    // alert(data["title"]);
                    for(var i = 0; i < test_len; i++){
                        // alert(data[i]["title"]);
                        $("#test").append("<li>" + data[i]["title"] + "</li>");
                    }

                }).fail(function(data) {
                    alert('failed!');
                });

            }
        }.bind(this), 500); // 0.5秒設定

    });

});
</script>