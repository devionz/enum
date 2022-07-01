# Simple enum implementation for PHP prior to 8.1

## Installation

```
composer require devionz/enum
```

## Declaration

```php
use Devionz\Enum;

class Status extends Enum
{
    private const DRAFT = 'draft';
    private const PUBLISHED = 'published';
    private const PENDING = 'pending';
}
```

## Examples

```php
$enum1 = Status::DRAFT();
$enum2 = Status::from('draft');
$enum3 = Status::tryFrom('draft');

echo $enum1->name; // 'draft'
echo $enum1->value // 'DRAFT'

var_dump($enum1 === $enum2); // Returns true
```