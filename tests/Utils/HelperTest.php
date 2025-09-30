<?php

namespace App\Tests;

use App\Tests\Utils\Resource\Entity;
use App\Utils\Helper;
use PHPUnit\Framework\TestCase;

class HelperTest extends TestCase
{
    public function testMapObjectsFromUserKey(): void
    {
        $entities = [];
        $mappedByIds = [];
        foreach ($entities as $entity) {
            $mappedByIds[$entity->getName()] = $entity;
        }

        $result = Helper::mapObjectsFromUserKey($entities, function (Entity $object) {
            return $object->getName();
        });

        $this->assertEquals($mappedByIds, $result);
    }
}
