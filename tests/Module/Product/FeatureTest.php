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


    public function test_get_value_nullable_return_type_with_empty_string(): void
    {
        $feature = new Feature("");
        
        $value = $feature->getValue();
        
        $this->assertNotNull($value);
        $this->assertIsString($value);
        $this->assertSame("", $value);
        $this->assertEquals(0, strlen($value));
    }


    public function test_create_feature_with_null_byte_in_value(): void
    {
        $value = "Feature\0Value";
        $feature = new Feature($value);
        
        $this->assertInstanceOf(Feature::class, $feature);
        $this->assertSame("Feature\0Value", $feature->getValue());
        $this->assertEquals(13, strlen($feature->getValue()));
        $this->assertInstanceOf(UuidInterface::class, $feature->getId());
    }


    public function test_create_feature_with_whitespace_tab_newline_value(): void
    {
        $value = "\t\n";
        $feature = new Feature($value);
        
        $this->assertInstanceOf(Feature::class, $feature);
        $this->assertSame("\t\n", $feature->getValue());
        $this->assertInstanceOf(UuidInterface::class, $feature->getId());
    }


    public function test_create_feature_with_whitespace_spaces_value(): void
    {
        $value = "   ";
        $feature = new Feature($value);
        
        $this->assertInstanceOf(Feature::class, $feature);
        $this->assertSame("   ", $feature->getValue());
        $this->assertInstanceOf(UuidInterface::class, $feature->getId());
    }


    public function test_create_feature_with_single_character_value(): void
    {
        $value = "A";
        $feature = new Feature($value);
        
        $this->assertInstanceOf(Feature::class, $feature);
        $this->assertSame("A", $feature->getValue());
        $this->assertInstanceOf(UuidInterface::class, $feature->getId());
        $this->assertIsArray($feature->getProducts());
        $this->assertEmpty($feature->getProducts());
    }


    public function test_get_slug_returns_slug_value(): void
    {
        $value = "Wireless Connectivity";
        $feature = new Feature($value);
        
        // Use reflection to set the slug property since no setter exists
        $reflection = new \ReflectionClass($feature);
        $slugProperty = $reflection->getProperty('slug');
        $slugProperty->setAccessible(true);
        $slugProperty->setValue($feature, 'wireless-connectivity');
        
        $this->assertSame('wireless-connectivity', $feature->getSlug());
        $this->assertIsString($feature->getSlug());
    }


}
