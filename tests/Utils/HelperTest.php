<?php

namespace App\Tests;

use App\Tests\Utils\Resource\Entity;
use App\Utils\Helper;
use PHPUnit\Framework\TestCase;
use App\Module\UuidIdentifiable;
use Ramsey\Uuid\UuidInterface;

class HelperTest extends TestCase
{




public function testMapObjectsFromUserKeyWithNonCallableKeyFunction()
{
    $this->expectException(\TypeError::class);

    $objects = [new \stdClass()];
    Helper::mapObjectsFromUserKey($objects, null);
}


public function testMapObjectsFromUserKeyWithDuplicateKeys()
{
    $object1 = new \stdClass();
    $object2 = new \stdClass();
    $object3 = new \stdClass();

    $objects = [$object1, $object2, $object3];

    $result = Helper::mapObjectsFromUserKey($objects, function ($object) {
        return 'duplicate-key';
    });

    $this->assertCount(1, $result);
    $this->assertSame($object3, $result['duplicate-key']);
}


public function testMapObjectsFromUserKeyWithEmptyIterable()
{
    $objects = [];

    $result = Helper::mapObjectsFromUserKey($objects, function ($object) {
        return 'key';
    });

    $this->assertEmpty($result);
}


public function testMapEntitiesByIdWithUuidIdentifiableEntities()
{
    $entity1 = $this->createMock(UuidIdentifiable::class);
    $uuid1 = $this->createMock(UuidInterface::class);
    $uuid1->method('toString')->willReturn('uuid-1');

    $entity2 = $this->createMock(UuidIdentifiable::class);
    $uuid2 = $this->createMock(UuidInterface::class);
    $uuid2->method('toString')->willReturn('uuid-2');

    $entity3 = $this->createMock(UuidIdentifiable::class);
    $uuid3 = $this->createMock(UuidInterface::class);
    $uuid3->method('toString')->willReturn('uuid-3');

    $entity1->method('getId')->willReturn($uuid1);
    $entity2->method('getId')->willReturn($uuid2);
    $entity3->method('getId')->willReturn($uuid3);

    $entities = [$entity1, $entity2, $entity3];

    $result = Helper::mapEntitiesById($entities);

    $this->assertCount(3, $result);
    $this->assertSame($entity1, $result['uuid-1']);
    $this->assertSame($entity2, $result['uuid-2']);
    $this->assertSame($entity3, $result['uuid-3']);
}

}
