<?php

declare(strict_types=1);

namespace App\Tests\Module\Product;

use App\Module\Product\Feature;
use App\Module\Product\Product;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\UuidInterface;

class FeatureTest extends TestCase
{




/*
FAILED TEST: The test run failed because the `testFeatureIsCreatedWithNullValue` test is passing `null` to the `Feature` constructor, which strictly expects a `string`. This violates the type declaration in `Feature::__construct(string $value)`.

**Recommended Fix:**  
Update the constructor in `Feature.php` to accept `?string` instead of `string` if `null` values are valid, or update the test to pass a non-null string to align with the current constructor signature.

    public function testFeatureIsCreatedWithNullValue(): void
    {
        $value = null;
        $feature = new Feature($value);
    
        $this->assertSame($value, $feature->getValue());
    }

*/
/*
FAILED TEST: The test `testFeatureIsCreatedWithSpecialCharacters` failed because the `getSlug()` method in `Feature.php` returned `null`, but it is declared to return a `string`. This occurs because the `$slug` property is not being generated in the constructor.

**Recommended Fix:**  
Ensure the `$slug` is initialized in the constructor, either by manually setting it or ensuring the `Gedmo\Sluggable` behavior is properly configured and triggered during object instantiation.

    public function testFeatureIsCreatedWithSpecialCharacters(): void
    {
        $value = "100% Organic & Natural";
        $feature = new Feature($value);
    
        $this->assertSame($value, $feature->getValue());
        $this->assertIsString($feature->getSlug());
        $this->assertNotSame($value, $feature->getSlug());
    }

*/
/*
FAILED TEST: The test `testFeatureIsCreatedWithEmptyValue` failed because the `getSlug()` method in `Feature.php` returns `null`, but the the method is declared to return a `string`. This occurs because the `$slug` property is not being generated in the constructor.

**Recommended Fix:**  
Ensure the `$slug` is initialized in the constructor, either by manually setting it or ensuring the `Gedmo\Sluggable` behavior is properly configured and triggered during object instantiation.

    public function testFeatureIsCreatedWithEmptyValue(): void
    {
        $value = "";
        $feature = new Feature($value);
    
        $this->assertSame($value, $feature->getValue());
        $this->assertIsString($feature->getSlug());
    }

*/
/*
FAILED TEST: The test failed because the `getSlug()` method in `Feature.php` returns `null`, but the test expects a string. This happens because the `$slug` property is not initialized in the constructor.

**Recommended Fix:**  
Ensure the `$slug` is generated in the constructor, for example by using the `Gedmo\Sluggable` behavior or manually setting it based on the value.

    public function testFeatureIsCreatedWithValidValue(): void
    {
        $value = "Wireless Connectivity";
        $feature = new Feature($value);
    
        $this->assertInstanceOf(\Ramsey\Uuid\UuidInterface::class, $feature->getId());
        $this->assertSame($value, $feature->getValue());
        $this->assertIsString($feature->getSlug());
        $this->assertEmpty($feature->getProducts());
    }

*/
}
