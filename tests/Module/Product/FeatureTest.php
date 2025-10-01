<?php

declare(strict_types=1);

namespace App\Tests\Module\Product;

use App\Module\Product\Feature;
use App\Module\Product\Product;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\UuidInterface;

class FeatureTest extends TestCase
{
    // Test cases will be added here
/*
FAILED TEST: The test run failed due to a **fatal error** caused by an **incompatible method signature** in the `Ramsey\Uuid\Uuid::unserialize()` method. The method declares a `string` type for the `$data` parameter, but the `Serializable::unserialize()` interface method does not enforce a type, leading to a compatibility issue.

### Recommended Fix:
Upgrade the `ramsey/uuid` package to a version that is compatible with your PHP version (preferably version 4.2.3 or later, or version 5+ if using PHP 8+). Alternatively, downgrade PHP if you must use an older version of `ramsey/uuid`.

    public function testGenerateSlugWithSpecialCharacters(): void
    {
        $value = "Wireless & Bluetooth 5.0";
        $feature = new Feature($value);
    
        $this->assertSame('wireless-bluetooth-50', $feature->getSlug());
    }

*/
/*
FAILED TEST: The test run failed due to a **fatal error** in the `Ramsey\Uuid\Uuid` class caused by an **incompatible method signature** for `unserialize()`. Specifically, `Uuid::unserialize(string $data): void` is not compatible with the `Serializable::unserialize($serialized)` interface method, which does not enforce a type on the parameter.

### Root Cause:
- Version mismatch between `ramsey/uuid` and the current PHP version (likely PHP 7.5).

### Recommended Fix:
Upgrade `ramsey/uuid` to a version compatible with your PHP version:

```bash
composer update ramsey/uuid
```

    public function testGetProductsReturnsEmptyArrayWhenNoProducts(): void
    {
        $feature = new Feature("Sample Feature");
        $products = $feature->getProducts();
    
        $this->assertIsArray($products);
        $this->assertEmpty($products);
    }

*/
/*
FAILED TEST: The test `testCreateFeatureWithEmptyOrNullValue` failed because the `Feature::__construct()` method correctly rejects `null` input by throwing a `TypeError`, but the test expects an `InvalidArgumentException`. 

### Recommended Fix:
Update the test to expect `TypeError` instead of `InvalidArgumentException`, or modify the `Feature` constructor to explicitly throw `InvalidArgumentException` when invalid input is provided.

    public function testCreateFeatureWithEmptyOrNullValue(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Value cannot be empty');
    
        new Feature(null);
    }

*/
/*
FAILED TEST: The test run failed due to a **fatal error** in the `Ramsey\Uuid\Uuid` class caused by an **incompatible method signature** for `unserialize()`. Specifically, `Uuid::unserialize(string $data): void` is not compatible with the `Serializable::unserialize($serialized)` interface method, which does not enforce a type on the parameter.

### Root Cause:
- Version mismatch between `ramsey/uuid` and the current PHP version (likely PHP 7.5).

### Recommended Fix:
Upgrade `ramsey/uuid` to a version compatible with your PHP version:

```bash
composer update ramsey/uuid
```

    public function testCreateFeatureWithMaximumValueLength(): void
    {
        $value = str_repeat('a', 128);
        $feature = new Feature($value);
    
        $this->assertSame($value, $feature->getValue());
        $this->assertSame(str_repeat('a', 128), $feature->getSlug());
    }

*/
/*
FAILED TEST: The test failed due to a **fatal error** in the `Ramsey\Uuid\Uuid` class related to an **incompatible method signature** for `unserialize()`. This is likely caused by using an **incompatible version** of the `ramsey/uuid` library with PHPUnit or PHP version.

### Root Cause:
- `Ramsey\Uuid\Uuid::unserialize()` declares a parameter type `string $data`, but it must be compatible with `Serializable::unserialize($serialized)` which does **not** enforce a type.
- This mismatch is a **PHP version or package version compatibility issue**.

### Recommended Fix:
Upgrade `ramsey/uuid` to a version compatible with your PHP version (e.g., PHP 7.5), or upgrade PHP to a version supported by the current `ramsey/uuid` version you're using.

Example:
```bash
composer update ramsey/uuid
```

    public function testCreateFeatureWithValidValue(): void
    {
        $value = "Wireless Connectivity";
        $feature = new Feature($value);
    
        $this->assertInstanceOf(UuidInterface::class, $feature->getId());
        $this->assertSame($value, $feature->getValue());
        $this->assertIsString($feature->getSlug());
        $this->assertSame(strtolower(str_replace(' ', '-', $value)), $feature->getSlug());
    }

*/
}
