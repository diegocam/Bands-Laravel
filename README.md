# Bands and Albums

This application keeps track of favorite bands and albums.

## Getting Started
These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. 

### Prerequisites

- [PHP >= 5.6.4](http://php.net/)
- [Composer](https://getcomposer.org/)
- [MySQL](https://dev.mysql.com/doc/refman/5.7/en/windows-installation.html)

### Install

1. Clone this repo into your desired directory:

    ````
    git -C <your path> clone https://github.com/diegocam/Bands.git
    ````

2. Go into your application:
   
   ````    
   cd <your path>
   ````

3. Create the `.env` file by copying from the example provided (`.env.example`)

   ```
   cp .env.example .env
    
   ```

4. Modify the `.env` file with your desired local environment configuration options
5. Create your Encryption Key:

    ```
    php artisan key:generate
    ```
6. Create your database tables (this will run the migrations located in `/Bands/database/migrations/`):
    ```
    php artisan migrate
    ```
7. Populate your database tables (this will populate your tables with fake data coming form `/Bands/database/seeds`):
    ````
    php artisan db:seed
    ````
8. Run composer:
    ````
    composer install
    ````
9. Run your server:
   ````
   php artisan serve
   ````
10. You should get the below message. If so, open up your browser and go to `http://127.0.0.1:8000`. Enjoy.
    ````
    Laravel development server started: <http://127.0.0.1:8000>
    ````
    

## Built With

- [PHP >= 5.6.4](http://php.net/)
- [Laravel 5.4](https://laravel.com/)
- [jQuery DataTables](https://datatables.net/)
- [Laravel DataTables](https://datatables.yajrabox.com/)
- [jQuery](https://jquery.com/)
- [Composer](https://getcomposer.org/)
- [MySQL](https://dev.mysql.com/doc/refman/5.7/en/windows-installation.html)



## Author

**Diego Camacho** - [Github page](https://github.com/diegocam)
