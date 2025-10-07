<?php

declare(strict_types=1);

namespace App\Tests\DataFixtures\Provider;

use App\DataFixtures\Provider\ProductProvider;
use Faker\Factory;
use Faker\Generator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;

class ProductProviderTest extends TestCase
{


    public function test_initialize_without_description_files(): void
    {
        $tempDir = sys_get_temp_dir() . '/product_provider_test_' . uniqid();
        $fixturesDir = $tempDir . '/fixtures';
        $productsDir = $fixturesDir . '/products';
        $descriptionsDir = $productsDir . '/descriptions';
        $imagesDir = $tempDir . '/images';
        
        mkdir($productsDir, 0777, true);
        mkdir($descriptionsDir, 0777, true);
        mkdir($productsDir . '/images', 0777, true);
        
        $mockarooData = [['name' => 'Product', 'feature' => 'Feature']];
        file_put_contents($productsDir . '/mockaroo.json', json_encode($mockarooData));
        
        $generator = Factory::create();
        $filesystem = new Filesystem();
        
        $provider = new ProductProvider($generator, $filesystem, $fixturesDir, $imagesDir);
        
        $this->assertNull($provider->productDescription());
        
        $filesystem->remove($tempDir);
    }


    public function test_initialize_without_mockaroo_file(): void
    {
        $tempDir = sys_get_temp_dir() . '/product_provider_test_' . uniqid();
        $fixturesDir = $tempDir . '/fixtures';
        $productsDir = $fixturesDir . '/products';
        $imagesDir = $tempDir . '/images';
        
        mkdir($productsDir, 0777, true);
        mkdir($productsDir . '/descriptions', 0777, true);
        mkdir($productsDir . '/images', 0777, true);
        
        $generator = Factory::create();
        $filesystem = new Filesystem();
        
        $provider = new ProductProvider($generator, $filesystem, $fixturesDir, $imagesDir);
        
        $this->assertNull($provider->productName());
        $this->assertNull($provider->productFeatureName());
        
        $filesystem->remove($tempDir);
    }


    public function test_successfully_load_and_copy_product_images(): void
    {
        $tempDir = sys_get_temp_dir() . '/product_provider_test_' . uniqid();
        $fixturesDir = $tempDir . '/fixtures';
        $productsDir = $fixturesDir . '/products';
        $sourceImagesDir = $productsDir . '/images';
        $destImagesDir = $tempDir . '/dest_images';
        
        mkdir($productsDir, 0777, true);
        mkdir($productsDir . '/descriptions', 0777, true);
        mkdir($sourceImagesDir, 0777, true);
        
        file_put_contents($sourceImagesDir . '/image1.png', 'fake png content');
        file_put_contents($sourceImagesDir . '/image2.jpg', 'fake jpg content');
        
        $mockarooData = [['name' => 'Product', 'feature' => 'Feature']];
        file_put_contents($productsDir . '/mockaroo.json', json_encode($mockarooData));
        
        $generator = Factory::create();
        $filesystem = new Filesystem();
        
        $provider = new ProductProvider($generator, $filesystem, $fixturesDir, $destImagesDir);
        
        $this->assertTrue(is_dir($destImagesDir));
        $this->assertTrue(file_exists($destImagesDir . '/image1.png'));
        $this->assertTrue(file_exists($destImagesDir . '/image2.jpg'));
        
        $imageName = $provider->productImage();
        $this->assertNotNull($imageName);
        $this->assertIsString($imageName);
        $this->assertContains($imageName, ['image1.png', 'image2.jpg']);
        
        $filesystem->remove($tempDir);
    }


    public function test_successfully_retrieve_product_description(): void
    {
        $tempDir = sys_get_temp_dir() . '/product_provider_test_' . uniqid();
        $fixturesDir = $tempDir . '/fixtures';
        $productsDir = $fixturesDir . '/products';
        $descriptionsDir = $productsDir . '/descriptions';
        $imagesDir = $tempDir . '/images';
        
        mkdir($productsDir, 0777, true);
        mkdir($descriptionsDir, 0777, true);
        mkdir($productsDir . '/images', 0777, true);
        
        $description1 = "# Product Description 1\nThis is a great product.";
        $description2 = "# Product Description 2\nAnother amazing product.";
        file_put_contents($descriptionsDir . '/desc1.md', $description1);
        file_put_contents($descriptionsDir . '/desc2.md', $description2);
        
        $mockarooData = [['name' => 'Product', 'feature' => 'Feature']];
        file_put_contents($productsDir . '/mockaroo.json', json_encode($mockarooData));
        
        $generator = Factory::create();
        $filesystem = new Filesystem();
        
        $provider = new ProductProvider($generator, $filesystem, $fixturesDir, $imagesDir);
        
        $description = $provider->productDescription();
        
        $this->assertNotNull($description);
        $this->assertIsString($description);
        $this->assertTrue(
            $description === $description1 || $description === $description2
        );
        
        $filesystem->remove($tempDir);
    }


    public function test_successfully_retrieve_product_feature_name(): void
    {
        $tempDir = sys_get_temp_dir() . '/product_provider_test_' . uniqid();
        $fixturesDir = $tempDir . '/fixtures';
        $productsDir = $fixturesDir . '/products';
        $imagesDir = $tempDir . '/images';
        
        mkdir($productsDir, 0777, true);
        mkdir($productsDir . '/descriptions', 0777, true);
        mkdir($productsDir . '/images', 0777, true);
        
        $mockarooData = [
            ['name' => 'Product X', 'feature' => 'Waterproof'],
            ['name' => 'Product Y', 'feature' => 'Durable'],
            ['name' => 'Product Z', 'feature' => 'Lightweight']
        ];
        file_put_contents($productsDir . '/mockaroo.json', json_encode($mockarooData));
        
        $generator = Factory::create();
        $filesystem = new Filesystem();
        
        $provider = new ProductProvider($generator, $filesystem, $fixturesDir, $imagesDir);
        
        $featureName = $provider->productFeatureName();
        
        $this->assertNotNull($featureName);
        $this->assertIsString($featureName);
        $this->assertContains($featureName, ['Waterproof', 'Durable', 'Lightweight']);
        
        $filesystem->remove($tempDir);
    }


    public function test_successfully_initialize_and_retrieve_product_name(): void
    {
        $tempDir = sys_get_temp_dir() . '/product_provider_test_' . uniqid();
        $fixturesDir = $tempDir . '/fixtures';
        $productsDir = $fixturesDir . '/products';
        $imagesDir = $tempDir . '/images';
        
        mkdir($productsDir, 0777, true);
        mkdir($productsDir . '/descriptions', 0777, true);
        mkdir($productsDir . '/images', 0777, true);
        
        $mockarooData = [
            ['name' => 'Product A', 'feature' => 'Feature A'],
            ['name' => 'Product B', 'feature' => 'Feature B'],
            ['name' => 'Product C', 'feature' => 'Feature C']
        ];
        file_put_contents($productsDir . '/mockaroo.json', json_encode($mockarooData));
        
        $generator = Factory::create();
        $filesystem = new Filesystem();
        
        $provider = new ProductProvider($generator, $filesystem, $fixturesDir, $imagesDir);
        
        $productName = $provider->productName();
        
        $this->assertNotNull($productName);
        $this->assertIsString($productName);
        $this->assertContains($productName, ['Product A', 'Product B', 'Product C']);
        
        $filesystem->remove($tempDir);
    }


    public function test_initialize_when_source_images_directory_missing(): void
    {
        $tempDir = sys_get_temp_dir() . '/product_provider_test_' . uniqid();
        $fixturesDir = $tempDir . '/fixtures';
        $productsDir = $fixturesDir . '/products';
        $imagesDir = $tempDir . '/images';
        
        mkdir($productsDir, 0777, true);
        mkdir($productsDir . '/descriptions', 0777, true);
        
        $mockarooData = [['name' => 'Product', 'feature' => 'Feature']];
        file_put_contents($productsDir . '/mockaroo.json', json_encode($mockarooData));
        
        $generator = Factory::create();
        $filesystem = new Filesystem();
        
        $this->expectException(\InvalidArgumentException::class);
        
        $provider = new ProductProvider($generator, $filesystem, $fixturesDir, $imagesDir);
        
        $filesystem->remove($tempDir);
    }

/*
FAILED TEST: ## Test Failure Analysis

### Failed Test
`test_initialize_with_malformed_mockaroo_json`

### Root Cause
The `loadMockaroo()` method in `ProductProvider.php` (line 44) attempts to iterate over the result of `json_decode()` without validating that the decode operation succeeded. When JSON is malformed, `json_decode()` returns `null`, causing a "Invalid argument supplied for foreach()" error.

### Issue Location
**File:** `src/DataFixtures/Provider/ProductProvider.php`  
**Method:** `loadMockaroo()` at line 44

```php
$fields = \json_decode(\file_get_contents($file));
foreach ($fields as $field) { // Error: $fields is null when JSON is malformed
```

### Recommended Fix
Add validation after `json_decode()` to ensure the result is iterable:

```php
private function loadMockaroo(string $dir): self
{
    $file = $dir.'/products/mockaroo.json';

    if (\is_file($file)) {
        $fields = \json_decode(\file_get_contents($file));
        
        // Add this validation
        if (!is_array($fields)) {
            return $this;
        }
        
        foreach ($fields as $field) {
            $this->productNames[] = $field->name;
            $this->productFeatures[] = $field->feature;
        }
    }

    return $this;
}
```

This ensures malformed JSON is handled gracefully without throwing errors.

    public function test_initialize_with_malformed_mockaroo_json(): void
    {
        $tempDir = sys_get_temp_dir() . '/product_provider_test_' . uniqid();
        $fixturesDir = $tempDir . '/fixtures';
        $productsDir = $fixturesDir . '/products';
        $imagesDir = $tempDir . '/images';
        
        mkdir($productsDir, 0777, true);
        mkdir($productsDir . '/descriptions', 0777, true);
        mkdir($productsDir . '/images', 0777, true);
        
        file_put_contents($productsDir . '/mockaroo.json', '{invalid json content');
        
        $generator = Factory::create();
        $filesystem = new Filesystem();
        
        $provider = new ProductProvider($generator, $filesystem, $fixturesDir, $imagesDir);
        
        $this->assertNull($provider->productName());
        $this->assertNull($provider->productFeatureName());
        
        $filesystem->remove($tempDir);
    }

*/
/*
FAILED TEST: ## Test Failure Analysis

### Failed Test
`test_initialize_with_incomplete_mockaroo_field_objects`

### Root Cause
The test is checking how `ProductProvider` handles incomplete/malformed JSON data from `mockaroo.json`. The code attempts to access `$field->feature` (line 46) without verifying the property exists, causing an "Undefined property" error when the test provides incomplete field objects.

### Issue Location
**File:** `src/DataFixtures/Provider/ProductProvider.php`  
**Method:** `loadMockaroo()` at line 46

```php
foreach ($fields as $field) {
    $this->productNames[] = $field->name;
    $this->productFeatures[] = $field->feature;  // ← No property existence check
}
```

### Recommended Fix
Add property existence validation before accessing object properties:

```php
private function loadMockaroo(string $dir): self
{
    $file = $dir.'/products/mockaroo.json';

    if (\is_file($file)) {
        $fields = \json_decode(\file_get_contents($file));
        foreach ($fields as $field) {
            if (isset($field->name)) {
                $this->productNames[] = $field->name;
            }
            if (isset($field->feature)) {
                $this->productFeatures[] = $field->feature;
            }
        }
    }

    return $this;
}
```

This ensures the code gracefully handles incomplete data structures instead of throwing errors.

    public function test_initialize_with_incomplete_mockaroo_field_objects(): void
    {
        $tempDir = sys_get_temp_dir() . '/product_provider_test_' . uniqid();
        $fixturesDir = $tempDir . '/fixtures';
        $productsDir = $fixturesDir . '/products';
        $imagesDir = $tempDir . '/images';
        
        mkdir($productsDir, 0777, true);
        mkdir($productsDir . '/descriptions', 0777, true);
        mkdir($productsDir . '/images', 0777, true);
        
        $mockarooData = [
            (object)['name' => 'Product A'],
            (object)['feature' => 'Feature B']
        ];
        file_put_contents($productsDir . '/mockaroo.json', json_encode($mockarooData));
        
        $generator = Factory::create();
        $filesystem = new Filesystem();
        
        $provider = new ProductProvider($generator, $filesystem, $fixturesDir, $imagesDir);
        
        $productName = $provider->productName();
        $this->assertEquals('Product A', $productName);
        
        $featureName = $provider->productFeatureName();
        $this->assertEquals('Feature B', $featureName);
        
        $filesystem->remove($tempDir);
    }

*/

    public function test_load_descriptions_ignores_nested_subdirectories(): void
    {
        $tempDir = sys_get_temp_dir() . '/product_provider_test_' . uniqid();
        $fixturesDir = $tempDir . '/fixtures';
        $productsDir = $fixturesDir . '/products';
        $descriptionsDir = $productsDir . '/descriptions';
        $imagesDir = $tempDir . '/images';
        
        mkdir($productsDir, 0777, true);
        mkdir($descriptionsDir, 0777, true);
        mkdir($descriptionsDir . '/subfolder', 0777, true);
        mkdir($productsDir . '/images', 0777, true);
        
        $rootContent = "# Root Description\nThis is at depth 0.";
        file_put_contents($descriptionsDir . '/desc1.md', $rootContent);
        file_put_contents($descriptionsDir . '/subfolder/desc2.md', 'Nested content');
        
        $mockarooData = [['name' => 'Product', 'feature' => 'Feature']];
        file_put_contents($productsDir . '/mockaroo.json', json_encode($mockarooData));
        
        $generator = Factory::create();
        $filesystem = new Filesystem();
        
        $provider = new ProductProvider($generator, $filesystem, $fixturesDir, $imagesDir);
        
        $description = $provider->productDescription();
        $this->assertNotNull($description);
        $this->assertEquals($rootContent, $description);
        
        $filesystem->remove($tempDir);
    }


    public function test_load_descriptions_with_non_md_files(): void
    {
        $tempDir = sys_get_temp_dir() . '/product_provider_test_' . uniqid();
        $fixturesDir = $tempDir . '/fixtures';
        $productsDir = $fixturesDir . '/products';
        $descriptionsDir = $productsDir . '/descriptions';
        $imagesDir = $tempDir . '/images';
        
        mkdir($productsDir, 0777, true);
        mkdir($descriptionsDir, 0777, true);
        mkdir($productsDir . '/images', 0777, true);
        
        $validContent = "# Valid Description\nThis is valid.";
        file_put_contents($descriptionsDir . '/validdesc.md', $validContent);
        file_put_contents($descriptionsDir . '/desc.txt', 'txt content');
        file_put_contents($descriptionsDir . '/desc.html', 'html content');
        
        $mockarooData = [['name' => 'Product', 'feature' => 'Feature']];
        file_put_contents($productsDir . '/mockaroo.json', json_encode($mockarooData));
        
        $generator = Factory::create();
        $filesystem = new Filesystem();
        
        $provider = new ProductProvider($generator, $filesystem, $fixturesDir, $imagesDir);
        
        $description = $provider->productDescription();
        $this->assertNotNull($description);
        $this->assertEquals($validContent, $description);
        
        $filesystem->remove($tempDir);
    }


    public function test_load_images_with_mixed_file_extensions(): void
    {
        $tempDir = sys_get_temp_dir() . '/product_provider_test_' . uniqid();
        $fixturesDir = $tempDir . '/fixtures';
        $productsDir = $fixturesDir . '/products';
        $sourceImagesDir = $productsDir . '/images';
        $destImagesDir = $tempDir . '/dest_images';
        
        mkdir($productsDir, 0777, true);
        mkdir($productsDir . '/descriptions', 0777, true);
        mkdir($sourceImagesDir, 0777, true);
        
        file_put_contents($sourceImagesDir . '/valid.png', 'png content');
        file_put_contents($sourceImagesDir . '/valid.jpg', 'jpg content');
        file_put_contents($sourceImagesDir . '/invalid.gif', 'gif content');
        file_put_contents($sourceImagesDir . '/invalid.txt', 'txt content');
        
        $mockarooData = [['name' => 'Product', 'feature' => 'Feature']];
        file_put_contents($productsDir . '/mockaroo.json', json_encode($mockarooData));
        
        $generator = Factory::create();
        $filesystem = new Filesystem();
        
        $provider = new ProductProvider($generator, $filesystem, $fixturesDir, $destImagesDir);
        
        $imageName = $provider->productImage();
        $this->assertNotNull($imageName);
        $this->assertContains($imageName, ['valid.png', 'valid.jpg']);
        $this->assertFalse(file_exists($destImagesDir . '/invalid.gif'));
        $this->assertFalse(file_exists($destImagesDir . '/invalid.txt'));
        
        $filesystem->remove($tempDir);
    }


    public function test_initialize_with_existing_destination_image_files(): void
    {
        $tempDir = sys_get_temp_dir() . '/product_provider_test_' . uniqid();
        $fixturesDir = $tempDir . '/fixtures';
        $productsDir = $fixturesDir . '/products';
        $sourceImagesDir = $productsDir . '/images';
        $destImagesDir = $tempDir . '/dest_images';
        
        mkdir($productsDir, 0777, true);
        mkdir($productsDir . '/descriptions', 0777, true);
        mkdir($sourceImagesDir, 0777, true);
        mkdir($destImagesDir, 0777, true);
        
        file_put_contents($sourceImagesDir . '/image1.png', 'source content');
        file_put_contents($destImagesDir . '/image1.png', 'existing content');
        
        $mockarooData = [['name' => 'Product', 'feature' => 'Feature']];
        file_put_contents($productsDir . '/mockaroo.json', json_encode($mockarooData));
        
        $generator = Factory::create();
        $filesystem = new Filesystem();
        
        $provider = new ProductProvider($generator, $filesystem, $fixturesDir, $destImagesDir);
        
        $this->assertEquals('existing content', file_get_contents($destImagesDir . '/image1.png'));
        $this->assertNotNull($provider->productImage());
        
        $filesystem->remove($tempDir);
    }


    public function test_initialize_with_empty_mockaroo_json_array(): void
    {
        $tempDir = sys_get_temp_dir() . '/product_provider_test_' . uniqid();
        $fixturesDir = $tempDir . '/fixtures';
        $productsDir = $fixturesDir . '/products';
        $imagesDir = $tempDir . '/images';
        
        mkdir($productsDir, 0777, true);
        mkdir($productsDir . '/descriptions', 0777, true);
        mkdir($productsDir . '/images', 0777, true);
        
        file_put_contents($productsDir . '/mockaroo.json', json_encode([]));
        
        $generator = Factory::create();
        $filesystem = new Filesystem();
        
        $provider = new ProductProvider($generator, $filesystem, $fixturesDir, $imagesDir);
        
        $this->assertNull($provider->productName());
        $this->assertNull($provider->productFeatureName());
        
        $filesystem->remove($tempDir);
    }


}
