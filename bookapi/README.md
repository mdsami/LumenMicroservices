# Lumen Microservices
<p align="center">
  <a href="https://lumen.laravel.com/" alt="Built with: Lumen v7.2.0">
    <img src="https://badgen.net/badge/Built%20with/Lumen%20v7.2/F4645F" />
  </a>
  <a href="https://www.php.net/downloads.php" alt="Powered by: PHP v7.4.4">
    <img src="https://badgen.net/badge/Powered%20by/PHP%20v7.4.4/8892BF" />
  </a>
</p>

## Installation and Requirements
1.  Install [Composer](https://getcomposer.org/download/)
2.  Install [Xampp](https://www.apachefriends.org/download.html)
3.  Install [Postman](https://www.postman.com/downloads/)
4.  Install [SQLite](https://www.sqlite.org/download.html)
    -   Makes sure to download the **"sqlite-tools-win32-x86"** from PreCompiled Binaries for Windows.
    -   For more information on setting up SQLite please follow this tutorial by [ProgrammingKnowledge](https://www.youtube.com/watch?v=wXEZZ2JT3-k) on [YouTube]((https://www.youtube.com/watch?v=wXEZZ2JT3-k)). 
5.  Install [SQLiteStudio](https://sqlitestudio.pl/)
6.  Clone the repository.
7.  Use [Composer](https://getcomposer.org/download/) to install the required dependencies by navigating to the root directory of the cloned repository and run the following command inside the Terminal:
```bash
composer install
``` 
8.  Rename the **".env.example"** file in the root directory to **".env"** for **"api_gateway"**, **"authors_api"** and **"books_api"**.
9.  Generate 3 application keys using [Random string generator](http://www.unit-conversion.info/texttools/random-string-generator/):
    -   Change the **Number of Strings to 3**, **Length to 32 characters** and click **Generate**. 
    -   Copy the 3 keys from Output and initialize the **APP_KEY=** inside the **".env"** files for **"api_gateway"**, **"authors_api"** and **"books_api"**.
10. Generate 2 additional keys using [Random string generator](http://www.unit-conversion.info/texttools/random-string-generator/):
    -   Change the **Number of Strings to 2**, **Length to 32 characters** and click **Generate**.
    -   Copy the first key from Output and initialize the **AUTHORS_SERVICE_SECRET=** inside the **".env"** file for **"api_gateway"** and also replace the **ACCEPTED_SECRETS=** with the copied key for **"authors_api"**.
    -   Copy the second key from Output and initialize the **BOOKS_SERVICE_SECRET=** inside the **".env"** file for **"api_gateway"** and also replace the **ACCEPTED_SECRETS=** with the copied key for **"books_api"**.
11. Create the database file for **SQLite**: 
    -   Navigate to the **"api_gateway"** and create a file **database.sqlite** and store it under the **database** directory.
    -   Navigate to the **"authors_api"** and create a file **database.sqlite** and store it under the **database** directory.
    -   Navigate to the **"books_api"** and create a file **database.sqlite** and store it under the **database** directory.

## Running the application
1.  Initialize the database to add fake data:
    -   Open the Terminal instance and navigate to the root directory of **"authors_api"** and run the following commands:
        ```bash
        php artisan migrate
        php artisan db:seed
        ```
    -   Open the second Terminal instance and navigate to the root directory of **"books_api"** and run the following commands:
        ```bash
        php artisan migrate
        php artisan db:seed
        ```  
    -   Open the third Terminal instance and navigate to the root directory of **"api_gateway"** and run the following commands:
        ```bash
        php artisan migrate
        php artisan passport:install
        ``` 
2.  The **"php artisan passport:install"** command creates two clients in the **"api_gateway"** database table 'oauth_clients' **Personal access client** and **Password grant client** which is to be used to get the access token for the users.
3.  Run three servers, each for **"authors_api"**, **"books_api"** and **"api_gateway"**:
    -   Open the fourth Terminal and navigate to the root directory of **"authors_api"** and run the following command:
        ```bash
        php -S localhost:8000 -t public
        ``` 
    -   Open the fifth Terminal and navigate to the root directory of **"books_api"** and run the following command:
        ```bash
        php -S localhost:8001 -t public
        ```
    -   Open the sixth Terminal and navigate to the root directory of **"api_gateway"** and run the following command:
        ```bash
        php -S localhost:8002 -t public
        ```
4.  Copy the **Password grant client Id** and **Client Secret** from the third Terminal instance and make a POST request using POSTMAN to fetch the **access_token**:
    -   Url: http://localhost:8002/oauth/tokens
					
    -   Headers:
        {
            "Accept": "application/json"
            "Content-Type": "application/json"
        }
    -   Payload example:
        {
            "grant_type": "client_credentials",
            "client_id": 2,
            "client_secret": "B7K4zIlqygcmYOp73VhLmFGx9fcs5gAVELQZvGwy",
            "scope": "*"
            
        }
5.  The returned token can be used to access any route on **"api_gateway"** and will be as follows: 
    -   {
            "token_type": "Bearer",
            "expires_in": 31536000,
            "access_token": "returnedToken"
        }
6. Test the **access_token** by making a GET request using Postman:
    -   Url: http://localhost:8002/authors
    -   Authorization Type:
        {
            "Bearer Token": "returnedToken"
        }
7.  Create a new User using the **access_token** created in step 5 by making a POST request: 					
    -   Url: http://localhost:8002/users
    -   Authorization Type:
        {
            "Bearer Token": "returnedToken"
        }
    -   Headers:
        {
            "Accept": "application/json",
            "Content-Type": "application/json"
        }
    -   Payload:
        {
            "name": "Jack Sparrow",
            "email": "jack@example.com",
            "password": "password",
            "password_confirmation": "password"
        }
8.  Get personal **access_token** along with **refresh_token** for the User that was created in Step 7 by making a POST request:
    -   Url: http://localhost:8002/oauth/tokens
    -   Headers:
        {
            "Accept": "application/json",
            "Content-Type": "application/json"
        }
    -   Payload:
        {
            "grant_type": "password",
            "client_id": 2,
            "client_secret": "B7K4zIlqygcmYOp73VhLmFGx9fcs5gAVELQZvGwy",
            "scope": "*",
            "username": "jackie@example.com",
            "password": "random"
        }    
9.  The returned response for Step 8 is as follows:
    -   {
            "token_type": "Bearer",
            "expires_in": 31536000,
            "access_token": "userAccessToken",
            "refresh_token": "userRefreshToken"
        }
10. Use the User's **access_token** returned in Step 9 to make any GET, POST, PUT, DELETE request on **"authors_api"** or **"books_api"**: 
    -   Request: GET
    -   Url: http://localhost:8002/users
    -   Authorization Type:
        {
            "Bearer Token": "userAccessToken"
        }
