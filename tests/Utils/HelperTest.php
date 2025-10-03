<?php

namespace App\Tests;

use App\Tests\Utils\Resource\Entity;
use App\Utils\Helper;
use PHPUnit\Framework\TestCase;
use App\Module\UuidIdentifiable;
use Ramsey\Uuid\UuidInterface;

class HelperTest extends TestCase
{




    public function testMapEntitiesByIdWithNonUuidIdentifiableObjects(): void
    {
        // Arrange
        $obj1 = new \stdClass();
        $obj2 = new \stdClass();
        $objects = [$obj1, $obj2];
        
        // Assert
        $this->expectException(\TypeError::class);
        
        // Act
        Helper::mapEntitiesById($objects);
    }


    public function testMapObjectsFromUserKeyWithNonStringKeys(): void
    {
        // Arrange
        $obj1 = new \stdClass();
        $obj1->id = 1;
        $obj2 = new \stdClass();
        $obj2->id = 2;
        $objects = [$obj1, $obj2];
        
        $keyFunction = function($obj) {
            return $obj->id; // Returns integer
        };
        
        // Act
        $result = Helper::mapObjectsFromUserKey($objects, $keyFunction);
        
        // Assert
        $this->assertCount(2, $result);
        $this->assertSame($obj1, $result['1']); // PHP converts int keys to strings
        $this->assertSame($obj2, $result['2']);
        $this->assertArrayHasKey('1', $result);
        $this->assertArrayHasKey('2', $result);
    }

/*
FAILED TEST: ## Test Failure Analysis

### Failure Reason:
The test `testMapEntitiesByIdWithDuplicateUuids` fails because the `Entity` class doesn't implement the `UuidIdentifiable` interface required by the `Helper::mapEntitiesById()` method.

### Recommended Fixes:
1. Make the `App\Tests\Utils\Resource\Entity` class implement the `App\Module\UuidIdentifiable` interface
2. Ensure the `Entity` class has a proper `getId()` method that returns a UUID object with a `toString()` method

    public function testMapEntitiesByIdWithDuplicateUuids(): void
    {
        // Arrange
        $uuid = '550e8400-e29b-41d4-a716-446655440000';
        $entity1 = new Entity($uuid);
        $entity2 = new Entity($uuid);
        $entities = [$entity1, $entity2];
        
        // Act
        $result = Helper::mapEntitiesById($entities);
        
        // Assert
        $this->assertCount(1, $result);
        $this->assertSame($entity2, $result[$uuid]);
        $this->assertNotSame($entity1, $result[$uuid]);
    }

*/

    public function testMapEntitiesByIdWithEmptyCollection(): void
    {
        // Arrange
        $entities = [];
        
        // Act
        $result = Helper::mapEntitiesById($entities);
        
        // Assert
        $this->assertEmpty($result);
        $this->assertIsArray($result);
    }


    public function testMapObjectsFromUserKeyWithCustomFunction(): void
    {
        // Arrange
        $obj1 = new \stdClass();
        $obj1->id = 'key1';
        $obj2 = new \stdClass();
        $obj2->id = 'key2';
        $objects = [$obj1, $obj2];
        
        $keyFunction = function($obj) {
            return $obj->id;
        };
        
        // Act
        $result = Helper::mapObjectsFromUserKey($objects, $keyFunction);
        
        // Assert
        $this->assertCount(2, $result);
        $this->assertSame($obj1, $result['key1']);
        $this->assertSame($obj2, $result['key2']);
    }

/*
FAILED TEST: ## Test Failure Analysis

The test fails because `Entity` class doesn't implement the `UuidIdentifiable` interface that's required by the `Helper::mapEntitiesById()` method.

### Recommended Fixes:

1. Make the `App\Tests\Utils\Resource\Entity` class implement the `App\Module\UuidIdentifiable` interface
2. Ensure the `Entity` class has a proper `getId()` method that returns a UUID object with a `toString()` method

The error occurs in the closure where the code expects an instance of `UuidIdentifiable` but receives an `Entity` object that doesn't implement this interface.

    public function testMapEntitiesByIdWithValidEntities(): void
    {
        // Arrange
        $entity1 = new Entity('550e8400-e29b-41d4-a716-446655440000');
        $entity2 = new Entity('550e8400-e29b-41d4-a716-446655440001');
        $entities = [$entity1, $entity2];
        
        // Act
        $result = Helper::mapEntitiesById($entities);
        
        // Assert
        $this->assertCount(2, $result);
        $this->assertSame($entity1, $result['550e8400-e29b-41d4-a716-446655440000']);
        $this->assertSame($entity2, $result['550e8400-e29b-41d4-a716-446655440001']);
    }

*/
}
