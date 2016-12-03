# Laravel Taggable

## Installation

Require this package, with [Composer](https://getcomposer.org/), in the root directory of your project.

``` bash
$ composer require faustbrian/laravel-taggable
```

And then include the service provider within `app/config/app.php`.

``` php
BrianFaust\Taggable\TaggableServiceProvider::class
```

### Migration

To get started, you'll need to publish all vendor assets:

```bash
$ php artisan vendor:publish --provider="BrianFaust\Taggable\TaggableServiceProvider"
```

And then run the migrations to setup the database table.

```bash
$ php artisan migrate
```

### Configuration

Taggable supports optional configuration.

To get started, you'll need to publish all vendor assets:

```bash
$ php artisan vendor:publish --provider="BrianFaust\Taggable\ServiceProvider"
```

This will create a `config/taggable.php` file in your app that you can modify to set your configuration. Also, make sure you check for changes to the original config file in this package between releases.

## Usage

##### Setup a Model

``` php
<?php

namespace App;

use BrianFaust\Taggable\HasTagsTrait;
use BrianFaust\Taggable\Interfaces\HasTags;
use Illuminate\Database\Eloquent\Model;

class Post extends Model implements HasTags
{
    use HasTagsTrait;

    protected $onlyUseExistingTags = false;
}
```

##### Add a tag to a model

``` php
$model->tag('Apple,Banana,Cherry');
$model->tag(['Apple', 'Banana', 'Cherry']);
```

##### Remove specific tags

``` php
$model->untag('Banana');
```

##### Remove all tags

``` php
$model->detag();
```

##### Remove all assigned tags and assign the new ones

``` php
$model->retag('Etrog,Fig,Grape');
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ phpunit
```

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security

If you discover a security vulnerability within this package, please send an e-mail to Brian Faust at hello@brianfaust.de. All security vulnerabilities will be promptly addressed.

## Credits

- [Brian Faust](https://github.com/faustbrian)
- [All Contributors](../../contributors)

## License

[MIT](LICENSE) © [Brian Faust](https://brianfaust.de)
