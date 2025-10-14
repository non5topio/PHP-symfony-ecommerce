<?php

declare(strict_types=1);

namespace App\Tests\Module\Product;

use App\Module\Product\Feature;
use App\Module\Product\Product;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\UuidInterface;

class FeatureTest extends TestCase
{




    public function test_create_feature_with_whitespace_only_value(): void
    {
        $whitespaceValue = "   \t\n   ";
        $feature = new Feature($whitespaceValue);
        
        $this->assertInstanceOf(UuidInterface::class, $feature->getId());
        $this->assertSame($whitespaceValue, $feature->getValue());
        $this->assertIsArray($feature->getProducts());
        $this->assertEmpty($feature->getProducts());
    }


    public function test_get_slug_returns_slug_value(): void
    {
        $feature = new Feature('Wireless Connectivity');
        
        // Use reflection to set the slug property since it's normally set by Gedmo
        $reflection = new \ReflectionClass($feature);
        $slugProperty = $reflection->getProperty('slug');
        $slugProperty->setAccessible(true);
        $slugProperty->setValue($feature, 'wireless-connectivity');
        
        $this->assertSame('wireless-connectivity', $feature->getSlug());
    }


    public function test_create_feature_with_special_characters_and_unicode(): void
    {
        $value = "4K Ultra-HD™ 📺 Display (2160p) <script>alert('test')</script>";
        $feature = new Feature($value);
        
        $this->assertInstanceOf(Feature::class, $feature);
        $this->assertSame($value, $feature->getValue());
        $this->assertStringContainsString("™", $feature->getValue());
        $this->assertStringContainsString("📺", $feature->getValue());
        $this->assertStringContainsString("<script>", $feature->getValue());
    }


    public function test_create_feature_with_very_long_string(): void
    {
        $value = str_repeat("A", 1000);
        $feature = new Feature($value);
        
        $this->assertInstanceOf(Feature::class, $feature);
        $this->assertSame($value, $feature->getValue());
        $this->assertSame(1000, strlen($feature->getValue()));
    }


    public function test_create_feature_with_empty_string(): void
    {
        $value = "";
        $feature = new Feature($value);
        
        $this->assertInstanceOf(Feature::class, $feature);
        $this->assertSame("", $feature->getValue());
        $this->assertInstanceOf(UuidInterface::class, $feature->getId());
    }


    public function test_products_collection_initialization(): void
    {
        $feature = new Feature("Water Resistant");
        
        $products = $feature->getProducts();
        
        $this->assertIsArray($products);
        $this->assertEmpty($products);
        $this->assertCount(0, $products);
    }


    public function test_uuid_uniqueness_across_multiple_instances(): void
    {
        $value = "Bluetooth";
        $feature1 = new Feature($value);
        $feature2 = new Feature($value);
        $feature3 = new Feature($value);
        
        $uuid1 = $feature1->getId();
        $uuid2 = $feature2->getId();
        $uuid3 = $feature3->getId();
        
        $this->assertInstanceOf(UuidInterface::class, $uuid1);
        $this->assertInstanceOf(UuidInterface::class, $uuid2);
        $this->assertInstanceOf(UuidInterface::class, $uuid3);
        
        $this->assertNotEquals($uuid1->toString(), $uuid2->toString());
        $this->assertNotEquals($uuid1->toString(), $uuid3->toString());
        $this->assertNotEquals($uuid2->toString(), $uuid3->toString());
    }


    public function test_create_feature_with_valid_value(): void
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
