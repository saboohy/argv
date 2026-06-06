# Argv

Argv is a lightweight PHP library for parsing command-line arguments (`$argv`). It provides a simple API for extracting commands, options, flags, and arguments from CLI input.


## Features

* Parse commands from CLI input
* Extract options and flags
* Access positional arguments easily
* Simple and intuitive API
* Zero dependencies
* PHP 8.2+ compatible

## Requirements

* PHP 8.2+
* Composer

## Installation

Install the package via Composer:

```
composer require saboohy/argv
```

## Quick Start

```php
<?php

use Saboohy\Argv\Input;

$input = new Input($argv);

print_r($input->getOptions());
print_r($input->getCommand());
print_r($input->getFlags());
print_r($input->getArguments());
```

## License

This project is licensed under the MIT License.

## Support

If you have any questions, issues, or feature requests, please open an issue on GitHub.