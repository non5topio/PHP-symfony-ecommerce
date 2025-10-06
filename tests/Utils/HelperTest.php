<?php

namespace App\Tests;

use App\Tests\Utils\Resource\Entity;
use App\Utils\Helper;
use PHPUnit\Framework\TestCase;
use App\Module\UuidIdentifiable;
use Ramsey\Uuid\UuidInterface;

class HelperTest extends TestCase
{



public function testMapObjectsFromUserKeyWithNonIterableInput()
{
    $this->expectException(\TypeError::class);

    Helper::mapObjectsFromUserKey('not an iterable', function($object) {
        return 'key';
    });
}


public function testMapObjectsFromUserKeyWithDuplicateKeys()
{
    $object1 = new \stdClass();
    $object2 = new \stdClass();

    $objects = [$object1, $object2];

    $result = Helper::mapObjectsFromUserKey($objects, function($object) {
        return 'duplicate_key';
    });

    $this->assertCount(1, $result);
    $this->assertSame($object2, $result['duplicate_key']);
}


public function testMapObjectsFromUserKeyWithEmptyInput()
{
    $objects = [];

    $result = Helper::mapObjectsFromUserKey($objects, function($object) {
        return 'key';
    });

    $this->assertEmpty($result);
}


public function testMapEntitiesByIdWithValidUuids()
{
    $uuid1 = \Ramsey\Uuid\Uuid::uuid4();
    $uuid2 = \Ramsey\Uuid\Uuid::uuid4();

    $entity1 = $this->createMock(UuidIdentifiable::class);
    $entity1->method('getId')->willReturn($uuid1);

    $entity2 = $this->createMock(UuidIdentifiable::class);
    $entity2->method('getId')->willReturn($uuid2);

    $entities = [$entity1, $entity2];

    $result = Helper::mapEntitiesById($entities);

    $this->assertCount(2, $result);
    $this->assertSame($entity1, $result[$uuid1->toString()]);
    $this->assertSame($entity2, $result[$uuid2->toString()]);
}

}
