# EonX Test Task
An online exam sample API development for Mailchimp by Joseph Ian Farillas

## Installation
1. Git clone the project:
```
git clone https://github.com/jfarillas/test-task-php.git
```

2. Option A
- Using Composer to install ```vendor``` dependencies:
```
composer install
composer dump-autoload
```

Option B. Using Docker
- Using Docker Machine 
```
docker-machine create --driver virtualbox dev
```
- Docker Compose
```
docker-compose up --build test-task-api
```

- Docker Compose (Run in the background)
```
docker-compose up --build -d test-task-api
```

3. Go to the browser and type ``` http://127.0.0.1:8000 ``` or ``` http://192.168.99.100:8000 ``` if you are using Docker.


