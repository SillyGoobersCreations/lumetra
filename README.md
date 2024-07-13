# Lumetra

## Development Setup
- Clone ``.env.example`` to ``.env`` and set your environment variables
- Install Dependencies: ``docker run --rm -u "$(id -u):$(id -g)" -v "$(pwd):/var/www/html" -w /var/www/html laravelsail/php83-composer:latest composer install --ignore-platform-reqs``
- Start Services: ``./vendor/bin/sail up -d``
- Install UI Dependencies: ``./vendor/bin/sail npm install``
- Run Migrations: ``./vendor/bin/sail artisan migrate``
- Start Dev Server: ``./vendor/bin/sail npm run dev``

## Build UI
- Run: ``./vendor/bin/sail npm run build``
