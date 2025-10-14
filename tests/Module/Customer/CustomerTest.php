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




    public function test_create_customer_with_max_length_password(): void
    {
        // Arrange
        $maxLengthPassword = str_repeat('b', 72);
        $person = $this->createMock(Person::class);
        
        // Act
        $customer = new Customer('test@example.com', $maxLengthPassword, $person);
        
        // Assert
        $this->assertSame($maxLengthPassword, $customer->getPassword());
        $this->assertSame(72, strlen($customer->getPassword()));
    }


    public function test_create_customer_with_max_length_login(): void
    {
        // Arrange
        $maxLengthLogin = str_repeat('a', 180);
        $person = $this->createMock(Person::class);
        
        // Act
        $customer = new Customer($maxLengthLogin, 'password123', $person);
        
        // Assert
        $this->assertSame($maxLengthLogin, $customer->getUsername());
        $this->assertSame(180, strlen($customer->getUsername()));
    }


    public function test_get_salt_returns_null(): void
    {
        // Arrange
        $person = $this->createMock(Person::class);
        $customer = new Customer('test@example.com', 'password123', $person);
        
        // Act
        $salt = $customer->getSalt();
        
        // Assert
        $this->assertNull($salt);
    }


    public function test_erase_credentials_executes_without_errors(): void
    {
        // Arrange
        $person = $this->createMock(Person::class);
        $customer = new Customer('test@example.com', 'password123', $person);
        $passwordBefore = $customer->getPassword();
        
        // Act
        $customer->eraseCredentials();
        
        // Assert
        $this->assertSame($passwordBefore, $customer->getPassword());
    }


    public function test_get_shopping_cart_returns_existing_order(): void
    {
        // Arrange
        $person = $this->createMock(Person::class);
        $customer = new Customer('test@example.com', 'password123', $person);
        $order = $customer->createShoppingCart();
        
        // Act
        $retrievedOrder = $customer->getShoppingCart();
        
        // Assert
        $this->assertInstanceOf(Order::class, $retrievedOrder);
        $this->assertSame($order, $retrievedOrder);
    }


    public function test_create_shopping_cart_adds_order_to_collection(): void
    {
        // Arrange
        $person = $this->createMock(Person::class);
        $customer = new Customer('test@example.com', 'password123', $person);
        
        // Act
        $order = $customer->createShoppingCart();
        
        // Assert
        $this->assertInstanceOf(Order::class, $order);
        $this->assertSame($order, $customer->getShoppingCart());
    }


    public function test_get_shopping_cart_returns_null_when_empty(): void
    {
        // Arrange
        $login = "user@example.com";
        $password = "password";
        $person = $this->createMock(Person::class);
        $customer = new Customer($login, $password, $person);
        
        // Act
        $shoppingCart = $customer->getShoppingCart();
        
        // Assert
        $this->assertNull($shoppingCart);
    }


    public function test_set_password_updates_password_and_returns_self(): void
    {
        // Arrange
        $login = "user@example.com";
        $oldPassword = "old_password";
        $newPassword = "new_hashed_password";
        $person = $this->createMock(Person::class);
        $customer = new Customer($login, $oldPassword, $person);
        
        // Act
        $result = $customer->setPassword($newPassword);
        
        // Assert
        $this->assertSame($customer, $result);
        $this->assertEquals($newPassword, $customer->getPassword());
        $this->assertNotEquals($oldPassword, $customer->getPassword());
    }


    public function test_get_password_returns_hashed_password(): void
    {
        // Arrange
        $login = "user@example.com";
        $password = "hashed_bcrypt_password";
        $person = $this->createMock(Person::class);
        $customer = new Customer($login, $password, $person);
        
        // Act
        $retrievedPassword = $customer->getPassword();
        
        // Assert
        $this->assertIsString($retrievedPassword);
        $this->assertEquals("hashed_bcrypt_password", $retrievedPassword);
    }


    public function test_get_roles_returns_default_role(): void
    {
        // Arrange
        $login = "user@example.com";
        $password = "password";
        $person = $this->createMock(Person::class);
        $customer = new Customer($login, $password, $person);
        
        // Act
        $roles = $customer->getRoles();
        
        // Assert
        $this->assertIsArray($roles);
        $this->assertCount(1, $roles);
        $this->assertContains('ROLE_CUSTOMER', $roles);
        $this->assertEquals(['ROLE_CUSTOMER'], $roles);
    }


    public function test_get_username_returns_login(): void
    {
        // Arrange
        $login = "test.user@example.com";
        $password = "password123";
        $person = $this->createMock(Person::class);
        $customer = new Customer($login, $password, $person);
        
        // Act
        $username = $customer->getUsername();
        
        // Assert
        $this->assertIsString($username);
        $this->assertEquals("test.user@example.com", $username);
    }


    public function test_customer_creation_with_valid_data(): void
    {
        // Arrange
        $login = "john.doe@example.com";
        $password = "hashed_password_string";
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
