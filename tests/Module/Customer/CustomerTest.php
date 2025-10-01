<?php

declare(strict_types=1);

namespace App\Tests\Module\Customer;

use App\Module\Customer\Customer;
use App\Module\Customer\Person;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\UuidInterface;

class CustomerTest extends TestCase
{
    public function testConstructorAndBasicGetters(): void
    {
        $login = 'testuser';
        $password = 'testpassword';
        $person = $this->createMock(Person::class);
        
        $customer = new Customer($login, $password, $person);
        
        $this->assertInstanceOf(UuidInterface::class, $customer->getId());
        $this->assertEquals($login, $customer->getUsername());
        $this->assertEquals($password, $customer->getPassword());
        $this->assertEquals(['ROLE_CUSTOMER'], $customer->getRoles());
        $this->assertNull($customer->getShoppingCart());
    }
}
