# README

新卒研修2018

# 環境構築

```
$ git clone https://github.com/SuguruOoki/php-framework.git
$ cd 2018-training
# コンテナの起動
$ docker-compose up -d
# 初期設定スクリプトの起動
# (dbコンテナでmysqlサーバが立ち上がる前に初期設定スクリプトを起動するとエラーになります)
$ sh bin/setup.sh
# ブラウザ
$ open http://localhost:8080
```

# DB設定
Sequel Proで設定すると便利です

## Sequel Proの設定
|設定|値|
|:---|:---|
|名前|[任意]|
|ホスト|127.0.0.1|
|ユーザ名|root|
|パスワード|root|
|ポート|13306|

## コンテナ上で確認
```
$ docker-compose exec db bash
root@4dc67b4f2082:/# mysql -uroot -p
Enter password:
Welcome to the MySQL monitor.  Commands end with ; or \g.
....省略
mysql>use 2018_training
mysql>show tables;
+-------------------+
| Tables_in_2018_training |
+-------------------+
| users             |
+-------------------+
1 row in set (0.00 sec)
```

# 環境設定
以下コマンドで設定ファイルのコピーを作成。
``/path/to/``には適宜作業ディレクトリを指定してください。

```bash
$ cp /path/to/2018-training/config/configSample.json /path/to/2018-training/config/config.json
```

テスト(test)の設定

|設定|値|
|:---|:---|
|host|db|
|db|2018_training_test|
|user_name|root|
|password|root|
|port|3306|

config.json
```
{
  "development":{
    "host" : "db",
    "db" : "2018_training",
    "user_name" : "root",
    "password" : "root",
    "port" : 3306
  },
  "test": {
    "host" : "db",
    "db" : "2018_training_test",
    "user_name" : "root",
    "password" : "root",
    "port" : 3306
  }
}
```

を設定する。

# テストの実行方法

以下コマンドを実行
```bash
$ docker exec {CONTAINER_ID} sh -c "APP_ENV=test /var/www/html/vendor/phpunit/phpunit/phpunit --configuration /var/www/html/tests/phpunit.xml"
```
