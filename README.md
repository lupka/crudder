### This is still under development, DO NOT USE IN PRODUCTION

# Crudder

[![[]()icense](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat)](LICENSE)

## Installation

### 1: Install via Composer
```
composer require lupka/crudder
```

### 2: Add Service Provider

Add the new provider to the `providers` array of `config/app.php`:
```
'providers' => [
    // ...
    Lupka\Crudder\CrudderServiceProvider::class,
    // ...
],
```

### 3: Add Facade
Add the new Crudder alias to the `aliases` array of `config/app.php`:
```
'aliases' => [
    // ...
    'Crudder' => Lupka\Crudder\CrudderFacade::class,
    // ...
],
```

### 4: Add routes
Add a call to `Crudder::routes()` wherever you want within your routes file. The example below uses a route group with a prefix and auth middleware:
```
Route::group(['prefix' => 'crudder', 'middleware' => 'auth'], function(){
    Crudder::routes();
});
```

### 5: Publish config file
Publish the Crudder config file by running the following command:
```
php artisan vendor:publish --tag=config
```

## Configuration

### Basic Setup
All you need to do to get started is enter the class name of the Eloquent Model you want to have an admin for in the `crudder.php` config file.
```
    'models' => [
        'App\BlogPost' => []    
    ]
```    
Crudder will use a basic form based on the field types in your database.

## Tips
If you want to modify values programmatically before/after saving, I recommend using observers: https://laravel.com/docs/5.3/eloquent#observers
