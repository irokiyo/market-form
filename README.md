# market-form

## 環境構築

### Docker ビルド
1. git clone git@github.com:Estra-Coachtech/laravel-docker-template.git  
1. mv laravel-docker-template market-form  
1. git remote set-url origin git@github.com:irokiyo/market-form.git  
1. git remote -v  
1. git add .  
1. git commit -m "リモートリポジトリの変更"  
1. git push origin main  
1. docker-compose up -d --build  

### Laravel 環境構築

1. docker-compose exec php bash  
1. composer install  
1. cp .env.example .env  
1. .env ファイルの一部を以下のように編集
```
    DB_CONNECTION=mysql  
    DB_HOST=mysql  
    DB_PORT=3306  
    DB_DATABASE=laravel_db  
    DB_USERNAME=laravel_user 
    DB_PASSWORD=laravel_pass 
```
5. php artisan key:generate  
1. php artisan migrate  
1. php artisan db:seed  

## user のログイン用初期データ

## 使用技術
- MySQL 8.0.26  
- Laravel: 8.83.3  
- PHP 8.1 (Docker)  

## URL
- 環境開発: http://localhost/login  
- phpMyAdmin: http://localhost:8080/  

## ER 図
![ER図]