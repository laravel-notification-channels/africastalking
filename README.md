# AfricasTalking notification channel for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/laravel-notification-channels/africastalking.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/africastalking)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![StyleCI](https://styleci.io/repos/247548130/shield)](https://styleci.io/repos/209406724)
[![Quality Score](https://img.shields.io/scrutinizer/g/laravel-notification-channels/africastalking.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/africastalking)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel-notification-channels/africastalking.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/africastalking)

This package makes it easy to send notifications using [AfricasTalking](https://build.at-labs.io/docs/sms%2Fsending) with Laravel.

## Contents

- [About](#about)
- [Installation](#installation)
- [Setting up the AfricasTalking service](#setting-up-the-africastalking-service)
- [Usage](#usage)
- [Testing](#testing)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)

## About

This package is part of the [Laravel Notification Channels](http://laravel-notification-channels.com/) project. It provides additional Laravel Notification channels to the ones given by [Laravel](https://laravel.com/docs/master/notifications) itself.

The AfricasTalking channel makes it possible to send out Laravel notifications as a `SMS ` using AfricasTalking API.

## Installation

You can install this package via composer:

``` bash
composer require laravel-notification-channels/africastalking
```

The service provider gets loaded automatically.

### Setting up the AfricasTalking service

You will need to [Register](https://account.africastalking.com/auth/register/) and then go to your sandbox app [Go To SandBox App](https://account.africastalking.com/apps/sandbox). [Click on settings](https://account.africastalking.com/apps/sandbox/settings/key) Within this page, you will generate your `Username and key`. Place them inside your `.env` file. Remember to add your Sender ID that you will be using to send the messages. 

**Please note if you do not have a VALID sender_ID remove "AT_FROM" from your .env or leave it as ""**


```bash
AT_USERNAME=""
AT_KEY=""
AT_FROM="" // please note if you do not have a valid sender_ID remove this or leave it as ""
```

To load them, add this to your `config/services.php` . This will load the AfricasTalking  data from the `.env` file.file:

```php
'africastalking' => [
    'username'      => env('AT_USERNAME'),
    'key'           => env('AT_KEY'),
    'from'          => env('AT_FROM'),
]
```

Add the `routeNotifcationForAfricasTalking` method on your notifiable Model. If this is not added,
the `phone_number` field will be automatically used.  

```php
<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * Route notifications for the Africas Talking channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return string
     */
    public function routeNotificationForAfricasTalking($notification)
    {
        return $this->phone_number;
    }
}
```


## Usage


To use this package, you need to create a notification class, like `NewsWasPublished` from the example below, in your Laravel application. Make sure to check out [Laravel's documentation](https://laravel.com/docs/master/notifications) for this process.


```php
<?php

use NotificationChannels\AfricasTalking\AfricasTalkingChannel;
use NotificationChannels\AfricasTalking\AfricasTalkingMessage;

class NewsWasPublished extends Notification
{

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [AfricasTalkingChannel::class];
    }

    public function toAfricasTalking($notifiable)
    {
		return (new AfricasTalkingMessage())
                    ->content('Your SMS message content');

    }
}
```
You can also modify who the notification(SMS) is sent from, this will overide the AT_FROM= in your .env
**Please only do this if you have a VALID sender_ID**

``` php
        return (new AfricasTalkingMessage())
                    ->content('Your SMS message content')
                    ->from("set any sender id/name here");
```

You can also modify who the notification(SMS) is sent to (the recipient)

``` php
        return (new AfricasTalkingMessage())
                    ->content('Your SMS message content')
                    ->to("put the recipient phonenumber here"); //eg ->to(1111111111)
```
It's important to know the Order in which the recipient phone number the notification(SMS) will be sent to will be used

1) If you have defined the routeNotificationForAfricasTalking() method on the Notifiable class (User.php in this case) and returned a valid phone number, then that will be used.

2) if you did not define routeNotificationForAfricasTalking() method on the Notifiable class (User.php in this case), then the phone_number attribute of the User will be used ($user->phone_number)

3) Lastly if the recipient phone number is set using ->to(1111111), this will overide the phone number provided in either 1 or 2.

``` php
        return (new AfricasTalkingMessage())
                    ->content('Your SMS message content')
                    ->to("put the recipient phonenumber here"); //eg ->to(11111111)
```

## Testing

``` bash
$ composer test
```

## Security

If you discover any security-related issues, please email osaigbovoemmanuel1@gmail.com instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Osaigbovo Emmanuel](https://github.com/ossycodes)
- [Osen Concepts](https://github.com/osenco)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## How do I say Thank you?

Please buy me a cup of coffee https://www.paypal.com/paypalme/osaigbovoemmanuel , Leave a star and follow me on [Twitter](https://twitter.com/ossycodes) .
