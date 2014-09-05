SymfonyBase
===========

Symfony base is a fully frontend/backend based on Symfony and other great bundles. This project can be used to develop any standard website.

Requirements
------------

To run this project, following packages are required:

* [PHP5.4](http://php.net/releases/5_4_0.php)
* [Imagemagick](http://www.imagemagick.org/) >= 6.X
* [SQLite](http://www.sqlite.org/) >= 3.X

As Bamboo Admin uses [Composer][1] to manage its dependencies, the recommended way to create a new project is to use it.

If you don't have Composer yet, download it following the instructions on http://getcomposer.org/ or just run the following command:

```bash
$ curl -s http://getcomposer.org/installer | php
```

Installation
------------

Use the `create-project` command to generate a new Symfony Base application:

```bash
$ php composer.phar create-project arkaitzgarro/symfony-base <path/to/install> dev-master
```

Composer will install Symfony Base and all its dependencies under the `path/to/install` directory.


System check
------------

Make sure that your local system is properly configured for Symfony Base.

Enter the `path/to/install` drectory and execute the `check.php` script from the
command line:

```bash
$ php app/check.php
```

The script returns a status code of `0` if requirements are met, `1` otherwise.

Database schema
---------------

Create the database schema:

```bash
$ php app/console doctrine:database:create
$ php app/console doctrine:schema:create
```

Install the assets
------------------

```bash
$ php app/console assets:install web
$ php app/console assetic:dump
```

Run the application
-------------------

You can run the application using php's built-in web server.

```bash
$ php app/console server:run localhost:8080
```

Point your browser to `http://localhost:8080` and you are done!


Login as an admin user
----------------------

You can login as an already registered admin user using these credentials.

* user: admin
* password: 1234

[1]:  http://getcomposer.org/