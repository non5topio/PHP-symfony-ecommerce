<?php

namespace App\Tests;

use App\Tests\Utils\Resource\Entity;
use App\Utils\Helper;
use PHPUnit\Framework\TestCase;
use App\Module\UuidIdentifiable;
use Ramsey\Uuid\UuidInterface;

class HelperTest extends TestCase
{




public function testMapEntitiesByIdWithDuplicateUuids()
{
    $uuid = $this->createMock(UuidInterface::class);
    $uuid->method('toString')->willReturn('uuid1');

    $entity1 = $this->createMock(UuidIdentifiable::class);
    $entity1->method('getId')->willReturn($uuid);

    $entity2 = $this->createMock(UuidIdentifiable::class);
    $entity2->method('getId')->willReturn($uuid);

    $entities = [$entity1, $entity2];

    $result = Helper::mapEntitiesById($entities);

    $this->assertCount(1, $result);
    $this->assertSame($entity2, $result['uuid1']);
}


public function testMapEntitiesByIdWithEmptyUuid()
{
    $uuid = $this->createMock(UuidInterface::class);
    $uuid->method('toString')->willReturn('');
    $entity = $this->createMock(UuidIdentifiable::class);
    $entity->method('getId')->willReturn($uuid);

    $entities = [$entity];

    $result = Helper::mapEntitiesById($entities);

    $this->assertCount(1, $result);
    $this->assertSame($entity, $result['']);
}


public function testMapEntitiesByIdWithEmptyInput()
{
    $entities = [];

    $result = Helper::mapEntitiesById($entities);

    $this->assertEmpty($result);
}


public function testMapEntitiesByIdWithMultipleEntities()
{
    $uuid1 = $this->createMock(UuidInterface::class);
    $uuid1->method('toString')->willReturn('uuid1');
    $entity1 = $this->createMock(UuidIdentifiable::class);
    $entity1->method('getId')->willReturn($uuid1);

    $uuid2 = $this->createMock(UuidInterface::class);
    $uuid2->method('toString')->willReturn('uuid2');
    $entity2 = $this->createMock(UuidIdentifiable::class);
    $entity2->method('getId')->willReturn($uuid2);

    $uuid3 = $this->createMock(UuidInterface::class);
    $uuid3->method('toString')->willReturn('uuid3');
    $entity3 = $this->createMock(UuidIdentifiable::class);
    $entity3->method('getId')->willReturn($uuid3);

    $entities = [$entity1, $entity2, $entity3];

    $result = Helper::mapEntitiesById($entities);

    $this->assertCount(3, $result);
    $this->assertSame($entity1, $result['uuid1']);
    $this->assertSame($entity2, $result['uuid2']);
    $this->assertSame($entity3, $result['uuid3']);
}

}
