# Importing XLS file into DB

### Set-up
0. `git pull`
1. `make build`
2. `make up`
3. `make shell`
4. `composer install`
5. `composer update`
6. `php artisan migrate`
7. `php artisan queue:work --queue=high`
8. And final command `php artisan import:employee employee.xlsx`