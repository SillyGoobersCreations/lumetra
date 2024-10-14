# Lumetra
Lumetra is an open-source conference meetup platform.

**Created for GodotCon 2024**

## Development Setup
**You might need to run ``chmod 777 -R .`` after cloning this repo to run the system properly. This is only required if files are created through Laravel Sail and in a development environment, see Issue #18**

- Clone ``.env.example`` to ``.env`` and set your environment variables
- Install Dependencies: ``docker run --rm -u "$(id -u):$(id -g)" -v "$(pwd):/var/www/html" -w /var/www/html laravelsail/php83-composer:latest composer install --ignore-platform-reqs``
- Start Services: ``./vendor/bin/sail up -d``
- Install UI Dependencies: ``./vendor/bin/sail npm install``
- Run Migrations: ``./vendor/bin/sail artisan migrate``
- Run Database seeders: ``./vendor/bin/sail artisan db:seed``
- Generate an app key: ``./vendor/bin/sail artisan key:generate``
- Start Dev Server: ``./vendor/bin/sail npm run dev``

## Production Setup
- Clone ``.env.example`` to ``.env`` and set your environment variables
- Install Dependencies: ``docker run --rm -u "$(id -u):$(id -g)" -v "$(pwd):/var/www/html" -w /var/www/html laravelsail/php83-composer:latest composer install --ignore-platform-reqs``
- Start Services: ``./vendor/bin/sail up -d``
- Install UI Dependencies: ``./vendor/bin/sail npm install``
- Run Migrations: ``./vendor/bin/sail artisan migrate``
- Run Database seeders: ``./vendor/bin/sail artisan db:seed``
- Build UI: ``./vendor/bin/sail npm run build``

## CLI Commands
**All commands are run with ``artisan``**

### lumetra:event:create
Creates a new event

### lumetra:organizer:make
Gives an existing attendee organizer permissions

### lumetra:organizer:remove
Takes an existing attendees organizer permissions

## License
This project is licensed under the GPLv3 license. To learn more, visit [LICENSE](LICENSE)
