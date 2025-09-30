<?php

namespace App\Tests;

use App\Tests\Utils\Resource\Entity;
use App\Utils\Helper;
use PHPUnit\Framework\TestCase;
use App\Module\UuidIdentifiable;
use Ramsey\Uuid\UuidInterface;

class HelperTest extends TestCase
{


    
/*
FAILED TEST: **Analysis:**  
The test run failed because the `KERNEL_CLASS` environment variable is not set, causing multiple `LogicException` errors in Symfony test cases that extend `KernelTestCase` or `WebTestCase`.

**Recommended Fix:**  
Set the `KERNEL_CLASS` environment variable in your `phpunit.xml` or `phpunit.xml.dist` file:

```xml
<php>
    <env name="KERNEL_CLASS" value="App\Kernel" />
</php>
```

         public function testMapObjectsFromUserKeyWithNonIterableInput()
         {
             $this->expectException(\TypeError::class);
             Helper::mapObjectsFromUserKey('not an iterable', function ($object) {
                 return get_class($object);
             });
         }

*/
/*
FAILED TEST: **Analysis:**  
The test run failed because the `KERNEL_CLASS` environment variable is not set, causing multiple `LogicException` errors in Symfony test cases.

**Recommended Fix:**  
Set the `KERNEL_CLASS` environment variable in your `phpunit.xml` or `phpunit.xml.dist` file to the fully-qualified class name of your Symfony kernel, for example:
```xml
<php>
    <env name="KERNEL_CLASS" value="App\Kernel" />
</php>
```

         public function testMapObjectsFromUserKeyWithDuplicateKeys()
         {
             $entity1 = $this->createMock(UuidIdentifiable::class);
             $uuid1 = $this->createMock(\Ramsey\Uuid\UuidInterface::class);
             $uuid1->method('toString')->willReturn('uuid-1');
         
             $entity2 = $this->createMock(UuidIdentifiable::class);
             $uuid2 = $this->createMock(\Ramsey\Uuid\UuidInterface::class);
             $uuid2->method('toString')->willReturn('uuid-1');
         
             $entity1->method('getId')->willReturn($uuid1);
             $entity2->method('getId')->willReturn($uuid2);
         
             $entities = [$entity1, $entity2];
         
             $result = Helper::mapEntitiesById($entities);
         
             $this->assertCount(1, $result);
             $this->assertSame($entity2, $result['uuid-1']);
         }

*/
/*
FAILED TEST: **Analysis:**
The test run failed because PHPUnit could not locate the Symfony kernel class, resulting in multiple `LogicException` errors. This is due to the missing `KERNEL_CLASS` environment variable configuration.

**Recommended Fix:**
Set the `KERNEL_CLASS` environment variable in your `phpunit.xml` or `phpunit.xml.dist` file to the fully-qualified class name of your Symfony kernel, for example:
```xml
<php>
    <env name="KERNEL_CLASS" value="App\Kernel" />
</php>
```

         public function testMapObjectsFromUserKeyWithEmptyInput()
         {
             $result = Helper::mapObjectsFromUserKey([], function ($object) {
                 return get_class($object);
             });
         
             $this->assertIsArray($result);
             $this->assertEmpty($result);
         }

*/
/*
FAILED TEST: The test run failed due to missing configuration for the Symfony kernel class. 

**Root Cause:**
- PHPUnit is unable to locate the Symfony kernel class because the `KERNEL_CLASS` environment variable is not set.

**Recommended Fix:**
- Set the `KERNEL_CLASS` environment variable in your `phpunit.xml` or `phpunit.xml.dist` file to the fully-qualified class name of your Symfony kernel (e.g., `App\Kernel`). Example:
  ```xml
  <php>
      <env name="KERNEL_CLASS" value="App\Kernel" />
  </php>
  ```

         public function testMapEntitiesByIdWithValidUuids()
         {
             $entity1 = $this->createMock(UuidIdentifiable::class);
             $uuid1 = $this->createMock(\Ramsey\Uuid\UuidInterface::class);
             $uuid1->method('toString')->willReturn('uuid-1');
         
             $entity2 = $this->createMock(UuidIdentifiable::class);
             $uuid2 = $this->createMock(\Ramsey\Uuid\UuidInterface::class);
             $uuid2->method('toString')->willReturn('uuid-2');
         
             $entity1->method('getId')->willReturn($uuid1);
             $entity2->method('getId')->willReturn($uuid2);
         
             $entities = [$entity1, $entity2];
         
             $result = Helper::mapEntitiesById($entities);
         
             $this->assertArrayHasKey('uuid-1', $result);
             $this->assertSame($entity1, $result['uuid-1']);
             $this->assertArrayHasKey('uuid-2', $result);
             $this->assertSame($entity2, $result['uuid-2']);
         }

*/

          public function testMapObjectsFromUserKeyWithSingleObject()
          {
              $object = new \stdClass();
          
              $result = Helper::mapObjectsFromUserKey([$object], function ($obj) {
                  return 'key';
              });
          
              $this->assertCount(1, $result);
              $this->assertSame($object, $result['key']);
          }


          public function testMapObjectsFromUserKeyWithNonIterableInput()
          {
              $this->expectException(\TypeError::class);
              Helper::mapObjectsFromUserKey('not an iterable', function ($object) {
                  return get_class($object);
              });
          }


          public function testMapObjectsFromUserKeyWithDuplicateKeys()
          {
              $entity1 = $this->createMock(\App\Module\UuidIdentifiable::class);
              $uuid1 = $this->createMock(\Ramsey\Uuid\UuidInterface::class);
              $uuid1->method('toString')->willReturn('uuid-1');
          
              $entity2 = $this->createMock(\App\Module\UuidIdentifiable::class);
              $uuid2 = $this->createMock(\Ramsey\Uuid\UuidInterface::class);
              $uuid2->method('toString')->willReturn('uuid-1');
          
              $entity1->method('getId')->willReturn($uuid1);
              $entity2->method('getId')->willReturn($uuid2);
          
              $entities = [$entity1, $entity2];
          
              $result = Helper::mapEntitiesById($entities);
          
              $this->assertCount(1, $result);
              $this->assertSame($entity2, $result['uuid-1']);
          }


          public function testMapObjectsFromUserKeyWithEmptyInput()
          {
              $result = Helper::mapObjectsFromUserKey([], function ($object) {
                  return get_class($object);
              });
          
              $this->assertIsArray($result);
              $this->assertEmpty($result);
          }


          public function testMapEntitiesByIdWithValidUuids()
          {
              $entity1 = $this->createMock(\App\Module\UuidIdentifiable::class);
              $uuid1 = $this->createMock(\Ramsey\Uuid\UuidInterface::class);
              $uuid1->method('toString')->willReturn('uuid-1');
          
              $entity2 = $this->createMock(\App\Module\UuidIdentifiable::class);
              $uuid2 = $this->createMock(\Ramsey\Uuid\UuidInterface::class);
              $uuid2->method('toString')->willReturn('uuid-2');
          
              $entity1->method('getId')->willReturn($uuid1);
              $entity2->method('getId')->willReturn($uuid2);
          
              $entities = [$entity1, $entity2];
          
              $result = Helper::mapEntitiesById($entities);
          
              $this->assertArrayHasKey('uuid-1', $result);
              $this->assertSame($entity1, $result['uuid-1']);
              $this->assertArrayHasKey('uuid-2', $result);
              $this->assertSame($entity2, $result['uuid-2']);
          }

}
