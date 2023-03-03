
# Stack

    1. Language: PHP 8.1.16
    2. Backend Framework: Laravel 10
    3. Database: MySQL 8
    4. API Documentation: Swagger

# Task Directive:
Build a laravel web application with clock-in API endpoints. Add sample data in the MySQL
database to showcase your work.

# download project 
    1- git clone https://github.com/amrfoley/bw-task.git
    2- cd bw-task
    3- cp .env.example .env

# install with docker
    1- make sure to stop any local RDB listening to port 3306
    2- run "docker-compose up -d"
    3- run "docker exec -it bluworks-app composer install"
    4- run "docker exec -it bluworks-app php artisan key:generate"
    5- run "docker exec -it bluworks-app php artisan migrate --seed"
    6- run "docker exec -it bluworks-app php artisan test"
    7- open "localhost:8000/api/documentation" on browser

# install without docker
    1- change DB_HOST in .env to localhost
    2- run "composer install"
    3- run "php artisan key:generate"
    4- run "php artisan migrate --seed"
    5- run "php artisan test"
    6- open "localhost:8000/api/documentation" on browser
