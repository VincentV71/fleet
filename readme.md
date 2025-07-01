# Requirements
To run this project you will need a computer with PHP and composer installed.

# Install
To install the project, you just have to run `composer install` to get all the dependencies

# Running the tests
After installing the dependencies you can run the tests with this command `vendor/behat/behat/bin/behat`.
The result should look like this :
![behat.png](behat.png)

# Step 1 :
- See **"master"** branch.
- Version PHP used : 8.2.28.
- Running the tests with **in-memory persistance** :
```
vendor/behat/behat/bin/behat --tags="@in-memory"
```
Or without tag :
```
vendor/behat/behat/bin/behat
```

# Step 2 :
- See **"step_2"** branch.
- Enable PHP extensions : **pdo_sqlite** and **sqlite3** (for the Sqlite CLI).
- Database managed with 'doctrine/orm'.
- Console Commands made with the "symfony/console" component.
- Run "composer install" to install those new libs.
- Within the root directory ("fleet"), run the console commands like this :
```
php fleet create <userId>
```
- Running the tests with **in-db persistance** :
```
vendor/behat/behat/bin/behat --tags="@in-db"
```
- For DB schema information, run :
```
sqlite3 fleet.sqlite
.schema
```