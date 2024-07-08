# Rese(飲食店予約サービス)


## 作成した目的

## URL
 - 開発環境: 'http://localhost/'
 - phpMyAdmin: 'http://localhost:8080/'
 - mailhog: 'http://localhost:8025/'
 - 本番環境: 

## 機能一覧
 - 会員登録
 - ログイン
 - 店舗一覧表示
 - 店舗詳細表示
 - 飲食店予約
 - 会員マイページ表示
 - 管理者による

## 使用技術(実行環境)
- PHP 
- Laravel
- MySQL 8.0.35

## テーブル設計

## ER図

## 環境構築
**Dockerビルド**
1. `git clone git@github.com:tyswtpooh55/Rese.git`
2. DockerDesktopアプリを立ち上げる
3. `docker-compose up -d --build`

**Laravel環境構築**
1. `docker-compose exec php bash`
2. `composer install`
3. [.env.example]ファイルを[.env]ファイルに命名変更
4. .env に以下の環境変数を追加
    ```
    APP_NAME=Rese

    DB_CONNECTION=mysql
    DB_HOST=mysql
    DB_PORT=3306
    DB_DATABASE=laravel_db
    DB_USERNAME=laravel_user
    DB_PASSWORD=laravel_pass
    ```
5. アプリケーションキーの作成
    `php artisan key:generate`
6. マイグレーションの実行
    `php artisan migrate`
7. シーディングの実行
    `php artisan db:seed`

## 本番環境
