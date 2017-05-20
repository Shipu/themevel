
### Features

* Add multiple theme support
* Child theme support
* Parent Asset finding support
* Translator support

### Installation

Themevel is a Larravel package so you can install it via composer. Run this command in your terminal from your project directory.

```
composer require shipu/themevel
```

Wait for a while, Composer will automatically install Talk in your project.

### Configuration

When the download is complete, you have to call this package service in `config/app.php` config file. To do that, add this line in `app.php` in `providers` section

```php
Shipu\Themevel\Providers\ThemevelServiceProvider::class,
```

To use facade you have to add this line in `app.php` in `aliases` array

```php
'Theme' => Shipu\Themevel\Facades\Theme::class,
```

Now run this command in your terminal to publish this package resources

```
php artisan vendor:publish --provider="Shipu\Themevel\Providers\ThemevelServiceProvider"
```
 Please see the API Doc.

### API List


- [set](https://github.com/shipu/themevel#set)
- [get](https://github.com/shipu/themevel#get)
- [current](https://github.com/shipu/themevel#current)
- [all](https://github.com/shipu/themevel#all)
- [has](https://github.com/shipu/themevel#has)
- [lang](https://github.com/shipu/themevel#lang)
- [getThemeInfo](https://github.com/shipu/themevel#getThemeInfo)
- [assets](https://github.com/shipu/themevel#assets)

### Route

```
Route::get('/', function () {
    Theme::set('your_themen_name');
    return view('welcome');
});
```
### 'theme' RouteMiddleware
A helper middleware is included out of the box if you want to define a Theme per route. To use it:

First register it in app\Http\Kernel.php:

```
protected $routeMiddleware = [
    // ...
    'theme' => \Shipu\Themevel\Middleware\RouteMiddleware::class,
];
```
Now you can apply the middleware to a route or route-group. Eg:
```
Route::group(['prefix' => 'admin', 'middleware'=>'setTheme:ADMIN_THEME'], function() {
    // ... Add your routes here 
    // The ADMIN_THEME will be applied.
});
```

### WebMiddleware
A helper middleware is included out of the box if you want to define a Theme per route. To use it:

First register it in app\Http\Kernel.php:

```
protected $middlewareGroups = [
    'web' => [
        // ...
        \Shipu\Themevel\Middleware\WebMiddleware::class,
    ],
    // ...
];
```

## Support for this project
Hey dude! Help me out for a couple of :beers:!

[![Beerpay](https://beerpay.io/nahid/talk/badge.svg?style=beer-square)](https://beerpay.io/nahid/talk)  [![Beerpay](https://beerpay.io/nahid/talk/make-wish.svg?style=flat-square)](https://beerpay.io/nahid/talk?focus=wish)


## Support on Beerpay
Hey dude! Help me out for a couple of :beers:!

[![Beerpay](https://beerpay.io/Shipu/themevel/badge.svg?style=beer-square)](https://beerpay.io/Shipu/themevel)  [![Beerpay](https://beerpay.io/Shipu/themevel/make-wish.svg?style=flat-square)](https://beerpay.io/Shipu/themevel?focus=wish)