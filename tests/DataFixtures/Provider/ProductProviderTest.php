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
    public function testProductProviderCanBeInstantiated(): void
    {
        $generator = Factory::create();
        $filesystem = new Filesystem();
        $fixturesResourcesDir = __DIR__ . '/../../../fixtures/resources';
        $productImagesDir = __DIR__ . '/../../../public/images/products';
        
        $provider = new ProductProvider(
            $generator,
            $filesystem,
            $fixturesResourcesDir,
            $productImagesDir
        );
        
        $this->assertInstanceOf(ProductProvider::class, $provider);
    }

}
