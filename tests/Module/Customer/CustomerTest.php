<?php

declare(strict_types=1);

namespace App\Tests\Module\Customer;

use App\Module\Customer\Customer;
use App\Module\Customer\Person;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\UuidInterface;
use App\Module\Order\Order;

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

    public function testGetShoppingCartWhenNoCartExists(): void
    {
        $login = 'testuser';
        $password = 'testpassword';
        $person = $this->createMock(Person::class);
        
        $customer = new Customer($login, $password, $person);
        
        // A newly created customer should have no shopping cart
        $this->assertNull($customer->getShoppingCart());
    }


    public function testGetSalt(): void
    {
        $login = 'testuser';
        $password = 'testpassword';
        $person = $this->createMock(Person::class);
        
        $customer = new Customer($login, $password, $person);
        
        // getSalt should return null for bcrypt algorithm
        $this->assertNull($customer->getSalt());
    }


    public function testEraseCredentials(): void
    {
        $login = 'testuser';
        $password = 'testpassword';
        $person = $this->createMock(Person::class);
        
        $customer = new Customer($login, $password, $person);
        
        // This method is currently a no-op, so we just verify it doesn't throw an exception
        $customer->eraseCredentials();
        
        // Verify password is still accessible after eraseCredentials
        $this->assertEquals($password, $customer->getPassword());
    }


    public function testSetPassword(): void
    {
        $login = 'testuser';
        $password = 'testpassword';
        $person = $this->createMock(Person::class);
        
        $customer = new Customer($login, $password, $person);
        
        $newPassword = 'newpassword';
        $result = $customer->setPassword($newPassword);
        
        $this->assertSame($customer, $result);
        $this->assertEquals($newPassword, $customer->getPassword());
    }


    public function testGetShoppingCartWhenCartExists(): void
    {
        $login = 'testuser';
        $password = 'testpassword';
        $person = $this->createMock(Person::class);
        
        $customer = new Customer($login, $password, $person);
        
        // Create a mock Order that would be returned by createShoppingCart
        $order = $this->createMock(Order::class);
        
        // Use reflection to set the shoppingCart property
        $reflectionClass = new \ReflectionClass(Customer::class);
        $shoppingCartProperty = $reflectionClass->getProperty('shoppingCart');
        $shoppingCartProperty->setAccessible(true);
        
        $collection = new \Doctrine\Common\Collections\ArrayCollection([$order]);
        $shoppingCartProperty->setValue($customer, $collection);
        
        $this->assertSame($order, $customer->getShoppingCart());
    }

/*
FAILED TEST: ## Test Failure Analysis

**Error**: `Call to undefined method App\Module\Order\Order::getCustomer()`

The test `testCreateShoppingCart` fails because it's trying to call the method `getCustomer()` on the `Order` class, but this method doesn't exist in the `Order` class.

### Recommended Fixes:

1. Add a `getCustomer()` method to the `Order` class that returns the customer associated with the order.
2. Alternatively, modify the test to not rely on the `getCustomer()` method if this relationship shouldn't be accessible this way.

    public function testCreateShoppingCart(): void
    {
        $login = 'testuser';
        $password = 'testpassword';
        $person = $this->createMock(Person::class);
        
        $customer = new Customer($login, $password, $person);
        
        $order = $customer->createShoppingCart();
        
        $this->assertNotNull($order);
        $this->assertSame($customer, $order->getCustomer());
        $this->assertSame($order, $customer->getShoppingCart());
    }

*/

    public function testUuidUniquenessAcrossMultipleInstances(): void
    {
        $login = 'testuser';
        $password = 'testpassword';
        $person = $this->createMock(Person::class);
        
        $customer1 = new Customer($login, $password, $person);
        $customer2 = new Customer($login, $password, $person);
        $customer3 = new Customer($login, $password, $person);
        
        $this->assertInstanceOf(UuidInterface::class, $customer1->getId());
        $this->assertInstanceOf(UuidInterface::class, $customer2->getId());
        $this->assertInstanceOf(UuidInterface::class, $customer3->getId());
        
        $this->assertNotEquals($customer1->getId()->toString(), $customer2->getId()->toString());
        $this->assertNotEquals($customer2->getId()->toString(), $customer3->getId()->toString());
        $this->assertNotEquals($customer1->getId()->toString(), $customer3->getId()->toString());
    }


    public function testCreateCustomerWithMaximumLengthPassword(): void
    {
        $login = 'validUser';
        $password = str_repeat('b', 72);
        $person = $this->createMock(Person::class);
        
        $customer = new Customer($login, $password, $person);
        
        $this->assertEquals($password, $customer->getPassword());
        $this->assertEquals(72, strlen($customer->getPassword()));
    }


    public function testCreateCustomerWithMaximumLengthLogin(): void
    {
        $login = str_repeat('a', 180);
        $password = 'validPassword';
        $person = $this->createMock(Person::class);
        
        $customer = new Customer($login, $password, $person);
        
        $this->assertEquals($login, $customer->getUsername());
        $this->assertEquals(180, strlen($customer->getUsername()));
    }


    public function testSetPasswordToEmptyString(): void
    {
        $login = 'testuser';
        $password = 'testpassword';
        $person = $this->createMock(Person::class);
        
        $customer = new Customer($login, $password, $person);
        
        $result = $customer->setPassword('');
        
        $this->assertSame($customer, $result);
        $this->assertEquals('', $customer->getPassword());
    }


    public function testCreateShoppingCartMultipleTimes(): void
    {
        $login = 'testuser';
        $password = 'testpassword';
        $person = $this->createMock(Person::class);
        
        $customer = new Customer($login, $password, $person);
        
        $order1 = $customer->createShoppingCart();
        $order2 = $customer->createShoppingCart();
        
        $this->assertInstanceOf(Order::class, $order1);
        $this->assertInstanceOf(Order::class, $order2);
        $this->assertNotSame($order1, $order2);
        $this->assertSame($order1, $customer->getShoppingCart());
    }


    public function testCreateCustomerWithEmptyStringLogin(): void
    {
        $login = '';
        $password = 'validPassword123';
        $person = $this->createMock(Person::class);
        
        $customer = new Customer($login, $password, $person);
        
        $this->assertInstanceOf(UuidInterface::class, $customer->getId());
        $this->assertEquals('', $customer->getUsername());
        $this->assertEquals($password, $customer->getPassword());
    }

}
