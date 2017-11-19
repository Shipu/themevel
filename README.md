# Laravel-Themevel
[![Latest Stable Version](https://poser.pugx.org/shipu/themevel/v/stable)](https://packagist.org/packages/shipu/themevel)
[![Latest Unstable Version](https://poser.pugx.org/shipu/themevel/v/unstable)](https://packagist.org/packages/shipu/themevel)
[![License](https://poser.pugx.org/shipu/themevel/license)](https://packagist.org/packages/shipu/themevel)

Themevel is a Laravel 5 theme and asset management package. You can easily integrate this package with any Laravel based project.

### Features

* Custom theme location
* Parent theme support
* Unlimited Parent view finding
* Asset Finding
* Theme translator support
* Multiple theme config extension
* Multiple theme changelog extension
* Artisan console commands

## Installation

Themevel is a Laravel package so you can install it via Composer. Run this command in your terminal from your project directory:

```sh
composer require shipu/themevel
```

Wait for a while, Composer will automatically install Themevel in your project.

## Configuration

Below **Laravel 5.5** you have to call this package service in `config/app.php` config file. To do that, add this line in `app.php` in `providers` array:

```php
Shipu\Themevel\Providers\ThemevelServiceProvider::class,
```

Below **Laravel 5.5** version to use facade you have to add this line in `app.php` to the `aliases` array:

```php
'Theme' => Shipu\Themevel\Facades\Theme::class,
```

Now run this command in your terminal to publish this package resources:

```
php artisan vendor:publish --provider="Shipu\Themevel\Providers\ThemevelServiceProvider"
```

## Artisan Command
Run this command in your terminal from your project directory.

Create a theme directory:
```sh
php artisan theme:create your_theme_name


 What is theme title?:
 > 

 What is theme description? []:
 > 

 What is theme author name? []:
 >  

 What is theme version? []:
 > 

 Any parent theme? (yes/no) [no]:
 > y

 What is parent theme name?:
 > 

```
List of all themes:
```sh
php artisan theme:list

+----------+--------------+---------+----------+
| Name     | Author       | Version | Parent   |
+----------+--------------+---------+----------+
| themeone | Shipu Ahamed | 1.1.0   |          |
| themetwo | Shipu Ahamed | 1.0.0   | themeone |
+----------+--------------+---------+----------+
```

## Example folder structure:
```
- app/
- ..
- ..
- Themes/
    - themeone/
        - assets
            - css
                - app.css
            - img
            - js
        - lang
            - en
                -content.php
        - views/
            - layouts
                - master.blade.php
            - welcome.blade.php
        - changelog.yml        
        - theme.json
```
You can change `theme.json` and `changelog.yml` name from `config/theme.php`

```php
// ..
'config' => [
    'name' => 'theme.json',
    'changelog' => 'changelog.yml'
],
// ..
```

`json`, `yml`, `yaml`, `php`, `ini`, `xml` extension supported.  

For example:
```php
// ..
'config' => [
    'name' => 'theme.json',
    'changelog' => 'changelog.json'
],
// ..
```
Then run `theme:create` command which describe above.

Now Please see the API List Doc.

## API List
- [set](https://github.com/shipu/themevel#set)
- [get](https://github.com/shipu/themevel#get)
- [current](https://github.com/shipu/themevel#current)
- [all](https://github.com/shipu/themevel#all)
- [has](https://github.com/shipu/themevel#has)
- [getThemeInfo](https://github.com/shipu/themevel#getThemeInfo)
- [assets](https://github.com/shipu/themevel#assets)
- [lang](https://github.com/shipu/themevel#lang)

### set

For switching current theme you can use `set` method.

```php
Theme::set('theme-name');
```

### get

For getting current theme details you can use `get` method:

```php
Theme::get(); // return Array
```
You can also get particular theme details:
```php
Theme::get('theme-name'); // return Array
```

```php
Theme::get('theme-name', true); // return Collection
```

### current

Retrieve current theme's name:

```php
Theme::current(); // return string
```

### all

Retrieve all theme information:

```php
Theme::all(); // return Array
```

### has

For getting whether the theme exists or not:

```php
Theme::has(); // return bool
```

### getThemeInfo

For info about the specified theme:

```php
$themeInfo = Theme::getThemeInfo('theme-name'); // return Collection

$themeName = $themeInfo->get('name');
// or
$themeName = $themeInfo['name'];
```
Also fallback support:
```php
$themeInfo = Theme::getThemeInfo('theme-name'); // return Collection

$themeName = $themeInfo->get('changelog.versions');
// or
$themeName = $themeInfo['changelog.versions'];
// or you can also call like as multi dimension
$themeName = $themeInfo['changelog']['versions'];
```

### assets

For binding theme assets you can use the `assets` method:

```php
Theme::assets('your_asset_path'); // return string
```
It's generated at `BASE_URL/theme_roots/your_active_theme_name/assets/your_asset_path`

If `your_asset_path` does not exist then it's find to active theme immediate parent assets folder. Look like `BASE_URL/theme_roots/your_active_theme_parent_name/assets/your_asset_path`

When using helper you can also get assets path:
```php
themes('your_asset_path'); // return string
```

If you want to bind specific theme assets:
```php
Theme::assets('your_theme_name:your_asset_path'); // return string
// or 
themes('your_theme_name:your_asset_path'); // return string
```

**Suppose you want to bind `app.css` in your blade. Then below code can be applicable:**
```php
<link rel="stylesheet" href="{{ themes('app.css') }}">
```
Specific theme assets:
```php
<link rel="stylesheet" href="{{ themes('your_theme_name:app.css') }}">
```
### lang

The `lang` method translates the given language line using your current **theme** [localization files](https://laravel.com/docs/5.4/localization):
```php
echo Theme::lang('content.title'); // return string
// or
echo lang('content.title'); // return string
```
If you want to bind specific theme assets:
```php
echo Theme::lang('your_theme_name::your_asset_path'); // return string
// or 
echo lang('your_theme_name::your_asset_path'); // return string
```

## How to use in Route
```php
Route::get('/', function () {
    Theme::set('your_theme_name');
    return view('welcome');
});
```
_**This will firstly check if there is a welcome.blade.php in current theme directory. If none is found then it checks parent theme, and finally falls back to default Laravel views location.**_

If you want to specific theme view:
```php
Route::get('/', function () {
    Theme::set('your_theme_name');
    return view('your_theme_name::welcome');
});
```

## Set theme using route middleware
A helper middleware is included out of the box if you want to define a theme per route. To use it:

First register it in app\Http\Kernel.php:

```php
protected $routeMiddleware = [
    // ...
    'theme' => \Shipu\Themevel\Middleware\RouteMiddleware::class,
];
```
Now you can apply the middleware to a route or route-group. Eg:
```php
Route::group(['prefix' => 'admin', 'middleware'=>'theme:Your_theme_name'], function() {
    // ... Add your routes here 
    // The Your_theme_name will be applied.
});
```

## Set theme using web middleware
A helper middleware is included out of the box if you want to define a theme per route. To use it:

First register it in app\Http\Kernel.php:

```php
protected $middlewareGroups = [
    'web' => [
        // ...
        \Shipu\Themevel\Middleware\WebMiddleware::class,
    ],
    // ...
];
```
Theme set from `config/theme.php` .

### Dependency Injection
You can also inject theme instance using ThemeContract, eg:

``` php
use Shipu\Themevel\Contracts\ThemeContract;

private $theme;

public function __construct(ThemeContract $theme)
{
    $this->theme = $theme
}
```

## Credits

- [Shipu Ahamed](https://github.com/shipu)
- [All Contributors](../../contributors)

## Support for this project
Hey dude! Help me out for a couple of :beers:!

[![Beerpay](https://beerpay.io/Shipu/themevel/badge.svg?style=beer)](https://beerpay.io/Shipu/themevel) [![Beerpay](https://beerpay.io/Shipu/themevel/make-wish.svg?style=flat-square)](https://beerpay.io/Shipu/themevel?focus=wish) 
