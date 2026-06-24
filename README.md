# Panelis Module

Manage installed Panelis modules and packages from the admin panel.

## Features

* View installed Panelis modules
* Display package information and descriptions
* Display installed package versions
* Display package dependencies
* Composer-based module discovery
* Automatic Panelis plugin discovery

## Requirements

* PHP 8.3+
* Laravel 13+
* Filament 5+

## Installation

Install the package via Composer:

```bash
composer require panelis-php/module
```

Run migrations:

```bash
php artisan migrate
```

## Usage

After installation, a **Modules** menu will be available in the Panelis admin panel.

The module manager automatically discovers installed Panelis packages through Composer metadata and displays information about each module.

Available information includes:

* Package name
* Description
* Version
* Dependencies

Example:

```text
Translation
Package: panelis-php/translation
Version: 1.0.0

Manage application translations directly from the admin panel.
```

## Module Discovery

Panelis modules are discovered automatically from Composer packages that define the `panelis` configuration inside their `composer.json` file.

Example:

```json
{
    "name": "panelis-php/translation",
    "extra": {
        "panelis": {
            "plugins": [
                "Panelis\\Translation\\Plugins\\TranslationPlugin"
            ]
        }
    }
}
```

Installed modules are automatically registered and displayed in the module manager.

## Creating a Module

A Panelis module is a standard Composer package that provides one or more Panelis plugins.

Example:

```json
{
    "name": "panelis-php/example",
    "description": "Example Panelis module",
    "extra": {
        "laravel": {
          "providers": [
            "Panelis\\Example\\Providers\\ExampleServiceProvider"
          ]
        },
        "panelis": {
            "plugins": [
                "Panelis\\Example\\Plugins\\ExamplePlugin"
            ]
        }
    }
}
```

Once installed, the module will be discovered automatically without additional configuration.

## License

The MIT License (MIT).
