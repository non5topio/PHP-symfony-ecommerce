<?php

namespace App\Tests;

use App\Tests\Utils\Resource\Entity;
use App\Utils\Helper;
use PHPUnit\Framework\TestCase;
use App\Module\UuidIdentifiable;
use Ramsey\Uuid\UuidInterface;

class HelperTest extends TestCase
{



public function testMapEntitiesByIdWithNonUuidIdentifiableObject()
{
    $this->expectException(\TypeError::class);

    $nonEntity = new \stdClass();
    Helper::mapEntitiesById([$nonEntity]);
}


public function testMapObjectsFromUserKeyWithDuplicateKeys()
{
    $object1 = new \stdClass();
    $object2 = new \stdClass();

    $result = Helper::mapObjectsFromUserKey([$object1, $object2], function($object) {
        return 'duplicate_key';
    });

    $this->assertCount(1, $result);
    $this->assertSame($object2, $result['duplicate_key']);
}


public function testMapObjectsFromUserKeyWithEmptyIterable()
{
    $objects = [];

    $result = Helper::mapObjectsFromUserKey($objects, function($object) {
        return 'key';
    });

    $this->assertEmpty($result);
}


public function testMapEntitiesByIdWithValidUuids()
{
    $uuid1 = $this->createMock(UuidInterface::class);
    $uuid1->method('toString')->willReturn('uuid1');
    $entity1 = $this->createMock(UuidIdentifiable::class);
    $entity1->method('getId')->willReturn($uuid1);

    $uuid2 = $this->createMock(UuidInterface::class);
    $uuid2->method('toString')->willReturn('uuid2');
    $entity2 = $this->createMock(UuidIdentifiable::class);
    $entity2->method('getId')->willReturn($uuid2);

    $entities = [$entity1, $entity2];

    $result = Helper::mapEntitiesById($entities);

    $this->assertArrayHasKey('uuid1', $result);
    $this->assertSame($entity1, $result['uuid1']);
    $this->assertArrayHasKey('uuid2', $result);
    $this->assertSame($entity2, $result['uuid2']);
}

}
