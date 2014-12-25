SymfonyBase
===========

Symfony base is a fully frontend/backend based on Symfony and other great bundles. This project can be used to develop any ecommerce website.

Requirements
------------

To run this project, following packages are required:

* [PHP5.4](http://php.net/releases/5_4_0.php)
* [Imagemagick](http://www.imagemagick.org/) >= 6.X
* [SQLite](http://www.sqlite.org/) >= 3.X

As this uses [Composer][1] to manage its dependencies, the recommended way to create a new project is to use it.

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

You can clone this proyect with git and then install the dependencies with Composer.

```bash
$ git clone https://github.com/arkaitzgarro/SymfonyBase.git <path/to/install>
$ cd path/to/install
$ composer install
```


System check
------------

Make sure that your local system is properly configured for Symfony Base.

Enter the `path/to/install` drectory and execute the `check.php` script from the
command line:

```bash
$ php app/check.php
```

The script returns a status code of `0` if requirements are met, `1` otherwise.

Database schema and fixtures
----------------------------

Create the database schema:

```bash
$ php app/console doctrine:database:create
$ php app/console doctrine:schema:create
```

You can now load the sample data by using the doctrine:fixture:load command. Remember that all fixtures are placed in a repository called BambooFixtures, so you must configure the --fixtures option with the right path.

```bash
php app/console doctrine:fixtures:load --fixtures="vendor/elcodi/bamboo-fixtures"
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

You can login as a registered admin user. Point your browser to `http://localhost:8080/gestor` and login using these credentials:

* user: johnwayne
* password: 1234

[1]:  http://getcomposer.org/