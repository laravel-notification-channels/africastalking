# AfricasTalking notification channel for Laravel


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
composer require ossycodes/africastalking-laravel-notification-channel
```

The service provider gets loaded automatically.

### Setting up the AfricasTalking service

You will need to [Register](https://account.africastalking.com/auth/register/) and then go to your sandbox app [Go To SandBox App](https://account.africastalking.com/apps/sandbox). [Click on settings](https://account.africastalking.com/apps/sandbox/settings/key) Within this page, you will generate your `Username and key`. Place them inside your `.env` file. To load them, add this to your `config/services.php` file:

```php
'africastalking' => [
    'username'    => env('USERNAME'),
    'key' => env('KEY'),
]
```


This will load the AfricasTalking  data from the `.env` file. Make sure to use the same keys you have used there like `USERNAME`.


Add the ```routeNotifcationForAfricasTalking``` method on your notifiable Model. If this is not added,
the ```phone_number``` field will be automatically used.  

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
        return $this->phone;
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
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## How do I say Thank you?

Leave a star and follow me on [Twitter](https://twitter.com/ossycodes) .