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
/*
FAILED TEST: The test run failed due to a **syntax error** in `CustomerTest.php` on **line 16**: the method `testConstructorAndBasicGetters()` is declared without a method body or a closing brace, causing a parse error when the next method is defined.

**Fix:**  
Add the missing method body or properly close the `testConstructorAndBasicGetters()` method before defining the next test method.

    public function testConstructorThrowsExceptionForInvalidLogin(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $password = 'testpassword';
        $person = $this->createMock(Person::class);
    
        new Customer(null, $password, $person);
    }

*/
/*
FAILED TEST: The test run failed due to a **syntax error** in `CustomerTest.php` on **line 16**, where the method `testConstructorAndBasicGetters()` is declared without a method body or a closing brace. This causes a parse error when the next method is defined.

**Fix:**  
Add the missing method body or properly close the `testConstructorAndBasicGetters()` method before defining the next test method.

    public function testCreateShoppingCartAddsNewOrderToCart(): void
    {
        $login = 'testuser';
        $password = 'testpassword';
        $person = $this->createMock(Person::class);
        $initialOrder = $this->createMock(Order::class);
    
        $customer = new Customer($login, $password, $person);
        $customer->shoppingCart[] = $initialOrder;
    
        $newOrder = $customer->createShoppingCart();
    
        $this->assertInstanceOf(Order::class, $newOrder);
        $this->assertCount(2, $customer->shoppingCart);
    }

*/
/*
FAILED TEST: **Analysis:**  
The test run failed due to a **syntax error** in `CustomerTest.php` on line 16. The method `testConstructorAndBasicGetters()` is declared without a method body or a closing brace, which causes a parse error when the next method is defined.

**Fix:**  
Add the missing method body or properly close the `testConstructorAndBasicGetters()` method before defining the next test method.

    public function testGetShoppingCartReturnsNullWhenCartIsEmpty(): void
    {
        $login = 'testuser';
        $password = 'testpassword';
        $person = $this->createMock(Person::class);
    
        $customer = new Customer($login, $password, $person);
    
        $this->assertNull($customer->getShoppingCart());
    }

*/
/*
FAILED TEST: The test file `CustomerTest.php` contains a syntax error due to a missing method body for close the `testConstructorAndBasicGetters()` method before defining `testGetShoppingCartReturnsFirstOrderWhenMultipleOrdersExist()`.

**Fix:**  
Add the missing method body or closing brace for `testConstructorAndBasicGetters()` before the next method definition.

    public function testGetShoppingCartReturnsFirstOrderWhenMultipleOrdersExist(): void
    {
        $login = 'testuser';
        $password = 'testpassword';
        $person = $this->createMock(Person::class);
        $order1 = $this->createMock(Order::class);
        $order2 = $this->createMock(Order::class);
        $order3 = $this->createMock(Order::class);
    
        $customer = new Customer($login, $password, $person);
        $customer->shoppingCart[] = $order1;
        $customer->shoppingCart[] = $order2;
        $customer->shoppingCart[] = $order3;
    
        $this->assertSame($order1, $customer->getShoppingCart());
    }

*/
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
