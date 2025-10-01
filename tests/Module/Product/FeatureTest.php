<?php

declare(strict_types=1);

namespace App\Tests\Module\Product;

use App\Module\Product\Feature;
use App\Module\Product\Product;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\UuidInterface;

class FeatureTest extends TestCase
{
    public function testConstructorAndGetId(): void
    {
        $value = 'Test Feature';
        $feature = new Feature($value);
        
        $this->assertInstanceOf(UuidInterface::class, $feature->getId());
        $this->assertEquals($value, $feature->getValue());
        $this->assertIsArray($feature->getProducts());
        $this->assertEmpty($feature->getProducts());
    }

}
