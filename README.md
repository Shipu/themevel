
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

