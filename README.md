# Pharmacy Checkout

Computer engineering course project made with Laravel and Vue for a pharmacy website where medication can be bought. 
Also available are different profiles for different navigation features.

Directories _vendor_ and _node_modules_ not included. Commands '_composer update_' and '_npm install_' are required for proper execution. 
Also necessary is the importing of the database and '.env' file configuration.

To import the database and perform a storage link, run the following commands on Laravel command line:<br/>
_php artisan migrate:fresh_<br/>
_composer dump-autoload_<br/>
_php artisan db:seed_<br/>
_php artisan storage:link_

All users have '123' as their password.

To run the Vue project use: _npm run watch_

Example of client checkout page:
![image](https://user-images.githubusercontent.com/25649121/141104808-8607a754-a0fe-4b28-8156-87f8f7d7a8ab.png)
