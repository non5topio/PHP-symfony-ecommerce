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


    public function test_get_shopping_cart_when_empty(): void
    {
        // Arrange
        $person = $this->createMock(Person::class);
        $customer = new Customer('user@example.com', 'password', $person);
        
        // Act
        $shoppingCart = $customer->getShoppingCart();
        
        // Assert
        $this->assertNull($shoppingCart);
    }


    public function test_get_and_set_password(): void
    {
        // Arrange
        $initialPassword = 'initialHash';
        $newPassword = 'newHashedPassword';
        $person = $this->createMock(Person::class);
        $customer = new Customer('user@example.com', $initialPassword, $person);
        
        // Assert initial password
        $this->assertEquals($initialPassword, $customer->getPassword());
        
        // Act
        $result = $customer->setPassword($newPassword);
        
        // Assert
        $this->assertSame($customer, $result);
        $this->assertEquals($newPassword, $customer->getPassword());
    }


    public function test_get_roles_returns_default_customer_role(): void
    {
        // Arrange
        $person = $this->createMock(Person::class);
        $customer = new Customer('user@example.com', 'password', $person);
        
        // Act
        $roles = $customer->getRoles();
        
        // Assert
        $this->assertIsArray($roles);
        $this->assertCount(1, $roles);
        $this->assertEquals(['ROLE_CUSTOMER'], $roles);
    }


    public function test_get_username_returns_login(): void
    {
        // Arrange
        $login = 'test.user@example.com';
        $person = $this->createMock(Person::class);
        $customer = new Customer($login, 'password', $person);
        
        // Act
        $username = $customer->getUsername();
        
        // Assert
        $this->assertIsString($username);
        $this->assertEquals($login, $username);
    }


    public function test_get_id_returns_valid_uuid(): void
    {
        // Arrange
        $person = $this->createMock(Person::class);
        $customer = new Customer('test@example.com', 'password', $person);
        
        // Act
        $id = $customer->getId();
        
        // Assert
        $this->assertInstanceOf(UuidInterface::class, $id);
        $this->assertEquals(4, $id->getVersion());
    }


    public function test_create_customer_with_valid_parameters(): void
    {
        // Arrange
        $login = 'john.doe@example.com';
        $password = 'hashedPassword123';
        $person = $this->createMock(Person::class);
        
        // Act
        $customer = new Customer($login, $password, $person);
        
        // Assert
        $this->assertInstanceOf(Customer::class, $customer);
        $this->assertInstanceOf(UuidInterface::class, $customer->getId());
        $this->assertEquals($login, $customer->getUsername());
        $this->assertEquals($password, $customer->getPassword());
        $this->assertEquals(['ROLE_CUSTOMER'], $customer->getRoles());
        $this->assertNull($customer->getShoppingCart());
    }

    
}
