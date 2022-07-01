# Simple enum implementation for PHP prior to 8.1

## Installation

```
composer require devionz/enum
```

## Declaration

```php
use Devionz\Enum\Enum;

class Status extends Enum
{
    private const DRAFT = 'draft';
    private const PUBLISHED = 'published';
    private const PENDING = 'pending';
}
```

## Examples

```php

function getValue(Status $status) {
    return $status->value;
}

$enum1 = Status::DRAFT();
$enum2 = Status::from('draft');
$enum3 = Status::tryFrom('draft');

echo $enum1->name; // 'DRAFT'
echo $enum1->value // 'draft'
echo getValue($enum1); // 'draft

var_dump($enum1 === $enum2); // Returns true
```