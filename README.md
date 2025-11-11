# PHP TOON

Token-Oriented Object Notation (TOON) for PHP

## Requirements
- PHP ^8.0

## Installation & Usage

Install via Composer:

```bash
$ composer require matmper/php-toon
```

Import the package:
```php
use Matmper\PhpToon;
```

### Toon Encode
```php
PhpToon::encode([
    ['id' => 1, 'name' => 'User 1', 'age' => 20],
    ['id' => 2, 'name' => 'User 2', 'age' => 30],
], 'users');
```

Output:
```text
users[2]{id,name,age}:
    1,User 1,20
    2,User 2,30
```

### Toon Decode
```php
$toon = "users[2]{id,name,age}:
    1,User 1,20
    2,User 2,30";

PhpToon::decode($toon, true);   // returns associative array (default)
PhpToon::decode($toon, false);  // returns stdClass object
```

Output:
```text
Array
(
    [0] => Array
        (
            [id] => 1
            [name] => User 1
            [age] => 20
        )

    [1] => Array
        (
            [id] => 2
            [name] => User 2
            [age] => 30
        )
)
```

---

## Contribution & Development

This project is open source and contributions are welcome.
All pull requests must pass tests and follow the code style standards.

To set up your local environment:
```bash
$ composer install --dev --prefer-dist
```
