<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>
<hr/>

## Installation

Using Docker, we need to run following commands:

```bash
php artisan sail:install
```

This command will publish Sail's docker-compose.yml file to the root of your application and modify your .env file with the required environment variables in order to connect to the Docker services.

After running <i>sail:install</i>, we can start the app using:

```bash
./vendor/bin/sail up
```
