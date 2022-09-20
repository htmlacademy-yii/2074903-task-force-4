<p align="center">
    <a href="https://github.com/htmlacademy-yii/2074903-task-force-4">
        <img src="web/img/logotype.png" width=227 height=60 alt="taskforce">
    </a>
    <h1 align="center">TaskForce</h1>
    <h3 align="center">study project by Olga Marinina</h3>
</p>
<p align="center">
<img src="https://img.shields.io/badge/php-%5E8.1.0-blue">
<img src="https://img.shields.io/badge/mysql-latest-orange">
<img src="https://img.shields.io/badge/yii2-~2.0.45-green">
<img src="https://img.shields.io/badge/phpunit-~9.5.0-blue">
</p>
<br>

* Student: [Olga Marinina](https://up.htmlacademy.ru/yii/4/user/2074903).
* Mentor: [Mikhail Selyatin](https://htmlacademy.ru/profile/id919955).

About project
-------------------

"TaskForce" is an online platform for finding executors for one-time tasks.
The site functions as an ad exchange where individual customers publish tasks.
Executors can respond to these tasks by offering their services and the cost of the work.

### Main use cases

* Publishing a task
* Adding a response to a task
* Search for tasks by category and name
* Selecting an executor and assigning him to a task
* Editing a profile



DIRECTORY STRUCTURE
-------------------

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      data/               contains csv-data for DB
      docker/             contains data from DB volumes
      mail/               contains view files for e-mails
      models/             contains model classes
      runtime/            contains files generated during runtime
      sql/                contains schema mysql DB and some instructions for mysql
      src/                contains individual classes creating by us
      tests/              contains various tests for the basic application (just unit)
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources
      widgets/            contains some widgets



REQUIREMENTS
------------

We work on this project with docker-compose.

**Images**:
* yiisoftware/yii2-php:8.1-apache
* mysql:latest

You can then access the application through the following URL:

    http://127.0.0.1:8000



CONFIGURATION
-------------

### Database

Edit the file `config/db.php` with real data, for example:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'root',
    'password' => '1234',
    'charset' => 'utf8',
];
```



TESTING
-------

Tests are located in `tests` directory. We use only unit tests on this project.

Tests can be executed by running

```
vendor/bin/codecept run
```

The command above will execute unit. Unit tests are testing the system components. 


### Code coverage support

By default, code coverage is disabled in `codeception.yml` configuration file, you should uncomment needed rows to be able
to collect code coverage. You can run your tests and collect coverage with the following command:

```
#collect coverage only for unit tests
vendor/bin/codecept run unit --coverage --coverage-html --coverage-xml
```

You can see code coverage output under the `tests/_output` directory.