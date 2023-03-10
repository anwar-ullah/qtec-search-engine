## Qtec Search Engine
Please follow the instructions below to run the system - 

1. git clone https://github.com/anwar-ullah/qtec-search-engine.git
2. cd ./qtec-search-engine
3. composer install
4. cp .env.example .env
5. edit env variables as required
6. create database and import the db backup file for innitial demo data (path: /datatabse/database.sql)
7. php artisan config:cache
8. php artsan serve

Innitially three roles available. Below is the demo login credentials for each panel. 

## Super Admin
email: super-admin@email.com, password: 12345678

## Admin
email: admin@email.com, password: 12345678

## User
email: user@email.com, password: 12345678





If registered, then user will be assigned role: user automatically.



