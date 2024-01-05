# Novatura Laravel Utilities

## Repository Tracking

- [ ] Frontend scaffolding (custom implementation of Breeze)
- [x] Roles and Permissions scaffolding
- [x] Model logging scaffolding
- [ ] User History scaffolding
- [ ] Error Central scaffolding
- [ ] Repository Pattern scaffolding

## Usage

### Installation

```bash
composer require novatura/laravel
```

### Commands

#### Scaffold

Install basic login/register functionality with Mantine UI.

```bash
php artisan novatura:scaffold:install
```

## Local Development

Local development is a bit tricky, because we need to mount this repository into the docker container of a sandbox/testing project.

The following steps are going to have you *create a fresh laravel project* and *mount this repository into it*.

1. Create a fresh Laravel project with Sail somewhere other than this repository
   - `laravel new sandbox && cd sandbox`
   - `composer require laravel/sail --dev`
   - `php artisan sail:install`
      - When prompted, select `mysql`, `redis` and `mailpit`

2. Add this repository as a package by adding the following to the end of your `./composer.json`

    ```json
    {
        "repositories": [
            {
                "type": "path",
                "url": "/Users/{username}/code/novatura/laravel",
                "options": {
                    "symlink": false
                }
            }
        ]
    }
    ```

    This tells composer to check both the online repo and the local path for a package when you run composer install.

    > I'm sure you can get a relative path to work, I just haven't bothered. Absolute paths work fine. **Make sure you change {username} to your actual username.** (now is probably a good time to say I have only tested any of this on MacOS)

3. Install package: `composer require novatura/laravel @dev`
    - The `@dev` is required - it won't work without it.
    - If you ever get an error about not finding a release - it's because you forgot the `@dev`.
4. Publish sail's docker-compose.yml file: `php artisan sail:publish`
5. Modify the `./docker-compose.yml` to mount this repo:

    Change:

    ```yaml
    volumes:
        - '.:/var/www/html'
    ```

    To:

    ```yaml
    volumes:
        - '.:/var/www/html'
        - '/Users/{username}/code/novatura/laravel:/var/www/html/vendor/novatura/laravel'
    ```

    If you forgot to include Mailpit when setting up sail, add it as a service to `docker-compose.json`:

    ```yaml
    mailpit:
        image: 'axllent/mailpit:latest'
        ports:
            - '${FORWARD_MAILPIT_PORT:-1025}:1025'
            - '${FORWARD_MAILPIT_DASHBOARD_PORT:-8025}:8025'
        networks:
            - sail
     ```

6. Start sail: `./vendor/bin/sail up`
7. Make a git commit in your sandbox project
    - This is so that you can constantly roll back to the clean slate 😉

At this stage, you can use our commands and such, e.g. `php artisan novatura:scaffold:install`

Whenever you want to test a command or a change, you'll want to reinstall the package so that it sends the latest code to the docker container!

For example:

```bash
composer require novatura/laravel @dev && php artisan novatura:scaffold:install
```

With Sail running, you can access all outbound emails by going to `http://localhost:8025` in your browser (Mailpit dashboard).

