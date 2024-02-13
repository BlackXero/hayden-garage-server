## Hayden Booking System

This is a test project to help you create booking for the customer.

### Steps to setup it on local machine

- Clone the repo `git clone https://github.com/BlackXero/hayden-garage-server.git`
- `cd hayden-garage-server`
- `composer install`
- Once the composer dependencies are done, Please update `.env` file variables
- Then to generate the project key run `php artisan key:generate`
- For migration run `php artisan migrate` this will create all the required tables.
- For DB seeding run the cmd `php artisan db:seed` this will insert the initial data for us like admin login details and vehicle make and model
- `php artisan server` to run the project


#### Admin Login Details

- Username: `paul@admin.com`
- Password: `123456`
