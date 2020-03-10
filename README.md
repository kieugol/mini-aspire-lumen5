## MiniAspire project with Lumen 5.2 Framework
Documentation for the framework can be found on the [Lumen website](http://lumen.laravel.com/docs).
## Purpose
* Build a simple API that allows to handle user loans: users, loans, and repayments
     - The loan term calculates as default is year.
     - The payment will pay for loan by period is 12 months(1 year).
     - The interest rate can be dynamic: year, month, quarter.
     - The user can create many loans and make repayments by each period.
## Contents
- [Installation](#installation)
- [Usage](#usage)
    - [User](#user)
        - [Create a User](#create-a-user)
        - [Get List User](#get-list-user)
    - [loan](#loan)
        - [Create a loan](#create-a-loan)
        - [Get list loan](#get-list-loan)
        - [Get list Loan By User](#get-list-loan-by-user)
        - [Add payment for loan](#add-payment-for-loan)
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
   - Setup apache, nginx to use local to run source code can refer here: [Lumen Installation](https://lumen.laravel.com/docs/5.2/installation)

- Test api domain: https://krol.diqit.io/api/v1
- Test collection sample on Postman [mini-aspire-project-api.postman_collection.json](https://github.com/kieugol/mini-aspire-lumen5/blob/master/mini-aspire-project-api.postman_collection.json)
    
## Usage
### User
#### Create a User
  - Using post method: https://krol.diqit.io/api/v1/user
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
    - Sample output: 
        ```json
        {
            "code": 200,
            "message": "Created successfully.",
            "data": {
                "name": "Rol Kieu",
                "email": "krol@diqit.io",
                "birthday": "1990-09-22",
                "phone": "09174747775",
                "address": "HCM City",
                "updated_at": "2020-03-10 03:37:13",
                "created_at": "2020-03-10 03:37:13",
                "id": 2
            }
        }
        ```
#### Get List User
  - Using get method: https://krol.diqit.io/api/v1/user?page=1&limit=10
  - Sample params: 
       - page: 1,2,3
       - limit: 10,20,30..500
       
### loan
#### Create a Loan
  - Using post method: https://krol.diqit.io/api/v1/loan
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
        -  user: go to api [Get list user](#get-list-user)
        -  repayment_frequency: go to api [Get all repayment frequency](#get-all-user)
- Sample output: 
    ```json
        {
            "code": 200,
            "message": "Created successfully.",
            "data": {
                "id": 1
            }
        }
    ```
#### Get list loan
  - Using get method: https://krol.diqit.io/api/v1/loan?page=1&limit=10
  - Sample params: 
       - page: 1,2,3
       - limit: 10,20,30..500
  - Sample output: 
   ```json
    {
        "code": 200,
        "message": "",
        "data": {
            "page": 1,
            "length": 10,
            "total_record": 1,
            "total_page": 1,
            "rows": [
                {
                    "id": 1,
                    "user_id": 1,
                    "term": 2,
                    "start_date": "2020-03-09",
                    "end_date": "2022-03-09",
                    "repayment_frequency": "Quarter",
                    "Loan_status": "Paying",
                    "interest_rate": 6,
                    "amount": 10000,
                    "payment_amount": 12500,
                    "interest_amount": 2500,
                    "remarks": "",
                    "created_at": "2020-03-09 16:13:17",
                    "updated_at": "2020-03-09 16:14:36"
                }
            ]
        }
    }
   ```
#### Get list Loan By User
 - Using get method: https://krol.diqit.io/api/v1/loan/by-user/{user_id}
 - Sample params: 
      - user_id: 1,2,3
      - limit: 10,20,30..500
  - Sample output: 
   ```json
    {
        "code": 200,
        "message": "",
        "data": [
            {
                "id": 1,
                "user_id": 1,
                "term": 2,
                "start_date": "2020-03-09",
                "end_date": "2022-03-09",
                "repayment_frequency": "Quarter",
                "Loan_status": "Paying",
                "interest_rate": 6,
                "amount": 10000,
                "payment_amount": 12500,
                "interest_amount": 2500,
                "remarks": "",
                "created_at": "2020-03-09 16:13:17",
                "updated_at": "2020-03-09 16:14:36"
            }
        ]
    }
   ```
#### Add payment for loan
 - Using get method: https://krol.diqit.io/api/v1/loan-payment/repayment
 - Sample params:
    - user: the user id
    - loan: loan id belongs to user
    - payment_date:  the period need to pay
    - amount: the money need to pay for 1 period
   ```json
    {
      "user": 1,
      "loan": 1,
      "payment_date": "2020-3-01",
      "amount": 880
    }
   ```
  - Sample output: 
   ```json
    {
        "code": 200,
        "message": "Your payment updated successfully.",
        "data": ""
    }
   ```
#### Get list loan payment by loan
 - Using get method: https://krol.diqit.io/api/v1/loan-payment/by-loan/{loan_id}
 - Sample params: 
      - loan_id: 1,2,3 // get from list loan
      - is_active: [0,1] // 0 => the payment by period still not paid, 1=> already paid
  - Sample output: 
   ```json
    {
      "code": 200,
      "message": "",
      "data": [
        {
          "id": 2,
          "loan_id": 1,
          "due_date": "2020-04-30",
          "amount": 608.34,
          "principal_amount": 416.67,
          "interest_amount": 191.67,
          "balance": 9166.66,
          "remarks": "",
          "is_active": 0,
          "created_by": 0,
          "updated_by": 0,
          "created_at": "2020-03-09 16:13:17",
          "updated_at": "2020-03-09 16:13:17"
        }
      ]
    }
   ```
