<p align="center"><a href="https://junglelifecr.com"><img src="https://junglelifecr.com/wp-content/uploads/2022/04/logo-jungle-life.jpg" width="400" alt="Laravel Logo"></a></p>

## Table of Contents
1. [General Info](#general-info)
2. [Technologies](#technologies)
3. [Installation](#installation)
4. [Collaboration](#collaboration)
5. [License](#license)

## General Info
***
general info

### About Jungle Life Admin App
***
This application solves administrative tasks for the management of a tourism company called Jungle Life, where they will be able to keep track of their customers, and the tours they have done.

### Screenshot
![Home](./public/assets/images/home.png?raw=true)
## Technologies
***
A list of technologies used within the project:
* [PHP](https://www.php.net/): Version 8.0
* [Composer](https://getcomposer.org/): Version 2.5
* [Laravel](https://laravel.com/): Version 9.49
* [Laravel Spanish](https://github.com/Laraveles/spanish.git): Version 1.5
* [Laravel Permission](https://spatie.be/docs/laravel-permission/v5/installation-laravel): Version 5.6
* [Mysql](https://www.mysql.com/): Version 5.7
* [Mailtrap Account](https://mailtrap.io/)

## Installation
***
For Local Installation:

1. Validate the PHP version in your working environment using the following command in the terminal or cmd.
> php -v
2. Validate the Composer version in your working environment using the following command in the terminal or cmd.
> composer -v

3. Ensure that your system has the MySQL service installed.

4. Open your code editor and navigate to the project directory.

5. Open a terminal within your code editor and execute the following commands:

**Clone repository**
> git clone https://example.com
   
> cd jungleLife-admin

6. Next, open your database management tool (e.g., MySQL Workbench) and execute the following commands:

**Create a Database**
> create database jungleLife;

**Select a Database**
> use jungleLife;

7. Return to your code editor and enter the following command in the terminal:
> composer install

8. Copy the file .env.example and rename as `.env` file and configure the following information:

```php
APP_NAME="Jungle Life"
APP_DEBUG=true

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=junglelife
DB_USERNAME="Username of the previously configured database"
DB_PASSWORD="Password of the previously configured database"

QUEUE_CONNECTION=database

MAIL_MAILER="replace with mailtrap account information"
MAIL_HOST="replace with mailtrap account information"
MAIL_PORT="replace with mailtrap account information"
MAIL_USERNAME="replace with mailtrap account information"
MAIL_PASSWORD="replace with mailtrap account information"
MAIL_ENCRYPTION="replace with mailtrap account information"
MAIL_FROM_ADDRESS="Set the Email From"
MAIL_FROM_NAME="${APP_NAME}"

API_TIPO_CAMBIO="https://tipodecambio.paginasweb.cr/api/"
```

9. Generate Application Key, Run the following command in the terminal:
> php artisan key:generate


10. Migrate Database and Seed, Run the following command in the terminal:
> php artisan migrate --seed


11. Start the Development Server, Run the following command in the terminal:
> php artisan serve

12. Test Optional: To Run a schedule Commands, (For test proposes you most validated the file `./app/Console/Kernel.php` to confirm if all $schedule have his everyMinute() version ).

```php
  $schedule->command('command:name')->everyMinute();
```
> php artisan schedule:work   


13. Test Optional: To Run a Jobs and Queue
> php artisan queue:work --tries=3 --delay=2

for production, you shout config a supervisor or worker [Laravel Supervisor](https://laravel.com/docs/9.x/queues#supervisor-configuration)

14. Installation is complete, and you can access the provided link in the console.


## Collaboration
***
Collaboration info

## License
***
The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
