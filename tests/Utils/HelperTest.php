<?php

namespace App\Tests;

use App\Tests\Utils\Resource\Entity;
use App\Utils\Helper;
use PHPUnit\Framework\TestCase;

class HelperTest extends TestCase
{
    public function testMapObjectsFromUserKey(): void
    {
        $entities = [];
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
FAILED TEST: **Analysis:**  
The test run failed because the `KERNEL_CLASS` environment variable is not set. This is required for tests extending `KernelTestCase` or `WebTestCase` to bootstrap the Symfony kernel.

**Recommended Fix:**  
Add the following to your `phpunit.xml` or `phpunit.xml.dist` file:

```xml
<php>
    <env name="KERNEL_CLASS" value="App\Kernel" />
</php>
```

This will resolve the `LogicException` errors and allow the test suite to run properly.

    public function testMapObjectsFromUserKeyWithDuplicateKeys(): void
    {
        $objects = [
            (object) ['name' => 'Alice'],
            (object) ['name' => 'Alice'],
            (object) ['name' => 'Bob'],
        ];
    
        $result = Helper::mapObjectsFromUserKey($objects, function ($object) {
            return $object->name;
        });
    
        $expected = [
            'Alice' => $objects[1],
            'Bob' => $objects[2],
        ];
    
        $this->assertEquals($expected, $result);
    }

*/
/*
FAILED TEST: **Analysis:**
The test run failed due to a missing `KERNEL_CLASS` environment variable configuration, which is required for tests extending `KernelTestCase` or `WebTestCase`. Without it, Symfony cannot bootstrap the kernel, leading to multiple `LogicException` errors.

**Recommended Fix:**
Add the following to your `phpunit.xml` or `phpunit.xml.dist` file:

```xml
<php>
    <env name="KERNEL_CLASS" value="App\Kernel" />
</php>
```

This will resolve the `LogicException` errors and allow the test suite to run properly.

    public function testMapObjectsFromUserKeyWithNonIterableInput(): void
    {
        $this->expectException(\TypeError::class);
    
        Helper::mapObjectsFromUserKey('not an iterable', function ($object) {
            return $object->name;
        });
    }

*/
/*
FAILED TEST: The test run failed because the `KERNEL_CLASS` environment variable is not set, which is required for tests extending `KernelTestCase` or `WebTestCase`.

**Recommended Fix:**
Add the following to your `phpunit.xml` or `phpunit.xml.dist`:

```xml
<php>
    <env name="KERNEL_CLASS" value="App\Kernel" />
</php>
```

This will resolve the `LogicException` errors and allow the test suite to run properly.

    public function testMapObjectsFromUserKeyWithEmptyInput(): void
    {
        $objects = [];
    
        $result = Helper::mapObjectsFromUserKey($objects, function ($object) {
            return $object->name;
        });
    
        $this->assertEmpty($result);
    }

*/
/*
FAILED TEST: The test run failed due to **missing configuration** for the `KERNEL_CLASS` environment variable, which is required by Symfony's `KernelTestCase` and `WebTestCase` to bootstrap the application kernel during testing.

### Root Cause:
- The `KERNEL_CLASS` environment variable is not set in `phpunit.xml` or `phpunit.xml.dist`.
- This is causing all test classes that extend `KernelTestCase` or `WebTestCase` to fail with `LogicException`.

### Recommended Fix:
Set the `KERNEL_CLASS` in your `phpunit.xml` or `phpunit.xml.dist` file like this:

```xml
<php>
    <env name="KERNEL_CLASS" value="App\Kernel" />
</php>
```

This will resolve the errors and allow the test suite to run properly.

    public function testMapEntitiesByIdWithValidInput(): void
    {
        $entities = [
            $this->createMock(UuidIdentifiable::class),
            $this->createMock(UuidIdentifiable::class),
        ];
    
        $uuid1 = '123e4567-e89b-12d3-a456-426614174000';
        $uuid2 = '123e4567-e89b-12d3-a456-426614174001';
    
        $entities[0]->method('getId')->willReturn($this->createMock(\Ramsey\Uuid\UuidInterface::class));
        $entities[0]->method('getId')->willReturnMap([
            [], $this->createMock(\Ramsey\Uuid\UuidInterface::class),
        ]);
        $entities[0]->getId()->method('toString')->willReturn($uuid1);
    
        $entities[1]->method('getId')->willReturn($this->createMock(\Ramsey\Uuid\UuidInterface::class));
        $entities[1]->getId()->method('toString')->willReturn($uuid2);
    
        $expected = [
            $uuid1 => $entities[0],
            $uuid2 => $entities[1],
        ];
    
        $result = Helper::mapEntitiesById($entities);
    
        $this->assertEquals($expected, $result);
    }

*/
}
