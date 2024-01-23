# PookieBoard

A simple and modular CMS system, built with Laravel Lumen as a base.

## Features

- Laravel Lumen
- Simple Module/Plugin System (based on DI)
- Basic dashboard featuring Bootstrap 5.3.2
- Laravel's Development Server (`php artisan serve`)

## Module/Plugin system

It allows the selective loading of modules from the 'modules' folder situated in the project folder.

## Installation

Run the following commands:
```
composer install
cp .env.example .env
```
If you want to use sqlite, run `touch database/database.sqlite` to create an empty file in `database/database.sqlite`, then modify the `.env` file, making sure that these two parameters are set accordingly:
```dotenv
DB_CONNECTION=sqlite
DB_DATABASE=/pookieboard/installation/directory/database/database.sqlite
```
Configure the database structure by running
`php artisan migrate:fresh` and install the assets of the CMS by running `php artisan module:assets PookieBoardCMS`

Congrats! Now you should have a fresh base installatiion of PookieBoard! To enhance the functionality of the app, you should install some modules! (or develop some :])

## License

The Lumen framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
