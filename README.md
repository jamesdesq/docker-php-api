# Docker & Nginx & PHP/PHP best practices

This repo started as two repos. One was a sandbox I was using to do some stuff with PayPal, the other was a docker-compose build with PHP-FPM and Nginx I was using to learn about Dockerised PHP. The PayPal one started also being about PHP best practice - PRS, unit testing, linting and other things. I realised I wanted to merge the two.

## Getting started

1. Clone the repo
2. `docker compose up -d --build`
3. Log into the docker container - it should be `docker exec -ti app /bin/bash`, but do `docker ps` to check the container name.
3. Run `composer install` in the root.
4. Navigate to http://localhost:82

## Code style

You can run codesniffer with `./vendor/squizlabs/php_codesniffer/bin/phpcs --ignore=/vendor/ .` 

## Debugging

You'll need to make a launch.json file in VSCode, at .vscode/launch.json

```
{
    "version": "0.2.0",
    "configurations": [
        {
            "name": "Listen for XDebug on Docker",
            "type": "php",
            "request": "launch",
            "port": 9003,
            "pathMappings": {
                "/var/www/": "${workspaceFolder}"
            }
        }
    ]
}
```

## Based on...

https://www.digitalocean.com/community/tutorials/how-to-run-nginx-in-a-docker-container-on-ubuntu-22-04

https://www.digitalocean.com/community/tutorials/how-to-set-up-laravel-nginx-and-mysql-with-docker-compose-on-ubuntu-20-04

Xdebug configuration from https://matthewsetter.com/setup-step-debugging-php-xdebug3-docker/ 