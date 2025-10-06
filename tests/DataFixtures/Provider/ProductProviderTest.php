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


}
