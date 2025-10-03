<?php

namespace App\Tests;

use App\Tests\Utils\Resource\Entity;
use App\Utils\Helper;
use PHPUnit\Framework\TestCase;
use App\Module\UuidIdentifiable;
use Ramsey\Uuid\UuidInterface;

class HelperTest extends TestCase
{


    public function test_mapObjectsFromUserKey_withIntegerKeys_returnsArrayMappedByIntegers()
    {
        // Arrange
        $obj1 = new \stdClass();
        $obj1->id = 0;
        
        $obj2 = new \stdClass();
        $obj2->id = 1;
        
        $obj3 = new \stdClass();
        $obj3->id = 100;
        
        $objects = [$obj1, $obj2, $obj3];
        $keyCallable = function($obj) {
            return $obj->id;
        };
        
        // Act
        $result = Helper::mapObjectsFromUserKey($objects, $keyCallable);
        
        // Assert
        $this->assertIsArray($result);
        $this->assertCount(3, $result);
        $this->assertArrayHasKey(0, $result);
        $this->assertArrayHasKey(1, $result);
        $this->assertArrayHasKey(100, $result);
        $this->assertSame($obj1, $result[0]);
        $this->assertSame($obj2, $result[1]);
        $this->assertSame($obj3, $result[100]);
    }


    public function test_mapEntitiesById_withDuplicateUuids_laterEntityOverwritesEarlier()
    {
        // Arrange
        $duplicateUuidString = '550e8400-e29b-41d4-a716-446655440001';
        
        $uuid1 = $this->createMock(UuidInterface::class);
        $uuid1->method('toString')->willReturn($duplicateUuidString);
        
        $uuid2 = $this->createMock(UuidInterface::class);
        $uuid2->method('toString')->willReturn($duplicateUuidString);
        
        $uuid3 = $this->createMock(UuidInterface::class);
        $uuid3->method('toString')->willReturn('550e8400-e29b-41d4-a716-446655440002');
        
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
        $this->assertArrayHasKey($duplicateUuidString, $result);
        $this->assertSame($entity2, $result[$duplicateUuidString]);
        $this->assertNotSame($entity1, $result[$duplicateUuidString]);
    }


    public function test_mapEntitiesById_withSingleEntity_returnsSingleElementArray()
    {
        // Arrange
        $uuid = $this->createMock(UuidInterface::class);
        $uuid->method('toString')->willReturn('550e8400-e29b-41d4-a716-446655440000');
        
        $entity = $this->createMock(UuidIdentifiable::class);
        $entity->method('getId')->willReturn($uuid);
        
        $entities = [$entity];
        
        // Act
        $result = Helper::mapEntitiesById($entities);
        
        // Assert
        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertArrayHasKey('550e8400-e29b-41d4-a716-446655440000', $result);
        $this->assertSame($entity, $result['550e8400-e29b-41d4-a716-446655440000']);
    }


    public function test_mapEntitiesById_withEmptyArray_returnsEmptyArray()
    {
        // Arrange
        $entities = [];
        
        // Act
        $result = Helper::mapEntitiesById($entities);
        
        // Assert
        $this->assertIsArray($result);
        $this->assertEmpty($result);
        $this->assertCount(0, $result);
    }


    public function test_mapObjectsFromUserKey_withCustomCallable_returnsArrayMappedByCustomKeys()
    {
        // Arrange
        $obj1 = new \stdClass();
        $obj1->name = 'Alice';
        
        $obj2 = new \stdClass();
        $obj2->name = 'Bob';
        
        $obj3 = new \stdClass();
        $obj3->name = 'Charlie';
        
        $objects = [$obj1, $obj2, $obj3];
        $keyCallable = function($obj) {
            return $obj->name;
        };
        
        // Act
        $result = Helper::mapObjectsFromUserKey($objects, $keyCallable);
        
        // Assert
        $this->assertIsArray($result);
        $this->assertCount(3, $result);
        $this->assertArrayHasKey('Alice', $result);
        $this->assertArrayHasKey('Bob', $result);
        $this->assertArrayHasKey('Charlie', $result);
        $this->assertSame($obj1, $result['Alice']);
        $this->assertSame($obj2, $result['Bob']);
        $this->assertSame($obj3, $result['Charlie']);
    }


    public function test_mapEntitiesById_withValidEntities_returnsArrayMappedByUuidStrings()
    {
        // Arrange
        $uuid1 = $this->createMock(UuidInterface::class);
        $uuid1->method('toString')->willReturn('550e8400-e29b-41d4-a716-446655440001');
        
        $uuid2 = $this->createMock(UuidInterface::class);
        $uuid2->method('toString')->willReturn('550e8400-e29b-41d4-a716-446655440002');
        
        $uuid3 = $this->createMock(UuidInterface::class);
        $uuid3->method('toString')->willReturn('550e8400-e29b-41d4-a716-446655440003');
        
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
        $this->assertArrayHasKey('550e8400-e29b-41d4-a716-446655440001', $result);
        $this->assertArrayHasKey('550e8400-e29b-41d4-a716-446655440002', $result);
        $this->assertArrayHasKey('550e8400-e29b-41d4-a716-446655440003', $result);
        $this->assertSame($entity1, $result['550e8400-e29b-41d4-a716-446655440001']);
        $this->assertSame($entity2, $result['550e8400-e29b-41d4-a716-446655440002']);
        $this->assertSame($entity3, $result['550e8400-e29b-41d4-a716-446655440003']);
    }

    
}
