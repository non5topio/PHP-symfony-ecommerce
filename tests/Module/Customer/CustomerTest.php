<?php

declare(strict_types=1);

namespace App\Tests\Module\Customer;

use App\Module\Customer\Customer;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\UuidInterface;

class CustomerTest extends TestCase
{
    // Test cases will be added here
/*
FAILED TEST: The test run failed due to an **incompatible version of `ramsey/uuid`** with PHP 7.5+. Specifically, the `Uuid::unserialize` method returns `void`, which is not compatible with the `Serializable::unserialize` interface in PHP 7.5+.

### Root Cause:
- `ramsey/uuid` version in use has a method signature incompatible with PHP 7.5+.
- PHPUnit attempts to serialize/deserialize `Uuid` instances, triggering a **fatal error**.

### Recommended Fix:
Upgrade `ramsey/uuid` to a **compatible version (preferably ^4.2 or newer)** by running:

```bash
composer update ramsey/uuid
```

    public function testEraseCredentialsDoesNotModifyData(): void
    {
        $person = $this->createMock(Person::class);
        $customer = new Customer('john.doe@example.com', 'SecurePassword123!', $person);
    
        $originalPassword = $customer->getPassword();
    
        $customer->eraseCredentials();
    
        $this->assertSame($originalPassword, $customer->getPassword());
    }

*/
/*
FAILED TEST: The test run failed due to an **incompatible method signature** in the `Ramsey\Uuid\Uuid::unserialize` method, which returns `void`, conflicting with the expected `Serializable::unserialize` interface in **PHP 7.5+**.

### Root Cause:
- The installed version of `ramsey/uuid` is **not compatible with PHP 7.5+**.
- PHPUnit attempts to serialize/deserialize `Uuid` instances during test execution, triggering a **fatal error**.

### Recommended Fix:
Upgrade `ramsey/uuid` to a **compatible version (preferably ^4.2 or newer)** by running:

```bash
composer update ramsey/uuid
```

    public function testGetRolesReturnsDefaultRoles(): void
    {
        $person = $this->createMock(Person::class);
        $customer = new Customer('john.doe@example.com', 'SecurePassword123!', $person);
    
        $this->assertSame(['ROLE_CUSTOMER'], $customer->getRoles());
    }

*/
/*
FAILED TEST: The test run failed due to an **incompatible method signature** in the `Ramsey\Uuid\Uuid::unserialize` method, which returns `void`, conflicting with the expected `Serializable::unserialize` interface in PHP 7.5+.

### Root Cause:
- The installed version of `ramsey/uuid` is **not compatible with PHP 7.5+**, causing a **fatal error** during test execution when PHPUnit attempts to serialize/deserialize a `Uuid` instance.

### Recommended Fix:
Upgrade the `ramsey/uuid` package to a **version compatible with PHP 7.5+**, preferably **^4.2** or newer.

Run:
```bash
composer update ramsey/uuid
```

    public function testGetUsernameReturnsLogin(): void
    {
        $person = $this->createMock(Person::class);
        $customer = new Customer('john.doe@example.com', 'SecurePassword123!', $person);
    
        $this->assertSame('john.doe@example.com', $customer->getUsername());
    }

*/
/*
FAILED TEST: The test run failed due to an **incompatible method signature** in the `Ramsey\Uuid\Uuid::unserialize` method, which returns `void`, conflicting with the expected signature of `Serializable::unserialize`.

### Root Cause:
- The `ramsey/uuid` package version being used is **not compatible with PHP 7.5+**, causing a **fatal error** during test execution when PHPUnit attempts to serialize/deserialize a `Uuid` instance.

### Recommended Fix:
Upgrade the `ramsey/uuid` package to a **version compatible with PHP 7.5+**, preferably **^4.2** or newer.

Run:
```bash
composer update ramsey/uuid
```

    public function testCreateShoppingCartAddsNewOrder(): void
    {
        $person = $this->createMock(Person::class);
        $customer = new Customer('john.doe@example.com', 'SecurePassword123!', $person);
    
        $order = $customer->createShoppingCart();
    
        $this->assertInstanceOf(\App\Module\Order\Order::class, $order);
        $this->assertSame($order, $customer->getShoppingCart());
        $this->assertCount(1, $customer->shoppingCart);
    }

*/
/*
FAILED TEST: The test run failed due to an **incompatible method signature** in the `Ramsey\Uuid\Uuid::unserialize` method, which returns `void`, conflicting with the expected signature of `Serializable::unserialize`.

### Root Cause:
- PHPUnit is attempting to serialize/deserialize a `Uuid` instance during test execution, triggering a **fatal error** due to the incompatible return type.

### Recommended Fix:
Upgrade the `ramsey/uuid` package to a **version compatible with PHP 7.5+**, preferably **^4.2** or newer, where this issue was resolved.

Run:
```bash
composer update ramsey/uuid
```

    public function testGetShoppingCartReturnsNullWhenEmpty(): void
    {
        $person = $this->createMock(Person::class);
        $customer = new Customer('john.doe@example.com', 'SecurePassword123!', $person);
    
        $this->assertNull($customer->getShoppingCart());
    }

*/
/*
FAILED TEST: The test failed due to an **incompatible method signature** in the `Ramsey\Uuid\Uuid` class, specifically the `unserialize` method. It declares a return type of `void`, which is not compatible with the `Serializable::unserialize` method that expects no return type declaration.

### Root Cause:
- **PHPUnit is attempting to serialize/deserialize a `Uuid` instance**, likely during test setup or mocking, and the incompatibility causes a **fatal error**.

### Recommended Fix:
Upgrade the `ramsey/uuid` package to a version **compatible with PHP 7.5+**, preferably **^4.2** or newer, where this issue was resolved.

Run:
```bash
composer update ramsey/uuid
```

If upgrading is not possible, consider using `Uuid::uuid4()` in a way that avoids triggering serialization during tests, or mock the Uuid behavior more explicitly.

    public function testCustomerIsCreatedWithValidParameters(): void
    {
        $person = $this->createMock(\App\Module\Customer\Person::class);
        $customer = new Customer('john.doe@example.com', 'SecurePassword123!', $person);
    
        $this->assertInstanceOf(\Ramsey\Uuid\UuidInterface::class, $customer->getId());
        $this->assertInstanceOf(\Doctrine\Common\Collections\Collection::class, $customer->orders);
        $this->assertInstanceOf(\Doctrine\Common\Collections\Collection::class, $customer->shoppingCart);
        $this->assertSame('john.doe@example.com', $customer->getUsername());
        $this->assertSame('SecurePassword123!', $customer->getPassword());
        $this->assertSame($person, $customer->person);
    }

*/
}
