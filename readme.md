## CodeIgniter 3 REST API Integration with JWT
This toolkit is for people who like to build web REST API's with token based structure like JWT using PHP. Its goal is to enable you to develop api much faster than you could if you were writing code from scratch, by providing a template for your workings with the REST API with JWT based tokens.

*********************
**Release Information**
*********************
This repo contains in-development code for future releases.

*********
**Features**
*********

1. Complete REST API control
2. JWT based access tokens
3. CRUD operations
4. Register/Login/Logout Mechanism
5. Proper Authentication
6. Validation control
7. DB structure given
8. Required SQL given
9. Routing handled
10. Session management
11. Postman collection added

***********
**Instruction**
***********

- Change `jwt_key` & `token_expire_time` according to your need.
- Change `$config['base_url']` in config.php
- Change DB credentials accordingly in database.php
- Import .sql file of create by database tables from raw SQL given above controller file. 
- Register a User.
- Login with that user to get the `access_token`.
- To perform crud operations you have to supply the `access_token` in header for `Authorization` with other data in body section.
- If `access_token` expired, you can also regenerate `access_token` by providing `username`.
- Logout & clear the session.

> [!IMPORTANT]
> Initially `access_token` has been set for 1 minute.

> [!WARNING]
> `jwt_key` must be changed for your own protection in production environment.
***********************
**Postman Calls & Methods**
***********************

#### Register & Login

POST : [http://localhost/api_jwt_ci3/register](http://localhost/api_jwt_ci3/register)

|Body     |
|---------|
|username |
|email    |
|password |

POST : [http://localhost/api_jwt_ci3/login](http://localhost/api_jwt_ci3/login)

|Body     |
|---------|
|username |
|password |

POST : [http://localhost/api_jwt_ci3/logout](http://localhost/api_jwt_ci3/logout)

### CRUD

GET : [http://localhost/api_jwt_ci3/product](http://localhost/api_jwt_ci3/product)


|Headers      |Body     |
|-------------|---------|
|Authorization|         |

POST : [http://localhost/api_jwt_ci3/product](http://localhost/api_jwt_ci3/product)

|Headers      |Body     |
|-------------|---------|
|Authorization|name     |
|             |price    |

PUT : [http://localhost/api_jwt_ci3/product/:id](http://localhost/api_jwt_ci3/product/:id)

|Headers      |Body     |
|-------------|---------|
|Authorization|         |
|name         |         |
|price        |         |

DELETE : [http://localhost/api_jwt_ci3/product/:id](http://localhost/api_jwt_ci3/product/:id)

|Headers      |Body     |
|-------------|---------|
|Authorization|         |

### Token Regeneration

POST : [http://localhost/api_jwt_ci3/reGenToken](http://localhost/api_jwt_ci3/reGenToken)

|Body     |
|---------|
|username |

*******************
Server Requirements
*******************

PHP version 5.6 or newer is recommended.
It should work on 5.3.7 as well, but we strongly advise you NOT to run
such old versions of PHP, because of potential security and performance
issues, as well as missing features.
