<?php

declare(strict_types=1);

namespace App\Tests\Module\Product;

use App\Module\Product\Feature;
use App\Module\Product\Product;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\UuidInterface;

class FeatureTest extends TestCase
{


    public function test_create_feature_with_special_characters_and_unicode(): void
    {
        $value = "Größe: 15\" × 20° (±2mm) — €50";
        $feature = new Feature($value);
        
        $this->assertInstanceOf(Feature::class, $feature);
        $this->assertSame($value, $feature->getValue());
        $this->assertStringContainsString("Größe", $feature->getValue());
        $this->assertStringContainsString("×", $feature->getValue());
        $this->assertStringContainsString("€", $feature->getValue());
    }


    public function test_create_feature_with_very_long_string_value(): void
    {
        $value = str_repeat("A", 1000);
        $feature = new Feature($value);
        
        $this->assertInstanceOf(Feature::class, $feature);
        $this->assertSame($value, $feature->getValue());
        $this->assertEquals(1000, strlen($feature->getValue()));
    }


    public function test_create_feature_with_empty_string_value(): void
    {
        $value = "";
        $feature = new Feature($value);
        
        $this->assertInstanceOf(Feature::class, $feature);
        $this->assertSame("", $feature->getValue());
        $this->assertInstanceOf(UuidInterface::class, $feature->getId());
    }


    public function test_products_collection_initialization(): void
    {
        $feature = new Feature("Bluetooth 5.0");
        
        $products = $feature->getProducts();
        
        $this->assertIsArray($products);
        $this->assertEmpty($products);
        $this->assertCount(0, $products);
    }


    public function test_uuid_generation_produces_unique_identifiers(): void
    {
        $feature1 = new Feature("Feature A");
        $feature2 = new Feature("Feature B");
        
        $uuid1 = $feature1->getId();
        $uuid2 = $feature2->getId();
        
        $this->assertInstanceOf(UuidInterface::class, $uuid1);
        $this->assertInstanceOf(UuidInterface::class, $uuid2);
        $this->assertNotEquals($uuid1->toString(), $uuid2->toString());
        $this->assertEquals(4, $uuid1->getVersion());
        $this->assertEquals(4, $uuid2->getVersion());
    }


    public function test_create_feature_with_valid_string_value(): void
    {
        $value = "Wireless Connectivity";
        $feature = new Feature($value);
        
        $this->assertInstanceOf(Feature::class, $feature);
        $this->assertInstanceOf(UuidInterface::class, $feature->getId());
        $this->assertSame($value, $feature->getValue());
        $this->assertIsArray($feature->getProducts());
        $this->assertEmpty($feature->getProducts());
    }


}
