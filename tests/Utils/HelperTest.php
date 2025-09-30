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
                 return 'key';
             });
         
             $this->assertCount(1, $result);
             $this->assertSame($object2, $result['key']);
         }


         public function testMapObjectsFromUserKeyWithEmptyIterable()
         {
             $objects = [];
         
             $result = Helper::mapObjectsFromUserKey($objects, function($object) {
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
