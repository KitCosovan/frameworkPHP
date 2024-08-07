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
$app = new \PHPFramework\Application();
$app->run();
```
2. Method `get`: Allows you to get data from the container. It accepts two parameters `get($key, $default)`. If the data does not exist by key, the value passed by the second parameter is returned, or `null`.
```php
$app = new \PHPFramework\Application();
$app->get('data');
```
3. Method `set`: Allows you to put data into the container. It accepts two parameters `set($key, $value)`. Sets the value of `$value` by the `$key`.
```php
$app = new \PHPFramework\Application();
$app->set('data', ['some data' => 'value']);
```

The get and set methods are useful for debugging and storing some data throughout the application.

<br>
<br>

### Methods of Cache

Cache has three main methods.
1. Method `get`: Allows you to get data from the container. It accepts two parameters `get($key, $default)`. If the data does not exist by key, the value passed by the second parameter is returned, or `null`.
```php
$cache = new \PHPFramework\Cache();
$cache->get('tags');
```
2. Method `set`: Caches data for a specific time, by default one hour. It accepts 3 parameters `set($key, $data, $time)`. Sets data `$data` under `$key` to a time equal to `$time`.
```php
$cache = new \PHPFramework\Cache();
$cache->set('tags', ['tag1' => 'value1', 'tag2' => 'value2'], 7200);
```
3. Method `forget`: Removes data from the cache. It takes one parameter `forget($key)`. The key under which the data was written.
```php
$cache = new \PHPFramework\Cache();
$cache->forget('tags');
```

<br>
<br>

### Methods of Controller

Controller has a method.
Method `render`: Renders the view. Takes three parameters `render($view, $data = [], $layout = '')`. 
`$view` - File name (without extension: `home.php` = `home`).
`$data` - Data passed to the view.
`$layout` - The page template used in the view. File name (without extension: `default.php` = `default`).
```php
app()->view->render('home', ['title' => 'Home page'], 'default')
```

<br>
<br>

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
db()->findOne('categories', 5)
```
6. Method `findOrFail`: Returns a row from the table by id. Accepts two parameters `findOrFail($tbl, $id)`. `$tbl` - table name, `$id` - item id. If the row was not found, it returns an error.
```php
db()->findOrFail('categories', 5)
```
7. Method `getInsertId`: Returns the id of the string.
```php
db()->getInsertId()
```
8. Method `rowCount`: Returns the number of rows affected by the last SQL.
```php
db()->rowCount()
```
9. Method `getColumn`: Returns the data of the requested column.
```php
db()->query("SELECT $data FROM $tbl WHERE $param = ?", [$value])->getColumn()
```
10. Method `getCount`: Returns the number of rows in the table. Accepts one parameter `getCount($tbl)` - table name.
```php
db()->getCount($tbl);
```
11. Method `getQueries`: Returns all used SQL queries on the page. Useful for debugging.
```php
db()->getQueries();
```

<br>
<br>

### Methods of Model

When creating a model, there are several mandatory variables to create. 
 - Variable `$table` - name of the table to which the model refers.
 - Variable `$fillable` - an array of names of fields mandatory for filling. When working with forms.
 - Variable `$rules` - an array of validation rules for fields to be filled in.

Example of model creation:
```php
class User extends Model
{
    public string $table = 'users';
    public array $fillable = ['name', 'email', 'password', 'repassword',];

    public array $rules = [
        'name' => ['required' => true, 'max' => 100],
        'email' => ['email' => true, 'max' => 100, 'unique' => 'users:email'],
        'password' => ['required' => true, 'min' => 6],
        'repassword' => ['match' => 'password'],
        'avatar' => ['ext' => 'jpg|png', 'size' => 1_048_576],
    ];
}
```

<br>

The model has several validation rules.

- Rule `required` - mandatory field to be filled in. `'required' => true`
- Rule `int` - the field must be a number. `'int' => true`
- Rule `min` - minimum number of characters. `'min' => 6`
- Rule `max` - maximum number of characters. `'max' => 100`
- Rule `email` - the field must be of email type. `'email' => true`
- Rule `unique` - the field value must not occur in the table. `'unique' => 'users:email'`
- Rule `file` - the field accepting files must be filled in. `'file' => true`
- Rule `ext` - allowed extensions for files. `'ext' => 'jpg|png'`
- Rule `size` - allowed file size. `'size' => 1_048_576`
- Rule `match` - the field must match another field by value. `'match' => 'password'`

<br>

1. Method `save`: The `save()` method saves the model data to the database and returns the id of the saved row.
```php
class User extends Model
{
  public function saveUser()
  {
      $id = $this->save();
  
      return $id;
  }
}
```
2. Method `update`: The `update()` method updates the data within the database. And returns the number of rows inside the table.
```php
class User extends Model
{
  public function update()
  {
      $rows = $this->update();
  
      return $rows;
  }
}
```
3. Method `loadData`: The `loadData()` method loads the model data. Mandatory method when creating a model.
```php
public function update()
{
    $model = new User();
    $model->loadData();
}
```
4. Method `delete`: The `delete($id)` method takes one argument - the id of the row to delete. Deletes the row from the database. And returns the number of rows inside the table.
```php
class User extends Model
{
  public function delete()
  {
      $id = $this->save();
      $rows = $this->delete($id);
  
      return $rows;
  }
}
```
5. Method `validate`: The `validate($data = [], $rules = [])` method takes two arguments: `$data` is an array of validated data, `$rules` is an array of validation rules. By default, both parameters are equal to empty arrays. Returns true in case of successful validation and false in case of error.
```php
class User extends Model
{
  public function validate()
  {
      $model->validate($model->attributes, [
          'title' => ['required' => true, 'max' => 255],
          'slug' => ['required' => true, 'max' => 255, 'unique' => 'tags:slug,id']
      ])
  }
}
```
6. Method `getErrors`: The `getErrors()` method returns an array of errors.
7. Method `hasErrors`: The `hasErrors()` method checks for errors.
8. Method `listErrors`: The `listErrors()` method renders a list of errors.

<br>
<br>

### Methods of Pagination

The Pagination class outputs us pagination and is based on bootstrap classes. If you use your own custom styles - feel free to modify the source code of the styles.

<br>

When you create a class, you are required to enter three parameters:
1. $page - valid page.
2. $per_page - number of entities on one page.
3. $total - total number of entities.
<br>
Example of creating pagination.
```php
public function index()
{
  $page = (int)request()->get('page', 1);
  $total = db()->query("SELECT COUNT(*) FROM $tbl WHERE $param = ?", [$value])->getColumn();
  $per_page = 5;
  $pagination = new Pagination($page, $per_page, $total);
  $start = $pagination->getStart();
}
```

<br>

1. Method `getStart`: The `getStart()` method returns the line number that starts the list of entities displayed on the page.
```php
public function index()
{
    $pagination = new Pagination($page, $per_page, $total);
    $start = $pagination->getStart();
}
```
2. Method `getHtml`: The `getHtml()` method returns the basic bootstrap page number markup.
```php
<?php echo $pagination->getHtml(); ?>
```
 - For more convenient rendering of markup I suggest to use the following construction:
   ```php
   <?php if ($pagination->count_pages >= 2) : ?>
       <div class="text-start py-4">
           <div class="custom-pagination">
               <?= $pagination ?>
           </div>
       </div>
   <?php endif; ?>
   ```
3. Method `__toString`: The `__toString()` method converts the result returned by the `getHtml()` method into a string.

<br>

The Pagination class has several variables that you can use, or modify.
- $count_pages - number of pages.
- $current_page - the number of the current page.
- $uri - page url.
- $max_pages - the maximum number of pages at which each page number is displayed in pagination.

<br>
<br>

### Methods of Request

1. Method `getPath`: The `getPath()` method returns the url address of the current page.
```php
public function index()
{
    $path = request()->getPath();
}
```
2. Method `isGet`: The `isGet()` method checks if the request method was get. It returns `true` if there was a get request and `false` otherwise.
```php
public function index()
{
    $request_data = request()->isGet() ? $_GET : $_POST;
}
```
3. Method `isPost`: The `isPost()` method checks if the request method was post. It returns `true` if there was a post request and `false` otherwise.
```php
public function index()
{
    $request_data = request()->isPost() ? $_POST : $_GET;
}
```
4. Method `get`: The `get($name, $default = null)` method returns the query data for the `$name` key, if there is no data it returns the default value `$default`. The query itself must be of get type.
```php
public function pagination()
{
    $page = (int)request()->get('page', 1);
}
```
5. Method `post`: The `post($name, $default = null)` method returns the query data for the `$name` key, if there is no data it returns the default value `$default`. The query itself must be of post type.
```php
public function user()
{
    $nickname = request()->post('nickname', '');
}
```
6. Method `post`: The `post($name, $default = null)` method returns the query data for the `$name` key, if there is no data it returns the default value `$default`. The query itself must be of post type.
```php
public function user()
{
    $nickname = request()->post('nickname', '');
}
```
7. Method `getData`: The `getData()` method returns the request data as an array, where the key-value pair matches the global array `$_GET` or `$_POST`, depending on the type of request passed to the page.
```php
public function data()
{
    $request_data = request()->getData();
}
```

<br>
<br>

### Methods of Response

The Response class has two important methods.

1. Method `setResponceCode`: The `setResponceCode($code)` method sets the response code from the server to the one you pass to it as an argument.
```php
public function responce()
{
    $error_404 = app()->responce->setResponceCode(404);
}
```
2. Method `redirect`: The `redirect($url = '')` method redirects the user to the page you pass as an argument.
```php
public function redirect()
{
    $main_page = app()->responce->redirect('/');
}
```

<br>
<br>

### Methods of Router

1. Method `getRoutes`: The `getRoutes()` method returns all routes existing in the application.
```php
public function router()
{
    $routes = app()->router->getRoutes();
}
```
2. Method `add`: The `add($uri, $callback, $method)` method allows your route to be processed by both the post method and the get method. The parameters passed are the url address of the route, the callback processing the route and the request method, or an array of methods.
```php
$app = new \PHPFramework\Application();
$app->router->add('/register', [\App\Controllers\UserController::class, 'register'], ['get', 'post'])
```
3. Method `get`: The `get($uri, $callback)` method allows your route to be processed by the get method. The url address of the route is passed as parameters, callback processing this route.
```php
$app = new \PHPFramework\Application();
$app->router->get('/logout', [\App\Controllers\UserController::class, 'logout'])
```
4. Method `post`: The `post($uri, $callback)` method allows your route to be processed by the post method. The url address of the route is passed as parameters, callback processing this route.
```php
$app = new \PHPFramework\Application();
$app->router->post('/comment/store', [\App\Controllers\CommentController::class, 'store'])
```
5. Method `only`: The `only($middleware)` method allows your route to be available only to a specific type of user.
```php
$app = new \PHPFramework\Application();
$app->router->add('/register', [\App\Controllers\UserController::class, 'register'], ['get', 'post'])->only('guest');
```

<br>
<br>

### Methods of Session

1. Method `setFlash`: The `setFlash($key, $value)` method sets the warning, which is subsequently rendered using standard bootstrap markup.
```php
session()->setFlash('success', 'You have successfully registered.');
```
2. Method `getFlash`: The `getFlash($key)` method allows you to get the value set in the session under a specific key. It removes this value from the session.
```php
$error_message = session()->getFlash('error');
```
3. Method `set`: The `set($key, $value)` method sets a key-value pair to the global array `$_SESSION`.
```php
session()->set('user', $user_data);
```
4. Method `get`: The `get($key, $default = null)` method returns the value set to the global array `$_SESSION` under a specific key. If the value was not found - returns the parameter `$default`.
```php
session()->get('user');
```
5. Method `has`: The `has($key)` method checks if the global array `$_SESSION` is set to a value under the key `$key`.
```php
if (session()->has('user') {
  $user_name = session()->get('user')['name'];
}
```
6. Method `forget`: The `forget($key)` method removes a `$key` value from the `$_SESSION` global array.
```php
if (session()->has('user') {
  session()->forget('user');
}
```

<br>
<br>

### Methods of View

1. Method `render`: The `render($view, $data = [], $layout = '')` method renders the view and passes data to it. A third optional argument can be passed as a template. The third argument is initially defined as default and renders a file named default.php.
```php
public function index()
{
  return app()->view->render('users/register', ['title' => 'Register'])
}
```
2. Method `renderPartial`: The `renderPartial($view, $data = [])` method renders only part of the view without reloading the entire page. It also takes in the data that is passed into the view.
```php
<?= app()->view->renderPartial('incs/header', ['title' => $title]); ?>
```

<br>
<hr>
<br>

## Helpers functions

<br>

- Function `view()`: Simplifies the work with the method `render` method of the `View` class. Takes the same arguments as the `render` method.
```php
public function index()
{
  return view('users/register', ['title' => 'Register']);
}
```
- Function `request()`: Allows you not to create a copy of the `Request` class, but to use a convenience function that returns that very copy.
```php
$page = request()->get('page', 1)
```
- Function `response()`: Simplifies the work with the method `setResponceCode` method of the `Response` class. Takes the same arguments as the `setResponceCode` method.
```php
public function index()
{
  return response(404);
}
```
- Function `router()`: Allows you not to create a copy of the `Router` class, but to use a convenience function that returns that very copy.
```php
router()->get('/logout', [\App\Controllers\UserController::class, 'logout'])
```
- Function `redirect()`: Simplifies the work with the method `redirect` method of the `Response` class. Takes the same arguments as the `redirect` method.
```php
public function index()
{
  redirect('/');
}
```
- Function `db()`: Allows you not to create a copy of the `Database` class, but to use a convenience function that returns that very copy.
```php
public function index()
{
  db()->query("UPDATE posts SET views = views + 1 WHERE slug = ?", [$slug]);
}
```
- Function `base_url($path = '')`: Returns the url address as a string with the value passed into it. The output is a full address of the following type: www.yoursite.com/`$path`
```php
<a href="<?= base_url("/register"); ?>">
```
- Function `html($str)`: A shortened version of the standard `htmlspecialchars` function.
- Function `old($fieldname)`: Useful for working with forms. Inserts the previous entered value into the field in case validation was not passed.
```php
<input type="text" name="name"
       class="form-control <?= get_validation_class('name', $errors ?? []); ?>" id="name"
       placeholder="Your Name" value="<?= old('name'); ?>">
```
- Function `oldfFromSession($arr, $fieldname)`: If the form values are written to the `$_SESSION` global array as an array, this function will help to retrieve the previous entered value from there.
```php
class PostController extends BaseController
{
  public function store()
  {
      // Some code

      if (!$model->validate()) {
          session()->set('form_data', $model->attributes);
          session()->set('form_errors', $model->getErrors());
          session()->setFlash('error', 'Validation Error');
          redirect(base_url('/admin/posts/create'));
      }

      // Some code
  }
}

...

<textarea id="content"
          name="content"
          class="form-control summernote <?= get_validation_class('content', $errors ?? []); ?>"
          rows="3"
          placeholder="Content">
          <?= oldfFromSession('form_data', 'content'); ?>
</textarea>
```
- Function `selected($arr, $fieldname, $value, $data = [])`: Function for processing the values selected in the form.
```php
<div class="col-md-6">
    <div class="form-group">
        <label>Select Tags</label>
        <select multiple name="tag_id[]" id="tag_id" class="form-control select2">
            <?php foreach ($tags as $tag) : ?>
                <option value="<?= $tag['id']; ?>" <?= selected('form_data', 'tag_id', $tag['id']); ?>><?= $tag['title']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
```
- Function `get_errors($fieldname, $errors = [])`: Output of validation errors.
```php
<div class="col-md-6">
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text"
               class="form-control <?= get_validation_class('title', $errors ?? []); ?>"
               name="title"
               id="title"
               placeholder="Enter your title"
               value="<?= oldfFromSession('form_data', 'title'); ?>">
        <?= get_errors('title', $errors ?? []); ?>
    </div>
</div>
```
- Function `get_validation_class($fieldname, $errors = [])`: Highlighting a field that has passed/failed validation by standard bootstrap markup.
```php
<div class="col-md-6">
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text"
               class="form-control <?= get_validation_class('title', $errors ?? []); ?>"
               name="title"
               id="title"
               placeholder="Enter your title"
               value="<?= oldfFromSession('form_data', 'title'); ?>">
        <?= get_errors('title', $errors ?? []); ?>
    </div>
</div>
```
- Function `abort($error = '', $code = 404)`: Call the error page passed as the second argument. By default the 404 page is called, which is inside the framework. It is possible to pass the error text as the first argument.
```php
public function Fail($result)
{
    if (!$result) {
        abort();
    }
    return $result;
}
```
- Function `session()`: Allows you not to create a copy of the `Session` class, but to use a convenience function that returns that very copy.
```php
session()->setFlash('success', 'Success message');
```
- Function `cache()`: Allows you not to create a copy of the `Cache` class, but to use a convenience function that returns that very copy.
```php
cache()->forget('user');
```
- Function `get_alerts()`: Renders the warnings recorded in the session.
```php
<main id="main">
    <section>
        <div class="container">
            <?= get_alerts() ?>
        </div>
    </section>
</main>
```
- Function `get_file_ext($file_name)`: Gets the extension of the file. Takes the full name of the file as an argument.
```php
$file_ext = (false === $i) ? get_file_ext($file['name']) : get_file_ext($file['name'][$i]);
```
- Function `upload_file($file, $i = false, $path = false)`: function takes three arguments.
The file name, the iteration number if you are uploading several files at once in a loop, the path to the file if it already exists. The function creates a new folder, if it doesn't exist yet, in the format year/month/day, where it puts your file with the hashed name. Returns false, or the domain path to the file.
```php
if ($image) {
    if ($file_url = upload_file($image)) {
        dump($file_url);
    }
}
```
- Function `check_auth()`: function checks if user data is written to the session. It returns a boolean value.
```php
 if (check_auth()) {
    session()->forget('user');
}
```
- Function `check_auth()`: function checks if user data is written to the session. It returns a boolean value.
```php
 if (check_auth()) {
    session()->forget('user');
}
```
- Function `send_mail(array $to, string $subject, string $body, array $attachments = [])`: function sends an email. It works on the basis of PHPMailer.

<br>
<hr>
<br>

## Note

It is also worth noting that this technology works with other libraries such as: phpmailer and symfony/var-dumper. The former allows you to work with e-mail conveniently, and the latter is used for debugging.
