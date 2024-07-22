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

## Usage Examples

### Example of Creating a Controller
In this framework, the entry point and the base controller already exist and are configured. You can attach additional functionality to the base controller, which will apply to all controllers inherited by the base controller.
<br>
<br>
To create a new controller, you need to inherit it from the base controller and create methods that perform the functionality required to render a particular page.
```php
<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    public function index()
    {
        return view('home');
    }
}
```
<br>
An example of a more complex controller that passes certain pagination and generic data to the view.

```php
class HomeController extends BaseController
{
    public function index()
    {
        $page = (int)request()->get('page', 1);
        $total = db()->getCount('posts');
        $per_page = 5;
        $pagination = new Pagination($page, $per_page, $total);
        $start = $pagination->getStart();

        $posts = db()->query("SELECT p.title, p.slug, p.excerpt, p.image, DATE_FORMAT(p.created_at, '%b %D \'%y') AS created_at, c.title AS c_title, c.slug AS c_slug FROM posts p JOIN categories c ON c.id = p.category_id ORDER BY p.created_at DESC LIMIT $start, $per_page")->get();

        $title = 'Home page' . ($page > 1 ? " - Page {$page}" : '');
        return view('home', ['title' => $title, 'posts' => $posts, 'pagination' => $pagination]);
    }
}
```
<br>
<br>
### Example of Creating a Model
