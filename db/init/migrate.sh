#!/bin/bash
# migration配下のsqlファイルを全て文字列として読み込む
SQL=$( find migrations/* | sort | xargs cat )

# 開発DB、テストDBの作成
mysql -uroot -proot -e "\
    CREATE DATABASE IF NOT EXISTS 2018_training CHARACTER SET utf8;
    CREATE DATABASE IF NOT EXISTS 2018_training_test CHARACTER SET utf8;
    "
mysql -uroot -proot -e "\
    USE 2018_training;
    $SQL
    SHOW TABLES;
    USE 2018_training_test;
    $SQL
    SHOW TABLES;
"
echo "migration complete!!"
