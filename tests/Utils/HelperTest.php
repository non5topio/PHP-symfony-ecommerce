<?php

namespace App\Tests;

use App\Tests\Utils\Resource\Entity;
use App\Utils\Helper;
use PHPUnit\Framework\TestCase;
use App\Module\UuidIdentifiable;
use Ramsey\Uuid\UuidInterface;

class HelperTest extends TestCase
{




public function testMapEntitiesByIdWithDuplicateUuids(): void
{
    $uuid = $this->createMock(UuidInterface::class);
    $uuid->method('toString')->willReturn('uuid-1');

    $entity1 = $this->createMock(UuidIdentifiable::class);
    $entity1->method('getId')->willReturn($uuid);

    $entity2 = $this->createMock(UuidIdentifiable::class);
    $entity2->method('getId')->willReturn($uuid);

    $entities = [$entity1, $entity2];

    $result = Helper::mapEntitiesById($entities);

    $this->assertCount(1, $result);
    $this->assertSame($entity2, $result['uuid-1']);
}


public function testMapObjectsFromUserKeyWithNonIterableInput(): void
{
    $this->expectException(\TypeError::class);

    Helper::mapObjectsFromUserKey('not an iterable', function ($object) {
        return $object;
    });
}


public function testMapObjectsFromUserKeyWithEmptyIterable(): void
{
    $objects = [];

    $result = Helper::mapObjectsFromUserKey($objects, function ($object) {
        return $object;
    });

    $this->assertEmpty($result);
}


public function testMapEntitiesByIdWithValidUuids(): void
{
    $uuid1 = $this->createMock(UuidInterface::class);
    $uuid1->method('toString')->willReturn('uuid-1');

    $uuid2 = $this->createMock(UuidInterface::class);
    $uuid2->method('toString')->willReturn('uuid-2');

    $entity1 = $this->createMock(UuidIdentifiable::class);
    $entity1->method('getId')->willReturn($uuid1);

    $entity2 = $this->createMock(UuidIdentifiable::class);
    $entity2->method('getId')->willReturn($uuid2);

    $entities = [$entity1, $entity2];

    $result = Helper::mapEntitiesById($entities);

    $this->assertCount(2, $result);
    $this->assertSame($entity1, $result['uuid-1']);
    $this->assertSame($entity2, $result['uuid-2']);
}

}
