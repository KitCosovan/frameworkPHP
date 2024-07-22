# Base Frame

**Base Frame** is a lightweight and flexible PHP framework that provides all the necessary tools for rapid web application development. It comes pre-configured so you can start creating your own views, models, and controllers right away.

## Installation

### Using Composer

You can install **Base Frame** via Composer. Add the following line to the `require` section of your `composer.json`:

```json
"kit-cosovan/base-frame": "^1.0"
```

Then run:
```bash
composer install
```

## Core Components

- `index.php`: This file already contains the basic framework setup and serves as the entry point for your application. You do not need to modify it to start development.
- `app/Controllers`: Directory for storing your controllers.
- `app/Models`: Directory for your models.
- `app/Views`: Directory for your views, including folders for errors and templates.
- `config`: Framework settings, including routes and initialization.
- `core`: Core classes of the framework, such as Application, Controller, Database, and others.
- `helpers`: Utility functions that can be used throughout your application.

## Getting Started

1. Create Controllers: Navigate to the `app/Controllers` directory and create new controller files to handle requests.
2. Create Models: Go to the `app/Models` directory and create models for interacting with the database.
3. Create Views: Head to the `app/Views` directory and create view files to display data.
4. Configure Routes: Edit the `config/routes.php` file to set up your application's routes.

