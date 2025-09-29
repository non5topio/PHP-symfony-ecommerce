<?php

namespace App\Tests;

use App\Module\Product\Feature;
use App\Module\Product\Product;
use App\Module\UuidIdentifiable;
use App\Tests\Utils\Resource\Entity;
use App\Utils\Helper;
use PHPUnit\Framework\TestCase;

class HelperTest extends TestCase
{
    /**
     * @dataProvider getUuidEntities
     *
     * @param UuidIdentifiable[] $entities
     */
    public function testMapEntitiesById(array $entities): void
    {
        $mappedByIds = [];
        foreach ($entities as $entity) {
            $mappedByIds[$entity->getId()->toString()] = $entity;
        }

        $result = Helper::mapEntitiesById($entities);

        $this->assertEquals($mappedByIds, $result);
    }

    /**
     * @dataProvider getEntities
     *
     * @param Entity[] $entities
     */
    public function testMapObjectsFromUserKey(array $entities): void
    {
        $mappedByIds = [];
        foreach ($entities as $entity) {
            $mappedByIds[$entity->getName()] = $entity;
        }

        $result = Helper::mapObjectsFromUserKey($entities, function (Entity $object) {
            return $object->getName();
        });

        $this->assertEquals($mappedByIds, $result);
    }
/*
FAILED TEST: **Test Run Failure Analysis & Fixes:**

1. **Missing `KERNEL_CLASS` Environment Variable**  
   - **Cause**: Required for tests extending `KernelTestCase` or `WebTestCase`.  
   - **Fix**: Add to `phpunit.xml`/`phpunit.xml.dist`:  
     ```xml
     <php>
         <server name="KERNEL_CLASS" value="App\Kernel" />
     </php>
     ```

2. **Missing Class `App\Tests\Utils\Resource\Entity`**  
   - **Cause**: Used in `HelperTest` but not defined.  
   - **Fix**: Create file `tests/Utils/Resource/Entity.php` with:  
     ```php
     <?php
     namespace App\Tests\Utils\Resource;

     class Entity
     {
         public function __construct(private string $name = '') {}

         public function getName(): string
         {
             return $this->name;
         }
     }
     ```

3. **Type Mismatch in Mocked `getId()` Method**  
   - **Cause**: Mock returns `stdClass` instead of `Ramsey\Uuid\UuidInterface`.  
   - **Fix**: Update mocks to return a real `UuidInterface` instance, e.g.:  
     ```php
     use Ramsey\Uuid\Uuid;

     $entity1->method('getId')->willReturn(Uuid::uuid4());
     ```

    public function testMapObjectsFromUserKeyWithLargeNumberOfEntities(): void
    {
        $entities = [];
        for ($i = 0; $i < 1000; $i++) {
            $entities[] = new Entity("entity_{$i}");
        }
    
        $result = Helper::mapObjectsFromUserKey($entities, function (Entity $object) {
            return $object->getName();
        });
    
        $this->assertCount(1000, $result);
        foreach ($entities as $entity) {
            $key = $entity->getName();
            $this->assertSame($entity, $result[$key]);
        }
    }

*/
/*
FAILED TEST: The test run failed due to the following issues:

1. **Missing `KERNEL_CLASS` Environment Variable**  
   - **Cause**: Required for Symfony test cases that extend `KernelTestCase` or `WebTestCase`.  
   - **Fix**: Set `KERNEL_CLASS` in `phpunit.xml`/`phpunit.xml.dist` to `App\Kernel`.

2. **Missing Class `App\Tests\Utils\Resource\Entity`**  
   - **Cause**: Used in `HelperTest` but not defined.  
   - **Fix**: Create `tests/Utils/Resource/Entity.php` and define the `Entity` class there.

3. **Type Mismatch in Mocked `getId()` Method**  
   - **Cause**: Mock returns `stdClass` instead of `Ramsey\Uuid\UuidInterface`.  
   - **Fix**: Update the mock to return a proper UuidInterface implementation (e.g., use `Uuid::uuid4()` from `ramsey/uuid`).

    public function testMapEntitiesByIdWithNullOrEmptyUuids(): void
    {
        $entity1 = $this->getMockBuilder(UuidIdentifiable::class)
            ->getMock();
        $entity1->method('getId')->willReturn((object)['toString' => function () { return null; }]);
    
        $entity2 = $this->getMockBuilder(UuidIdentifiable::class)
            ->getMock();
        $entity2->method('getId')->willReturn((object)['toString' => function () { return ''; }]);
    
        $entities = [$entity1, $entity2];
    
        $result = Helper::mapEntitiesById($entities);
    
        $this->assertCount(2, $result);
        $this->assertSame($entity1, $result[null]);
        $this->assertSame($entity2, $result['']);
    }

*/
/*
FAILED TEST: The test run failed due to two main issues:

1. **Missing `KERNEL_CLASS` Environment Variable**  
   - **Cause**: PHPUnit is trying to run controller tests that extend `KernelTestCase` or `WebTestCase`, but the `KERNEL_CLASS` environment variable is not set.
   - **Fix**: Set the `KERNEL_CLASS` environment variable in your `phpunit.xml` or `phpunit.xml.dist` to the fully-qualified class name of your Symfony kernel (e.g., `App\Kernel`).

2. **Missing Class `App\Tests\Utils\Resource\Entity`**  
   - **Cause**: The test `HelperTest` uses a class `Entity` from `App\Tests\Utils\Resource\Entity`, which is not found.
   - **Fix**: Ensure the class `Entity` is defined and properly autoloaded. Create the file `Entity.php` in the `tests/Utils/Resource/` directory and define the class there.

These fixes will allow the test suite to run without these errors.

    public function testMapObjectsFromUserKeyWithDuplicateKeys(): void
    {
        $entity1 = new Entity('duplicate');
        $entity2 = new Entity('duplicate');
    
        $entities = [$entity1, $entity2];
    
        $result = Helper::mapObjectsFromUserKey($entities, function (Entity $object) {
            return $object->getName();
        });
    
        $this->assertCount(1, $result);
        $this->assertSame($entity2, $result['duplicate']);
    }

*/


    public function getUuidEntities()
    {
        yield [[]];
        yield [[new Product('foo')]];
        yield [[new Product('bar1'), new Feature('bar2')]];
    }

    public function getEntities()
    {
        $foo = new Entity('foo');
        $bar = new Entity('bar');

        yield [[]];
        yield [[$foo]];
        yield [[$foo, $bar]];
    }
}
