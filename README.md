# Test Task Sahak
Please run following commands
1) composer install
2) cp .env.example .env and set db connection data
3) php artisan key:generate
4) php artisan migrate
5) You have to run 
php artisan key:generate php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider" php artisan jwt:secret.

# API endpoints
1. api/auth/register. The users can be registered. 
