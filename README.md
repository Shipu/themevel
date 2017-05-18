
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
- [getThemeInfo](https://github.com/shipu/themevel#getThemeInfo)
- [assets](https://github.com/shipu/themevel#assets)



## Support for this project
Hey dude! Help me out for a couple of :beers:!

[![Beerpay](https://beerpay.io/nahid/talk/badge.svg?style=beer-square)](https://beerpay.io/nahid/talk)  [![Beerpay](https://beerpay.io/nahid/talk/make-wish.svg?style=flat-square)](https://beerpay.io/nahid/talk?focus=wish)

