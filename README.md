Laravel version 8.75
php min 7.3| ^8.0

open directory project type in cmd : 
composer install
composer require tymon/jwt-auth
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
php artisan jwt:secret
create database (postgresql) with name `proyekgallery`
import database in folder service 
for run the service, open inside folder serivce, there are 4 service : 
- GalleryService (laravel + postgresql)
- ServiceOrder (golang + mysql)
- ServiceProduk	(golang + mysql)
- ServiceUser (golang + mysql)

testing the endpoint and documentation from postman can be look at folder service in file `endpoint API POSTMAN`

for service golang run by inside in directory each folder and type in cmd "go run main.go"
port that expected is
- GalleryService (8004)
- ServiceOrder (8003)
- ServiceProduk	(8001)
- ServiceUser (8002)

after all service runing, the client side can be running 
