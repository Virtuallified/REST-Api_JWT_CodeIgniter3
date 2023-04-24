# CodeIgniter 3 REST API Integration with JWT

This sandbox is for people who would like to build web REST API's with token based structure like JWT using PHP. Its goal is to enable you to develop API much faster than you could if you were writing code from scratch, by providing a template for your workings with the REST API with JWT based tokens.

## Features

1. Complete REST API control
2. JWT based access tokens
3. CRUD operations
4. Register/Login Mechanism
5. Proper Authentication
6. Validation control
7. DB structure given
8. Required SQL given
9. Routing handled
10. Postman collection added

## Live Test

- Download [postman collection](https://vittoretti.com/portfolio/download.php?file=rest_api_jwt-production-postman) and test this sandbox now.

## Instruction

- Change `jwt_key` & `token_expire_time` according to your need.
- Change `$config['base_url']` in config.php
- Change DB credentials accordingly in database.php
- Import .sql file of create by database tables from raw SQL given above controller file. 
- Register a User.
- Login with that user to get the `access_token`.
- To perform crud operations you have to supply the `access_token` in header for `Jwt-Authorization` param with other data in body section.
- Initially `access_token` expires after 10 minutes.
- `jwt_key` must be changed for your own protection in production environment.

## Postman Calls & Methods

### Authentication

#### Register

Verb POST 

URL [http://localhost/dev/php-codeigniter3/rest_api_jwt/register](http://localhost/dev/php-codeigniter3/rest_api_jwt/register)

|Body     |
|---------|
|username |
|email    |
|password |

#### Login

Verb POST

URL [http://localhost/dev/php-codeigniter3/rest_api_jwt/login](http://localhost/dev/php-codeigniter3/rest_api_jwt/login)

|Body     |
|---------|
|username |
|password |

#### Verify Token

Verb POST

URL [http://localhost/dev/php-codeigniter3/rest_api_jwt/api/test_api/verify_token](http://localhost/dev/php-codeigniter3/rest_api_jwt/api/test_api/verify_token)

|Headers      |Body     |
|-------------|---------|
|Jwt-Authorization|         |

### Product CRUD

#### List

Verb GET

URL [http://localhost/dev/php-codeigniter3/rest_api_jwt/product/list](http://localhost/dev/php-codeigniter3/rest_api_jwt/product/list)

|Headers      |Body     |
|-------------|---------|
|Jwt-Authorization|         |

#### Show

Verb GET 

URL [http://localhost/dev/php-codeigniter3/rest_api_jwt/product/show/:id](http://localhost/dev/php-codeigniter3/rest_api_jwt/product/show/:id)

|Headers      |Body     |
|-------------|---------|
|Jwt-Authorization|         |

#### Insert

Verb POST 

URL [http://localhost/dev/php-codeigniter3/rest_api_jwt/product/insert](http://localhost/dev/php-codeigniter3/rest_api_jwt/product/insert)

|Headers      |Body     |
|-------------|---------|
|Jwt-Authorization|name     |
|             |price    |

#### Update

Verb POST

URL [http://localhost/dev/php-codeigniter3/rest_api_jwt/product/update/:id](http://localhost/dev/php-codeigniter3/rest_api_jwt/product/update/:id)

*\* Ideally we should use **PUT** verb to **UPDATE** action. But PHP doesn’t work properly with **PUT** (it's hard to get the PUT parameters). So the solution is to use **POST** verb to perform an **UPDATE**.*

|Headers      |Body     |
|-------------|---------|
|Jwt-Authorization|name     |
|             |price    |

#### Delete

Verb DELETE

URL [http://localhost/dev/php-codeigniter3/rest_api_jwt/product/delete/:id](http://localhost/dev/php-codeigniter3/rest_api_jwt/product/delete/:id)

|Headers      |Body     |
|-------------|---------|
|Jwt-Authorization|         |

## Server Requirements

- Tested in XAMPP 3.3.0 with:
  - PHP 8.0.13
  - 10.4.22-MariaDB
  - Apache/2.4.51 (Win64) 
- This should work with PHP 5.6 or newer.

## Reference

This sandbox is based on these repos:

- https://github.com/chriskacerguis/codeigniter-restserver
- https://github.com/Virtuallified/REST-Api_JWT_CodeIgniter3
