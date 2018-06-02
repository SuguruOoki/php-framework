#!/bin/sh
# ライブラリのインストール
docker-compose exec web composer install
# マイグレーション
docker-compose exec db sh migrate.sh
