## Getting Started
This project is developed using following main tools/technologies
1. PHP 7.2
2. Symfony 4.3
3. Docker
4. MySql
5. Nginx
6. JS/jQuery, HTML, CSS/SASS, Mixinx, but no bootstrp as it requested not to use  
7. PhpUnit test


### Prerequisites

* docker
* docker-compose

### Step 1. Unzip 
When you see this README file you are most probably unziped the project, if otherwise please unzip it
 

### Step 2. Running project in docker
Go to project root directory and run following command 
```
docker-compose up -d
```

Verifying if docker service is running and as per docker-compose.yml configuration you have see four docker
services should be running 
```
docker-compose ps
```


#### Installing project dependencies in docker
* Go inside **php_api** docker container 
```
docker-compose exec php_api bash
```

* install project dependencies via composer
```
composer install
```

#### Set DB for the project

##### Doctrine & Migrations
create local database
```
bin/console doctrine:database:create
```

To see if a migration needs to be done, use
```
bin/console doctrine:migrations:status
```

To do the migration(s), run
```
bin/console doctrine:migrations:migrate
```

### Step 3. Test and running in browser
After running docker-compose and installing project dependencies you can test project in browser under 
following link (default configuration)  
[http://localhost:8080/](http://localhost:8080/)  
[List of articles](http://localhost:8080/articles)  
[Upload JSON](http://localhost:8080/upload)  
[Article details](http://localhost:8080/article/jbl-pulse-3-im-test-1.html)


### Step 4. Unit-Test using PHP-Unit
Although the test coverage is not complete, but i tried to write a few unit tests 
* Go inside **php_api** docker container 
```
docker-compose exec php_api bash
```

use the following command in your terminal
```
 php bin/phpunit
```