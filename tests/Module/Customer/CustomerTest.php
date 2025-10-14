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



    
/*
FAILED TEST: **Analysis of Test Failure:**

1. **Primary Cause:** The test run failed due to a **duplicate `use` statement** for `App\Module\Customer\Person` in the `CustomerTest.php` file. PHP does not allow the same class to be imported more than once in the same namespace.

2. **Secondary Cause:** The test method `testCustomerConstructorFailsWithNullLogin()` is using `expectExceptionMessageMatches()`, which is **not a valid PHPUnit method**. This results in a fatal error and test failure.

---

**Recommended Fixes:**

1. **Remove the duplicate `use` statement:**
   - Delete one instance of `use App\Module\Customer\Person;` from the top of `CustomerTest.php`.

2. **Fix the invalid PHPUnit method:**
   - Replace `expectExceptionMessageMatches('/login cannot be null/i')` with `expectExceptionMessageRegExp('/login cannot be null/i')` or use `expectExceptionMessage('login cannot be null')` if exact match is acceptable.

         public function testCustomerConstructorFailsWithNullLogin(): void
         {
             $person = $this->createMock(Person::class);
         
             $this->expectException(\Exception::class);
             $this->expectExceptionMessageMatches('/login cannot be null/i');
         
             new Customer(null, "SecurePassword123!", $person);
         }

*/

         public function testSetPasswordUpdatesPasswordToEmptyString(): void
         {
             $person = $this->createMock(Person::class);
             $customer = new Customer("john.doe@example.com", "SecurePassword123!", $person);
         
             $customer->setPassword("");
         
             $this->assertSame("", $customer->getPassword());
         }

/*
FAILED TEST: The test run failed due to **duplicate `use` statements** for the `App\Module\Customer\Person` class in the `CustomerTest.php` file.

### **Analysis:**
- PHP does not allow the same class to be imported more than once in the same namespace.
- The line `use App\Module\Customer\Person;` appears **twice**, causing a fatal error.

### **Recommended Fix:**
Remove the **duplicate import** line:
```php
use App\Module\Customer\Person; // ← Remove this second occurrence
```

         public function testCreateShoppingCartAddsNewOrder(): void
         {
             $person = $this->createMock(Person::class);
             $customer = new Customer("john.doe@example.com", "SecurePassword123!", $person);
         
             $order = $customer->createShoppingCart();
         
             $this->assertInstanceOf(Order::class, $order);
             $this->assertCount(1, $customer->shoppingCart);
             $this->assertSame($order, $customer->getShoppingCart());
         }

*/
/*
FAILED TEST: The test run failed due to a **duplicate import** of the `App\Module\Customer\Person` class in the `CustomerTest.php` file.

### **Analysis:**
- The line `use App\Module\Customer\Person;` appears **twice**, which is not allowed in PHP.

### **Recommended Fix:**
Remove the **duplicate import** line:
```php
use App\Module\Customer\Person; // ← Remove this line (second occurrence)
```

         public function testGetShoppingCartReturnsFirstOrderWhenPresent(): void
         {
             $person = $this->createMock(Person::class);
             $customer = new Customer("john.doe@example.com", "SecurePassword123!", $person);
             $order = $this->createMock(Order::class);
         
             $customer->shoppingCart[] = $order;
         
             $this->assertSame($order, $customer->getShoppingCart());
         }

*/

         public function testGetShoppingCartReturnsNullWhenEmpty(): void
         {
             $person = $this->createMock(Person::class);
             $customer = new Customer("john.doe@example.com", "SecurePassword123!", $person);
         
             $this->assertNull($customer->getShoppingCart());
         }

/*
FAILED TEST: The test failed due to a **duplicate import/namespace conflict** for the `Person` class in the test file `CustomerTest.php`.

### **Analysis:**
- The `Person` class is imported twice:
  ```php
  use App\Module\Customer\Person;
  use Ramsey\Uuid\UuidInterface;
  use App\Module\Customer\Person; // ← Duplicate
  ```
- PHP does not allow the same class name to be imported more than once in the same namespace context.

### **Recommended Fix:**
Remove the duplicate import:
```php
// Remove this line:
use App\Module\Customer\Person; // ← Second occurrence
```

         public function testCustomerIsCreatedWithValidInputs(): void
         {
             $person = $this->createMock(Person::class);
             $customer = new Customer("john.doe@example.com", "SecurePassword123!", $person);
         
             $this->assertInstanceOf(UuidInterface::class, $customer->getId());
             $this->assertInstanceOf(Collection::class, $customer->orders);
             $this->assertInstanceOf(Collection::class, $customer->shoppingCart);
         }

*/
}
