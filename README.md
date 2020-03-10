## MiniAspire project with Lumen 5.2 Framework
Documentation for the framework can be found on the [Lumen website](http://lumen.laravel.com/docs).
## Purpose
* Set up the database with Doctrine.
* Run a command which accepts the feed urls(separated by comma) to grab items and save items data into DB.
* Show list of items which were grabbed by running the command line.
* Filter items by category name on the list of items.
## Contents
- [Installation](#installation)
- [Usage](#usage)
    - [User](#user)
        - [Create a User](#create-a-user)
        - [Get List User](#get-list-user)
        - [Get All User](#get-all-user)
    - [loan](#loan)
        - [Create a loan](#create-a-loan)
        - [Get list loan](#get-list-loan)
        - [Get list Loan By User](#get-list-loan-by-user)
        - [Get list loan payment by loan](#get-list-loan-payment-by-loan)
## Installation
1. Requirement:
    - PHP >= 7.0.1
    - Mysql >= 5.6
    - Postman >= 7.1
2. Setup:
   - Git clone: git@github.com:kieugol/mini-aspire-lumen5.git
   - Run composer: composer install
   - Change db configuration at .env file
        ```
        DB_HOST=localhost
        DB_PORT=3306
        DB_DATABASE=test
        DB_USERNAME=root
        DB_PASSWORD=root
        ```
   - Run migration: php artisan migrate --force
   

Test api domain: https://krol.diqit.io/api/v1 
    
## Usage
### User
#### Create a User
  - using post method: https://krol.diqit.io/api/v1/user
  - Sample params: 
    ```json
      {
          "name": "Rol Kieu",
          "email": "krol@diqit.io",
          "birthday": "1990-09-22",
          "phone": "09174747775",
          "address": "HCM City"
      }
    ```
#### Get List User
  - using get method: https://krol.diqit.io/api/v1/user?page=1&limit=10
  - Sample params: 
       - page: 1,2,3
       - limit: 10,20,30..500
#### Get All User
 - using get method: https://krol.diqit.io/api/v1/user/all
 - Sample params: 
       
### loan
#### Create a Loan
  - using post method: https://krol.diqit.io/api/v1/loan
  - Sample params: 
    ```json
        {
          "user": 1,
          "repayment_frequency": 2,
          "loan_term": 2,
          "interest_rate": 6,
          "amount": 10000
        }
    ```
    -  user: go to api [Get all user](#get-all-user)
    -  repayment_frequency: go to api [Get all repayment frequency](#get-all-user)
#### Get list loan
  - using get method: https://krol.diqit.io/api/v1/loan?page=1&limit=10
  - Sample params: 
       - page: 1,2,3
       - limit: 10,20,30..500
       
#### Get list Loan By User
 - using get method: https://krol.diqit.io/api/v1/loan/by-user/{user_id}
 - Sample params: 
      - user_id: 1,2,3
      - limit: 10,20,30..500
