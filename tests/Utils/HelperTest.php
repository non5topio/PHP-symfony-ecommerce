<?php

namespace App\Tests;

use App\Tests\Utils\Resource\Entity;
use App\Utils\Helper;
use PHPUnit\Framework\TestCase;
use App\Module\UuidIdentifiable;
use Ramsey\Uuid\UuidInterface;

class HelperTest extends TestCase
{


    public function test_mapObjectsFromUserKey_withIntegerKeys_returnsArrayWithIntegerKeys()
    {
        // Arrange
        $obj1 = new \stdClass();
        $obj1->value = 'first';
        
        $obj2 = new \stdClass();
        $obj2->value = 'second';
        
        $obj3 = new \stdClass();
        $obj3->value = 'third';
        
        $objects = [$obj1, $obj2, $obj3];
        $counter = 1;
        $keyCallable = function($object) use (&$counter) {
            return $counter++;
        };
        
        // Act
        $result = Helper::mapObjectsFromUserKey($objects, $keyCallable);
        
        // Assert
        $this->assertIsArray($result);
        $this->assertCount(3, $result);
        $this->assertArrayHasKey(1, $result);
        $this->assertArrayHasKey(2, $result);
        $this->assertArrayHasKey(3, $result);
        $this->assertSame($obj1, $result[1]);
        $this->assertSame($obj2, $result[2]);
        $this->assertSame($obj3, $result[3]);
    }


    public function test_mapEntitiesById_withDuplicateUuids_laterEntityOverwritesEarlier()
    {
        // Arrange
        $uuid1 = $this->createMock(UuidInterface::class);
        $uuid1->method('toString')->willReturn('duplicate-uuid');
        
        $uuid2 = $this->createMock(UuidInterface::class);
        $uuid2->method('toString')->willReturn('duplicate-uuid');
        
        $uuid3 = $this->createMock(UuidInterface::class);
        $uuid3->method('toString')->willReturn('unique-uuid');
        
        $entity1 = $this->createMock(UuidIdentifiable::class);
        $entity1->method('getId')->willReturn($uuid1);
        
        $entity2 = $this->createMock(UuidIdentifiable::class);
        $entity2->method('getId')->willReturn($uuid2);
        
        $entity3 = $this->createMock(UuidIdentifiable::class);
        $entity3->method('getId')->willReturn($uuid3);
        
        $entities = [$entity1, $entity2, $entity3];
        
        // Act
        $result = Helper::mapEntitiesById($entities);
        
        // Assert
        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertArrayHasKey('duplicate-uuid', $result);
        $this->assertArrayHasKey('unique-uuid', $result);
        $this->assertSame($entity2, $result['duplicate-uuid']);
        $this->assertSame($entity3, $result['unique-uuid']);
    }


    public function test_mapEntitiesById_withSingleEntity_returnsSingleElementArray()
    {
        // Arrange
        $uuid = $this->createMock(UuidInterface::class);
        $uuid->method('toString')->willReturn('single-uuid');
        
        $entity = $this->createMock(UuidIdentifiable::class);
        $entity->method('getId')->willReturn($uuid);
        
        $entities = [$entity];
        
        // Act
        $result = Helper::mapEntitiesById($entities);
        
        // Assert
        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertArrayHasKey('single-uuid', $result);
        $this->assertSame($entity, $result['single-uuid']);
    }


    public function test_mapObjectsFromUserKey_withEmptyArray_returnsEmptyArray()
    {
        // Arrange
        $objects = [];
        $keyCallable = function($object) {
            return 'key';
        };
        
        // Act
        $result = Helper::mapObjectsFromUserKey($objects, $keyCallable);
        
        // Assert
        $this->assertIsArray($result);
        $this->assertEmpty($result);
        $this->assertCount(0, $result);
    }


    public function test_mapObjectsFromUserKey_withStdClassObjects_returnsArrayWithCustomKeys()
    {
        // Arrange
        $obj1 = new \stdClass();
        $obj1->id = 'key1';
        $obj1->name = 'Object 1';
        
        $obj2 = new \stdClass();
        $obj2->id = 'key2';
        $obj2->name = 'Object 2';
        
        $obj3 = new \stdClass();
        $obj3->id = 'key3';
        $obj3->name = 'Object 3';
        
        $objects = [$obj1, $obj2, $obj3];
        $keyCallable = function($object) {
            return $object->id;
        };
        
        // Act
        $result = Helper::mapObjectsFromUserKey($objects, $keyCallable);
        
        // Assert
        $this->assertIsArray($result);
        $this->assertCount(3, $result);
        $this->assertArrayHasKey('key1', $result);
        $this->assertArrayHasKey('key2', $result);
        $this->assertArrayHasKey('key3', $result);
        $this->assertSame($obj1, $result['key1']);
        $this->assertSame($obj2, $result['key2']);
        $this->assertSame($obj3, $result['key3']);
    }


    public function test_mapEntitiesById_withValidEntities_returnsArrayMappedByUuidStrings()
    {
        // Arrange
        $uuid1 = $this->createMock(UuidInterface::class);
        $uuid1->method('toString')->willReturn('uuid-1');
        
        $uuid2 = $this->createMock(UuidInterface::class);
        $uuid2->method('toString')->willReturn('uuid-2');
        
        $uuid3 = $this->createMock(UuidInterface::class);
        $uuid3->method('toString')->willReturn('uuid-3');
        
        $entity1 = $this->createMock(UuidIdentifiable::class);
        $entity1->method('getId')->willReturn($uuid1);
        
        $entity2 = $this->createMock(UuidIdentifiable::class);
        $entity2->method('getId')->willReturn($uuid2);
        
        $entity3 = $this->createMock(UuidIdentifiable::class);
        $entity3->method('getId')->willReturn($uuid3);
        
        $entities = [$entity1, $entity2, $entity3];
        
        // Act
        $result = Helper::mapEntitiesById($entities);
        
        // Assert
        $this->assertIsArray($result);
        $this->assertCount(3, $result);
        $this->assertArrayHasKey('uuid-1', $result);
        $this->assertArrayHasKey('uuid-2', $result);
        $this->assertArrayHasKey('uuid-3', $result);
        $this->assertSame($entity1, $result['uuid-1']);
        $this->assertSame($entity2, $result['uuid-2']);
        $this->assertSame($entity3, $result['uuid-3']);
    }


}
