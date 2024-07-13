# Lumetra

## Development Setup
**You might need to run ``chmod 777 -R .`` after cloning this repo to run the system properly.**

- Clone ``.env.example`` to ``.env`` and set your environment variables
- Install Dependencies: ``docker run --rm -u "$(id -u):$(id -g)" -v "$(pwd):/var/www/html" -w /var/www/html laravelsail/php83-composer:latest composer install --ignore-platform-reqs``
- Start Services: ``./vendor/bin/sail up -d``
- Install UI Dependencies: ``./vendor/bin/sail npm install``
- Run Migrations: ``./vendor/bin/sail artisan migrate``
- Run Database seeders: ``./vendor/bin/sail artisan db:seed``
- Generate an app key: ``./vendor/bin/sail artisan key:generate``
- Start Dev Server: ``./vendor/bin/sail npm run dev``

## Build UI
- Run: ``./vendor/bin/sail npm run build``
