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

### Methods of Application

Application has three main methods.
1. Method `run`: Starts the application.
```php
$app->run();
```
2. Method `get`: Allows you to get data from the container. It accepts two parameters `get($key, $default)`. If the data does not exist by key, the value passed by the second parameter is returned, or `null`.
```php
$app->get('data');
```
3. Method `set`: Allows you to put data into the container. It accepts two parameters `set($key, $value)`. Sets the value of `$value` by the `$key`.
```php
$app->set('data', ['some data' => 'value']);
```

The get and set methods are useful for debugging and storing some data throughout the application.

### Methods of Cache

Cache has three main methods.
1. Method `get`: Allows you to get data from the container. It accepts two parameters `get($key, $default)`. If the data does not exist by key, the value passed by the second parameter is returned, or `null`.
```php
$cache->get('tags');
```
2. Method `set`: Caches data for a specific time, by default one hour. It accepts 3 parameters `set($key, $data, $time)`. Sets data `$data` under `$key` to a time equal to `$time`.
```php
$cache->set('tags', ['tag1' => 'value1', 'tag2' => 'value2'], 7200);
```
3. Method `forget`: Removes data from the cache. It takes one parameter `forget($key)`. The key under which the data was written.
```php
$cache->forget('tags');
```

### Methods of Controller

Controller has a method.
Method `render`: Renders the view. Takes three parameters `render($view, $data = [], $layout = '')`. 
`$view` - File name (without extension: `home.php` = `home`).
`$data` - Data passed to the view.
`$layout` - The page template used in the view. File name (without extension: `default.php` = `default`).
```php
app()->view->render('home', ['title' => 'Home page'], 'default')
```

### Methods of Database

Before working with the databases, remember to set up the configuration files. This is mandatory.

1. Method `query`: Allows you to query the database. Accepts two parameters `query($query, $params = [])`. The query itself and the parameters, if they are required for the query. The query method excludes the possibility of SQL injection.
```php
db()->query("SELECT COUNT(*) FROM posts WHERE category_id = ?", [$category['id']])
```
2. Method `get`: Returns all the rows in the query.
```php
db()->query("SELECT COUNT(*) FROM posts WHERE category_id = ?", [$category['id']])->get()
```
3. Method `getOne`: Returns the row as requested.
```php
db()->query("SELECT * FROM tags WHERE slug = ?", [$slug])->getOne()
```
4. Method `findAll`: Returns all rows from the table. Accepts one parameter `findAll($tbl)` - table name.
```php
db()->findAll('categories')
```
5. Method `findOne`: Returns a row from the table by id. Accepts two parameters `findOne($tbl, $id)`. `$tbl` - table name, `$id` - item id.
```php
db()->findAll('categories', 5)
```
6. Method `findOrFail`: Returns a row from the table by id. Accepts two parameters `findOrFail($tbl, $id)`. `$tbl` - table name, `$id` - item id. If the row was not found, it returns an error.
```php
db()->findOrFail('categories', 5)
```
