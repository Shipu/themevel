
### Features

* Theme

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

After running this command, all necessary file will be included in your project. This package has two default migrations. So you have to run migrate command like this. (But make sure your database configuration is configured correctly.)

```shell
php artisan migrate
```

Okay, now you need to configure your user model for Talk. Go to `config/talk.php` and config it.

```php
return [
    'user' => [
        'model' => 'App\User'
    ],
    'broadcast' => [
        'enable' => false,
        'app_name' => 'your-app-name',
        'pusher' => [
            'app_id'        => '',
            'app_key'       => '',
            'app_secret'    => '',
            'options' => [
                 'cluster' => 'ap1',
                 'encrypted' => true
            ]
        ]
    ]
];
```


### Usage

Its very easy to use. If you want to set authenticate user id globally then you have to set a middleware first. Go to `app/Http/Kernel.php` and set it in `$routeMiddleware` array

 ```php
 'talk'  =>  \Nahid\Talk\Middleware\TalkMiddleware::class,
 ```
 And now you can use it from anywhere with middleware. Suppose you have a Controller and you want to set authenticate user id globally then write this in controller constructor
 
 ```php
 $this->middleware('talk');
 ```
 
But instead of set id globally you can use these procedure from any method in controller.

```php
Talk::setAuthUserId(auth()->user()->id);
```

Now you may use any method what you need. But if want pass authentic id instantly, this method may help you.

```php
Talk::user(auth()->user()->id)->anyMethodHere();
```
 Please see the API Doc.

### API List


- [setAuthUserId](https://github.com/nahid/talk#setauthuserid)
- [user](https://github.com/nahid/talk#user)
- [isConversationExists](https://github.com/nahid/talk#isconversationexists)
- [isAuthenticUser](https://github.com/nahid/talk#isauthenticuser)
- [sendMessage](https://github.com/nahid/talk#sendmessage)
- [sendMessageByUserId](https://github.com/nahid/talk#sendmessagebyuserid)
- [getInbox](https://github.com/nahid/talk#getinbox)
- [getInboxAll](https://github.com/nahid/talk#getinboxAll)
- [threads](https://github.com/nahid/talk#threads)
- [threadsAll](https://github.com/nahid/talk#threadsall)
- [getConversationsById](https://github.com/nahid/talk#getconversationbyid)
- [getConversationsAllById](https://github.com/nahid/talk#getconversationallbyid)
- [getConversationsByUserId](https://github.com/nahid/talk#getconversationbyuserid)
- [getConversationsAllByUserId](https://github.com/nahid/talk#getconversationallbyuserid)
- [getMessages](https://github.com/nahid/talk#getmessages)
- [getMessagesByUserId](https://github.com/nahid/talk#getmessagesbyuserid)
- [getMessagesAll](https://github.com/nahid/talk#getmessagesall)
- [getMessagesAllByUserId](https://github.com/nahid/talk#getmessagesallbyuserid)
- [readMessage](https://github.com/nahid/talk#readmessage)
- [makeSeen](https://github.com/nahid/talk#makeseen)
- [getReceiverInfo](https://github.com/nahid/talk#getreceiverinfo)
- [deleteMessage](https://github.com/nahid/talk#deletemessage)
- [deleteForever](https://github.com/nahid/talk#deleteforever)
- [deleteConversations](https://github.com/nahid/talk#deleteconversations)





## Support for this project
Hey dude! Help me out for a couple of :beers:!

[![Beerpay](https://beerpay.io/nahid/talk/badge.svg?style=beer-square)](https://beerpay.io/nahid/talk)  [![Beerpay](https://beerpay.io/nahid/talk/make-wish.svg?style=flat-square)](https://beerpay.io/nahid/talk?focus=wish)

