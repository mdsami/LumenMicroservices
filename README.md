# Lumen Microservices
<p align="center">
  <a href="https://lumen.laravel.com/" alt="Built with: Lumen v8.3.4">
    <img src="https://badgen.net/badge/Built%20with/Lumenv8.3.4)/F4645F" />
  </a>
  <a href="https://www.php.net/downloads.php" alt="Powered by: PHP v8.0">
    <img src="https://badgen.net/badge/Powered%20by/PHPv8.0/8892BF" />
  </a>
</p>

## Installation and Requirements
1.  Install [Composer](https://getcomposer.org/download/)
2.  Install [Postman](https://www.postman.com/downloads/)
    
3.  Use [Composer](https://getcomposer.org/download/) to install the required dependencies by navigating to the root directory of the cloned repository and run the following command inside the Terminal:
```bash
composer install
``` 
4.  Rename the **".env.example"** file in the root directory to **".env"** for **"apigateway"**, **"authorapi"** and **"bookapi"**.
5.  Generate 3 application keys using [Random string generator](http://www.unit-conversion.info/texttools/random-string-generator/):
    -   Change the **Number of Strings to 3**, **Length to 32 characters** and click **Generate**. 
    -   Copy the 3 keys from Output and initialize the **APP_KEY=** inside the **".env"** files for **"apigateway"**, **"authorapi"** and **"booksapi"**.
6. Generate 2 additional keys using [Random string generator](http://www.unit-conversion.info/texttools/random-string-generator/):
    -   Change the **Number of Strings to 2**, **Length to 32 characters** and click **Generate**.
    -   Copy the first key from Output and initialize the **AUTHORS_SERVICE_SECRET=** inside the **".env"** file for **"apigateway"** and also replace the **ACCEPTED_SECRETS=** with the copied key for **"authorapi"**.
    -   Copy the second key from Output and initialize the **BOOKS_SERVICE_SECRET=** inside the **".env"** file for **"apigateway"** and also replace the **ACCEPTED_SECRETS=** with the copied key for **"booksapi"**.
11. Create the database file for **MySql**: 
    -   create a file database  **"apigateway"** .
    -   create a file database   **"authorapi"** .
    -  create a file database   **"bookapi"** .

## Running the application
1.  Initialize the database to add fake data:
    -   Open the Terminal instance and navigate to the root directory of **"authorapi"** and run the following commands:
        ```bash
        php artisan migrate
        php artisan db:seed
        ```
    -   Open the second Terminal instance and navigate to the root directory of **"bookapi"** and run the following commands:
        ```bash
        php artisan migrate
        php artisan db:seed
        ```  
    -   Open the third Terminal instance and navigate to the root directory of **"apigateway"** and run the following commands:
        ```bash
        php artisan migrate
        php artisan passport:install
        ``` 
2.  The **"php artisan passport:install"** command creates two clients in the **"apigateway"** database table 'oauth_clients' **Personal access client** and **Password grant client** which is to be used to get the access token for the users.
3.  Run three servers, each for **"authorapi"**, **"bookapi"** and **"apigateway"**:
    -   Open the fourth Terminal and navigate to the root directory of **"authorapi"** and run the following command:
        ```bash
        php -S localhost:8000 -t public
        ``` 
    -   Open the fifth Terminal and navigate to the root directory of **"bookapi"** and run the following command:
        ```bash
        php -S localhost:8001 -t public
        ```
    -   Open the sixth Terminal and navigate to the root directory of **"apigateway"** and run the following command:
        ```bash
        php -S localhost:8002 -t public


        ```


4.  Copy the **Password grant client Id** and 
**Client Secret** from the third Terminal 
instance and make a POST request using POSTMAN to fetch the **access_token**:




# API Docs

API docs are available here: https://documenter.getpostman.com/view/2791867/UyxojQ8M

# Postman 

[![Run in Postman](https://run.pstmn.io/button.svg)](https://www.getpostman.com/collections/45f9877d204f6c9cca3c=)

