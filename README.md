# zdenekzahor/astramodel

🏎  PHP connnector for Astramodel products

## Setup

1. `cd .docker`
1. `docker-compose build`

## Test

1. `cd .docker`
1. `docker-compose run -u $(id -u):$(id -g) --rm php composer install`
1. `docker-compose run -u $(id -u):$(id -g) --rm php composer test`

## Run CLI

1. `cd .docker`
1. `docker-compose run -u $(id -u):$(id -g) --rm php composer install --no-dev`
1. `docker-compose run -u $(id -u):$(id -g) --rm php php Astramodel.php list`
1. `docker-compose run -u $(id -u):$(id -g) --rm php php Astramodel.php product <url> --only-count`
1. `docker-compose run -u $(id -u):$(id -g) --rm php php Astramodel.php product <url> --only-name`
1. `docker-compose run -u $(id -u):$(id -g) --rm php php Astramodel.php product <url>`
