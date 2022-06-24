<p align="center">
    <a href="https://laravel.com"><img alt="Laravel v8.x" src="https://img.shields.io/badge/Laravel-v8.x-FF2D20?style=for-the-badge&logo=laravel"></a>
    <a href="https://laravel-livewire.com"><img alt="Livewire v2.x" src="https://img.shields.io/badge/Livewire-v2.x-FB70A9?style=for-the-badge"></a>
    <a href="https://php.net"><img alt="PHP 8.0" src="https://img.shields.io/badge/PHP-8.0-777BB4?style=for-the-badge&logo=php"></a>
</p>

Main repository for OpenSynergic.

## Packages

### Core

```bash
composer require opensynergic/core
```

### Plugins Manager

```bash
composer require opensynergic/plugins-manager
```

### Themes Manager

```bash
composer require opensynergic/themes-manager
```

## Contributing

If you want to contribute to this packages, you may want to test it in a real Laravel project:

- Fork this repository to your GitHub account.
- Create a Laravel app locally.
- Clone your fork in your Laravel app's root directory.
- In the `/opensynergic` directory, create a branch for your fix, e.g. `fix/error-message`.

Install the packages in your app's `composer.json`:

```json
{
    ...
    "require": {
        "opensynergic/core": "dev-fix/error-message as 2.x-dev",
    },
    "repositories": [
        {
            "type": "path",
            "url": "opensynergic/packages/*"
        }
    ],
    ...
}
```

## Credits

- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
