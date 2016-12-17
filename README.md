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


# Setup Notes
* publish config file
