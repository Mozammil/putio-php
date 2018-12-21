# putio-php

PHP bindings to [Put.io](https://put.io)'s API.

## Install

Via Composer

``` bash
$ composer require mozammil/putio-php
```

## Access Token

This library assumes you already have an access token. If you don't, please read [this article](https://api.put.io/v2/docs/gettingstarted.html#authentication-and-access) on how to get one.

In case you are using the API for your own purposes, you can skip the steps mentioned in the article and [register an application](https://app.put.io/settings/account/oauth/apps/new) to get your own personal access token.

## Usage

``` php
$putio = new Mozammil\Putio\Putio('token');

// This will list all your files in your parent folder
$files = $putio->files()->list();

// This will list all your ongoing transfers
$transfers = $putio->transfers()->list();
```
Full documentation coming soon..

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, please email [hello@moz.im](hello@moz.im) instead of using the issue tracker.

## Credits

- [Mozammil Khodabacchas](https://twitter.com/mozammil_k)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
