<?php

declare(strict_types=1);

namespace App\Tests\Security;

use App\Module\Customer\Customer;
use App\Module\Order\Service\ShoppingCart;
use App\Security\CustomerAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
class CustomerAuthenticatorTest extends TestCase
{

    

/*
FAILED TEST: ## Analysis

**Root Cause:**
The test file contains multiple duplicate method declarations. PHP throws a fatal error during class loading when it encounters `test_supports_returns_false_for_get_request()` declared multiple times (including at line 639), preventing any tests from executing.

**Why It Failed:**
PHP does not allow methods with identical names within the same class. The parser encounters these duplicate declarations during class loading and immediately throws a fatal error before the test suite can run.

**Recommended Fixes:**

1. **Remove ALL duplicate method declarations** - The following methods appear multiple times in the file:
   - `test_supports_returns_false_for_get_request()` (duplicate at line 639)
   - `test_authentication_fails_with_incorrect_password()` (duplicate at line 614)
   - `test_authentication_fails_with_nonexistent_user()` (duplicate at line 590)
   - `test_authentication_fails_with_invalid_csrf_token()` (duplicate at line 561)
   - `test_successful_authentication_with_target_path_redirect()` (duplicate at line 531)
   - `test_successful_authentication_with_valid_credentials()` (duplicate at line 510)

2. **Add missing imports**:
   ```php
   use App\Module\Customer\Customer;
   use App\Module\Order\Service\ShoppingCart;
   ```

3. **Complete all incomplete test methods** - Ensure all test method declarations have proper opening braces `{` and complete implementations.

4. **Systematically review the entire file** - The file appears structurally corrupted. Consider regenerating it from scratch to ensure no other duplicates or syntax errors exist.

    public function test_supports_returns_false_for_get_request(): void
    {
        // Arrange
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $router = $this->createMock(RouterInterface::class);
        $csrfTokenManager = $this->createMock(CsrfTokenManagerInterface::class);
        $passwordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $cart = $this->createMock(ShoppingCart::class);
        
        $authenticator = new CustomerAuthenticator($entityManager, $router, $csrfTokenManager, $passwordEncoder, $cart);
        
        $request = $this->createMock(Request::class);
        $request->attributes = new \Symfony\Component\HttpFoundation\ParameterBag(['_route' => 'customer_login']);
        $request->method('isMethod')->with('POST')->willReturn(false);
        
        // Act
        $result = $authenticator->supports($request);
        
        // Assert
        $this->assertFalse($result);
    }

*/
/*
FAILED TEST: ## Test Failure Analysis

**Root Cause:**
The test file contains **multiple duplicate method declarations**. PHP fatal error occurs because `test_authentication_fails_with_incorrect_password()` is declared at least twice (including line 614), and several other test methods are also duplicated throughout the file.

**Why It Failed:**
PHP does not allow methods with identical names within the same class. During class loading, PHP encounters the redeclared methods and throws a fatal error before any tests can execute.

**Recommended Fixes:**

1. **Remove ALL duplicate method declarations** - The following methods appear multiple times and must be deduplicated:
   - `test_authentication_fails_with_incorrect_password()` (duplicate at line 614)
   - `test_authentication_fails_with_nonexistent_user()` (duplicate at line 590)
   - `test_authentication_fails_with_invalid_csrf_token()` (duplicate at line 561)
   - `test_successful_authentication_with_target_path_redirect()` (duplicate at line 531)
   - `test_successful_authentication_with_valid_credentials()` (duplicate at line 510)

2. **Add missing imports**:
   ```php
   use App\Module\Customer\Customer;
   use App\Module\Order\Service\ShoppingCart;
   ```

3. **Complete all incomplete test methods** - Ensure all test method declarations have proper opening braces `{` and complete implementations.

4. **Systematically review the entire file** - The file appears corrupted with structural issues. Consider regenerating or carefully reconstructing it from scratch.

    public function test_authentication_fails_with_incorrect_password(): void
    {
        // Arrange
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $router = $this->createMock(RouterInterface::class);
        $csrfTokenManager = $this->createMock(CsrfTokenManagerInterface::class);
        $passwordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $cart = $this->createMock(ShoppingCart::class);
        
        $customer = $this->createMock(Customer::class);
        
        $authenticator = new CustomerAuthenticator($entityManager, $router, $csrfTokenManager, $passwordEncoder, $cart);
        
        $credentials = [
            'login' => 'valid_user@example.com',
            'password' => 'WrongPassword123',
            'csrf_token' => 'valid_csrf_token'
        ];
        
        // Setup password validation to fail
        $passwordEncoder->method('isPasswordValid')->with($customer, 'WrongPassword123')->willReturn(false);
        
        // Act
        $result = $authenticator->checkCredentials($credentials, $customer);
        
        // Assert
        $this->assertFalse($result);
    }

*/
/*
FAILED TEST: ## Test Failure Analysis

**Root Cause:**
Fatal error due to duplicate method declaration: `test_authentication_fails_with_nonexistent_user()` appears multiple times in the test class (line 590 and at least one other location). PHP does not allow methods with identical names in the same class.

**Why It Failed:**
The test file cannot be loaded because PHP encounters a redeclared method during class parsing, causing a fatal error before any tests can execute.

**Recommended Fixes:**

1. **Remove all duplicate method declarations** - Search the entire test file and eliminate duplicates of:
   - `test_authentication_fails_with_nonexistent_user()` (duplicate at line 590)
   - `test_authentication_fails_with_invalid_csrf_token()` (mentioned at line 561)
   - `test_successful_authentication_with_target_path_redirect()` (mentioned at line 531)
   - `test_successful_authentication_with_valid_credentials()` (mentioned at line 510)

2. **Complete all incomplete test methods** - Many methods are missing opening braces `{` and implementations. Ensure all test methods have proper structure:
   ```php
   public function test_method_name(): void
   {
       // complete implementation
   }
   ```

3. **Add missing imports**:
   ```php
   use App\Module\Customer\Customer;
   use App\Module\Order\Service\ShoppingCart;
   use Doctrine\ORM\EntityRepository;
   ```

4. **Verify the file integrity** - The test file appears corrupted with multiple structural issues. Consider reviewing the entire file systematically from top to bottom.

    public function test_authentication_fails_with_nonexistent_user(): void
    {
        // Arrange
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $router = $this->createMock(RouterInterface::class);
        $csrfTokenManager = $this->createMock(CsrfTokenManagerInterface::class);
        $passwordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $cart = $this->createMock(ShoppingCart::class);
        $userProvider = $this->createMock(UserProviderInterface::class);
        
        $repository = $this->createMock(EntityRepository::class);
        
        $authenticator = new CustomerAuthenticator($entityManager, $router, $csrfTokenManager, $passwordEncoder, $cart);
        
        $credentials = [
            'login' => 'nonexistent@example.com',
            'password' => 'AnyPassword123',
            'csrf_token' => 'valid_csrf_token'
        ];
        
        // Setup CSRF validation to pass
        $csrfTokenManager->method('isTokenValid')->willReturn(true);
        
        // Setup user lookup to return null
        $entityManager->method('getRepository')->with(Customer::class)->willReturn($repository);
        $repository->method('findOneBy')->with(['login' => 'nonexistent@example.com'])->willReturn(null);
        
        // Expect exception
        $this->expectException(CustomUserMessageAuthenticationException::class);
        $this->expectExceptionMessage('Login could not be found.');
        
        // Act
        $authenticator->getUser($credentials, $userProvider);
    }

*/
/*
FAILED TEST: ## Test Failure Analysis

**Root Cause:**
Fatal error due to duplicate method declaration: `test_authentication_fails_with_invalid_csrf_token()` appears multiple times in the test class (line 561 and at least one other location).

**Why It Failed:**
PHP does not allow methods with identical names in the same class. The fatal error occurs during class loading, before any tests can execute.

**Recommended Fixes:**

1. **Remove all duplicate method declarations** - Search the entire test file for these duplicate methods and keep only one instance of each:
   - `test_authentication_fails_with_invalid_csrf_token()` (duplicate at line 561)
   - `test_successful_authentication_with_target_path_redirect()` (mentioned as duplicate at line 531)
   - `test_successful_authentication_with_valid_credentials()` (mentioned as duplicate at line 510)

2. **Complete all incomplete test method structures** - Many test methods are missing opening braces `{` and complete implementations. Fix all incomplete methods.

3. **Add missing imports** at the top of the test file:
   ```php
   use App\Module\Customer\Customer;
   use App\Module\Order\Service\ShoppingCart;
   use Doctrine\ORM\EntityRepository;
   ```

4. **Verify no other duplicates exist** - Scan the entire file for any other duplicate method names before running tests again.

    public function test_authentication_fails_with_invalid_csrf_token(): void
    {
        // Arrange
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $router = $this->createMock(RouterInterface::class);
        $csrfTokenManager = $this->createMock(CsrfTokenManagerInterface::class);
        $passwordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $cart = $this->createMock(ShoppingCart::class);
        $userProvider = $this->createMock(UserProviderInterface::class);
        
        $authenticator = new CustomerAuthenticator($entityManager, $router, $csrfTokenManager, $passwordEncoder, $cart);
        
        $credentials = [
            'login' => 'valid_user@example.com',
            'password' => 'ValidPassword123',
            'csrf_token' => 'invalid_or_expired_token'
        ];
        
        // Setup CSRF validation to fail
        $csrfTokenManager->method('isTokenValid')->willReturn(false);
        
        // Expect exception
        $this->expectException(InvalidCsrfTokenException::class);
        
        // Act
        $authenticator->getUser($credentials, $userProvider);
    }

*/
/*
FAILED TEST: ## Test Failure Analysis

**Root Cause:**
The test file contains a **duplicate method declaration** for `test_successful_authentication_with_target_path_redirect()` - it appears twice in the same class (once at the beginning and again at line 531).

**Why It Failed:**
PHP does not allow methods with identical names in the same class. This causes a fatal error during class loading, preventing any tests from executing.

**Recommended Fixes:**

1. **Remove the duplicate method declaration** at line 531 - Keep only one instance of `test_successful_authentication_with_target_path_redirect()`

2. **Fix incomplete test method structures** - Multiple test methods are missing opening braces `{` and complete method bodies:
   - `test_get_credentials_stores_username_in_session()`
   - `test_get_login_url_returns_correct_route()`
   - `test_authentication_with_missing_csrf_token()`
   - `test_authentication_with_null_password()`
   - `test_authentication_with_empty_login()`
   - `test_supports_returns_false_for_wrong_route()`
   - `test_supports_returns_false_for_get_request()`
   - `test_authentication_fails_with_incorrect_password()`
   - `test_authentication_fails_with_nonexistent_user()`
   - `test_authentication_fails_with_invalid_csrf_token()`

3. **Add missing imports** at the top of the test file:
   ```php
   use App\Module\Customer\Customer;
   use App\Module\Order\Service\ShoppingCart;
   use Doctrine\ORM\EntityRepository;
   ```

    public function test_successful_authentication_with_target_path_redirect(): void
    {
        // Arrange
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $router = $this->createMock(RouterInterface::class);
        $csrfTokenManager = $this->createMock(CsrfTokenManagerInterface::class);
        $passwordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $cart = $this->createMock(ShoppingCart::class);
        
        $customer = $this->createMock(Customer::class);
        $repository = $this->createMock(EntityRepository::class);
        $session = $this->createMock(SessionInterface::class);
        $request = $this->createMock(Request::class);
        $token = $this->createMock(TokenInterface::class);
        
        $authenticator = new CustomerAuthenticator($entityManager, $router, $csrfTokenManager, $passwordEncoder, $cart);
        
        // Setup request
        $request->method('getSession')->willReturn($session);
        
        // Setup session with target path
        $session->method('get')->with('_security.main.target_path')->willReturn('/checkout');
        $session->method('remove')->with('_security.main.target_path');
        
        // Setup cart merge
        $cart->expects($this->once())->method('mergeCarts')->with($customer);
        
        // Use reflection to set customer property
        $reflection = new \ReflectionClass($authenticator);
        $property = $reflection->getProperty('customer');
        $property->setAccessible(true);
        $property->setValue($authenticator, $customer);
        
        // Act
        $response = $authenticator->onAuthenticationSuccess($request, $token, 'main');
        
        // Assert
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals('/checkout', $response->getTargetUrl());
    }

*/
/*
FAILED TEST: ## Test Failure Analysis

**Root Cause:**
The test file has a **duplicate method declaration**. The method `test_successful_authentication_with_valid_credentials()` is declared twice in the same test class (appears at the beginning and again at line 510).

**Why It Failed:**
PHP does not allow redeclaring methods with the same name in a class. The fatal error occurs during the class loading phase, before any tests can execute.

**Recommended Fixes:**

1. **Remove or rename the duplicate method** - Search for all occurrences of `test_successful_authentication_with_valid_credentials()` in the test file and either:
   - Delete one of the duplicate methods if they test the same thing
   - Rename one to have a distinct, descriptive name if they test different scenarios (e.g., `test_successful_authentication_with_valid_credentials_and_homepage_redirect()`)

2. **Fix incomplete test methods** - The test file shows several incomplete method declarations (missing opening braces `{` and method bodies). Ensure all test methods have proper structure:
   ```php
   public function test_method_name(): void
   {
       // test implementation
   }
   ```

3. **Add missing imports** - Classes like `Customer`, `ShoppingCart`, and `EntityRepository` are referenced but not imported at the top of the file.

    public function test_successful_authentication_with_valid_credentials(): void
    {
        // Arrange
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $router = $this->createMock(RouterInterface::class);
        $csrfTokenManager = $this->createMock(CsrfTokenManagerInterface::class);
        $passwordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $cart = $this->createMock(ShoppingCart::class);
        
        $customer = $this->createMock(Customer::class);
        $repository = $this->createMock(EntityRepository::class);
        $session = $this->createMock(SessionInterface::class);
        $request = $this->createMock(Request::class);
        $token = $this->createMock(TokenInterface::class);
        $userProvider = $this->createMock(UserProviderInterface::class);
        
        $authenticator = new CustomerAuthenticator($entityManager, $router, $csrfTokenManager, $passwordEncoder, $cart);
        
        // Setup request for supports()
        $request->attributes = new \Symfony\Component\HttpFoundation\ParameterBag(['_route' => 'customer_login']);
        $request->method('isMethod')->with('POST')->willReturn(true);
        
        // Setup request for getCredentials()
        $request->request = new \Symfony\Component\HttpFoundation\ParameterBag([
            'login' => 'valid_user@example.com',
            'password' => 'ValidPassword123',
            '_csrf_token' => 'valid_csrf_token'
        ]);
        $request->method('getSession')->willReturn($session);
        $session->expects($this->once())->method('set')->with(\Symfony\Component\Security\Core\Security::LAST_USERNAME, 'valid_user@example.com');
        
        // Setup CSRF validation
        $csrfTokenManager->method('isTokenValid')->willReturn(true);
        
        // Setup user lookup
        $entityManager->method('getRepository')->with(Customer::class)->willReturn($repository);
        $repository->method('findOneBy')->with(['login' => 'valid_user@example.com'])->willReturn($customer);
        
        // Setup password validation
        $passwordEncoder->method('isPasswordValid')->with($customer, 'ValidPassword123')->willReturn(true);
        
        // Setup cart merge and redirect
        $cart->expects($this->once())->method('mergeCarts')->with($customer);
        $router->method('generate')->with('homepage')->willReturn('/');
        
        // Act & Assert
        $this->assertTrue($authenticator->supports($request));
        $credentials = $authenticator->getCredentials($request);
        $this->assertEquals('valid_user@example.com', $credentials['login']);
        $this->assertEquals('ValidPassword123', $credentials['password']);
        
        $user = $authenticator->getUser($credentials, $userProvider);
        $this->assertSame($customer, $user);
        
        $this->assertTrue($authenticator->checkCredentials($credentials, $user));
        
        $response = $authenticator->onAuthenticationSuccess($request, $token, 'main');
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals('/', $response->getTargetUrl());
    }

*/

    public function test_get_credentials_stores_username_in_session(): void
    {
        $session = $this->createMock(SessionInterface::class);
        $session->expects($this->once())
            ->method('set')
            ->with(
                \Symfony\Component\Security\Core\Security::LAST_USERNAME,
                'test_user@example.com'
            );
    
        $request = $this->createMock(Request::class);
        $request->request = $this->createMock(\Symfony\Component\HttpFoundation\ParameterBag::class);
        $request->request->method('get')->willReturnMap([
            ['login', null, 'test_user@example.com'],
            ['password', null, 'password123'],
            ['_csrf_token', null, 'token123']
        ]);
        $request->method('getSession')->willReturn($session);
    
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $router = $this->createMock(RouterInterface::class);
        $csrfTokenManager = $this->createMock(CsrfTokenManagerInterface::class);
        $passwordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $cart = $this->createMock(ShoppingCart::class);
    
        $authenticator = new CustomerAuthenticator(
            $entityManager,
            $router,
            $csrfTokenManager,
            $passwordEncoder,
            $cart
        );
    
        $credentials = $authenticator->getCredentials($request);
    
        $this->assertIsArray($credentials);
        $this->assertEquals('test_user@example.com', $credentials['login']);
        $this->assertEquals('password123', $credentials['password']);
        $this->assertEquals('token123', $credentials['csrf_token']);
    }


    public function test_get_login_url_returns_correct_route(): void
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $csrfTokenManager = $this->createMock(CsrfTokenManagerInterface::class);
        $passwordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $cart = $this->createMock(ShoppingCart::class);
    
        $router = $this->createMock(RouterInterface::class);
        $router->expects($this->once())
            ->method('generate')
            ->with('customer_login')
            ->willReturn('/customer/login');
    
        $authenticator = new CustomerAuthenticator(
            $entityManager,
            $router,
            $csrfTokenManager,
            $passwordEncoder,
            $cart
        );
    
        $reflection = new \ReflectionClass($authenticator);
        $method = $reflection->getMethod('getLoginUrl');
        $method->setAccessible(true);
    
        $result = $method->invoke($authenticator);
    
        $this->assertEquals('/customer/login', $result);
    }


    public function test_authentication_with_missing_csrf_token(): void
    {
        $session = $this->createMock(SessionInterface::class);
        $session->method('set');
    
        $request = $this->createMock(Request::class);
        $request->request = $this->createMock(\Symfony\Component\HttpFoundation\ParameterBag::class);
        $request->request->method('get')->willReturnMap([
            ['login', null, 'valid_user@example.com'],
            ['password', null, 'ValidPassword123'],
            ['_csrf_token', null, null]
        ]);
        $request->method('getSession')->willReturn($session);
    
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $router = $this->createMock(RouterInterface::class);
    
        $csrfTokenManager = $this->createMock(CsrfTokenManagerInterface::class);
        $csrfTokenManager->method('isTokenValid')->willReturn(false);
    
        $passwordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $cart = $this->createMock(ShoppingCart::class);
    
        $authenticator = new CustomerAuthenticator(
            $entityManager,
            $router,
            $csrfTokenManager,
            $passwordEncoder,
            $cart
        );
    
        $credentials = $authenticator->getCredentials($request);
        $this->assertNull($credentials['csrf_token']);
    
        $userProvider = $this->createMock(UserProviderInterface::class);
    
        $this->expectException(InvalidCsrfTokenException::class);
    
        $authenticator->getUser($credentials, $userProvider);
    }


    public function test_authentication_with_null_password(): void
    {
        $session = $this->createMock(SessionInterface::class);
        $session->method('set');
    
        $request = $this->createMock(Request::class);
        $request->request = $this->createMock(\Symfony\Component\HttpFoundation\ParameterBag::class);
        $request->request->method('get')->willReturnMap([
            ['login', null, 'valid_user@example.com'],
            ['password', null, null],
            ['_csrf_token', null, 'valid_csrf_token']
        ]);
        $request->method('getSession')->willReturn($session);
    
        $customer = $this->createMock(Customer::class);
    
        $repository = $this->createMock(EntityRepository::class);
        $repository->method('findOneBy')->willReturn($customer);
    
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->method('getRepository')->willReturn($repository);
    
        $csrfTokenManager = $this->createMock(CsrfTokenManagerInterface::class);
        $csrfTokenManager->method('isTokenValid')->willReturn(true);
    
        $passwordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $passwordEncoder->method('isPasswordValid')->with($customer, null)->willReturn(false);
    
        $router = $this->createMock(RouterInterface::class);
        $cart = $this->createMock(ShoppingCart::class);
    
        $authenticator = new CustomerAuthenticator(
            $entityManager,
            $router,
            $csrfTokenManager,
            $passwordEncoder,
            $cart
        );
    
        $credentials = $authenticator->getCredentials($request);
        $this->assertNull($credentials['password']);
    
        $userProvider = $this->createMock(UserProviderInterface::class);
        $user = $authenticator->getUser($credentials, $userProvider);
    
        $result = $authenticator->checkCredentials($credentials, $user);
        $this->assertFalse($result);
    }


    public function test_authentication_with_empty_login(): void
    {
        $session = $this->createMock(SessionInterface::class);
        $session->expects($this->once())
            ->method('set')
            ->with(\Symfony\Component\Security\Core\Security::LAST_USERNAME, '');
    
        $request = $this->createMock(Request::class);
        $request->request = $this->createMock(\Symfony\Component\HttpFoundation\ParameterBag::class);
        $request->request->method('get')->willReturnMap([
            ['login', null, ''],
            ['password', null, 'ValidPassword123'],
            ['_csrf_token', null, 'valid_csrf_token']
        ]);
        $request->method('getSession')->willReturn($session);
    
        $repository = $this->createMock(EntityRepository::class);
        $repository->method('findOneBy')->with(['login' => ''])->willReturn(null);
    
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->method('getRepository')->with(Customer::class)->willReturn($repository);
    
        $csrfTokenManager = $this->createMock(CsrfTokenManagerInterface::class);
        $csrfTokenManager->method('isTokenValid')->willReturn(true);
    
        $router = $this->createMock(RouterInterface::class);
        $passwordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $cart = $this->createMock(ShoppingCart::class);
    
        $authenticator = new CustomerAuthenticator(
            $entityManager,
            $router,
            $csrfTokenManager,
            $passwordEncoder,
            $cart
        );
    
        $credentials = $authenticator->getCredentials($request);
        $this->assertEquals('', $credentials['login']);
    
        $userProvider = $this->createMock(UserProviderInterface::class);
    
        $this->expectException(CustomUserMessageAuthenticationException::class);
        $this->expectExceptionMessage('Login could not be found.');
    
        $authenticator->getUser($credentials, $userProvider);
    }


    public function test_supports_returns_false_for_wrong_route(): void
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $router = $this->createMock(RouterInterface::class);
        $csrfTokenManager = $this->createMock(CsrfTokenManagerInterface::class);
        $passwordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $cart = $this->createMock(ShoppingCart::class);
    
        $authenticator = new CustomerAuthenticator(
            $entityManager,
            $router,
            $csrfTokenManager,
            $passwordEncoder,
            $cart
        );
    
        $request = $this->createMock(Request::class);
        $request->attributes = $this->createMock(\Symfony\Component\HttpFoundation\ParameterBag::class);
        $request->attributes->method('get')->with('_route')->willReturn('homepage');
        $request->method('isMethod')->with('POST')->willReturn(true);
    
        $result = $authenticator->supports($request);
    
        $this->assertFalse($result);
    }


    public function test_supports_returns_false_for_get_request(): void
    {
        // Arrange
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $router = $this->createMock(RouterInterface::class);
        $csrfTokenManager = $this->createMock(CsrfTokenManagerInterface::class);
        $passwordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $cart = $this->createMock(ShoppingCart::class);
        
        $request = new Request([], [
            'login' => 'user@example.com',
            'password' => 'password'
        ]);
        $request->attributes->set('_route', 'customer_login');
        $request->setMethod('GET');
        
        $authenticator = new CustomerAuthenticator($entityManager, $router, $csrfTokenManager, $passwordEncoder, $cart);
        
        // Act
        $supports = $authenticator->supports($request);
        
        // Assert
        $this->assertFalse($supports);
    }


    public function test_authentication_fails_with_incorrect_password(): void
    {
        // Arrange
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $router = $this->createMock(RouterInterface::class);
        $csrfTokenManager = $this->createMock(CsrfTokenManagerInterface::class);
        $passwordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $cart = $this->createMock(ShoppingCart::class);
        $userProvider = $this->createMock(UserProviderInterface::class);
        
        $customer = $this->createMock(Customer::class);
        $repository = $this->createMock(EntityRepository::class);
        $session = $this->createMock(SessionInterface::class);
        
        $request = new Request([], [
            'login' => 'valid_user@example.com',
            'password' => 'WrongPassword123',
            '_csrf_token' => 'valid_csrf_token'
        ]);
        $request->setSession($session);
        
        $authenticator = new CustomerAuthenticator($entityManager, $router, $csrfTokenManager, $passwordEncoder, $cart);
        
        // Setup mocks
        $csrfTokenManager->method('isTokenValid')->willReturn(true);
        $repository->method('findOneBy')->with(['login' => 'valid_user@example.com'])->willReturn($customer);
        $entityManager->method('getRepository')->with(Customer::class)->willReturn($repository);
        $passwordEncoder->method('isPasswordValid')->with($customer, 'WrongPassword123')->willReturn(false);
        
        // Act
        $credentials = $authenticator->getCredentials($request);
        $user = $authenticator->getUser($credentials, $userProvider);
        $credentialsValid = $authenticator->checkCredentials($credentials, $user);
        
        // Assert
        $this->assertSame($customer, $user);
        $this->assertFalse($credentialsValid);
    }


    public function test_authentication_fails_with_nonexistent_user(): void
    {
        // Arrange
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $router = $this->createMock(RouterInterface::class);
        $csrfTokenManager = $this->createMock(CsrfTokenManagerInterface::class);
        $passwordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $cart = $this->createMock(ShoppingCart::class);
        $userProvider = $this->createMock(UserProviderInterface::class);
        $repository = $this->createMock(EntityRepository::class);
        $session = $this->createMock(SessionInterface::class);
        
        $request = new Request([], [
            'login' => 'nonexistent@example.com',
            'password' => 'AnyPassword123',
            '_csrf_token' => 'valid_csrf_token'
        ]);
        $request->setSession($session);
        
        $authenticator = new CustomerAuthenticator($entityManager, $router, $csrfTokenManager, $passwordEncoder, $cart);
        
        // Setup mocks
        $csrfTokenManager->method('isTokenValid')->willReturn(true);
        $repository->method('findOneBy')->with(['login' => 'nonexistent@example.com'])->willReturn(null);
        $entityManager->method('getRepository')->with(Customer::class)->willReturn($repository);
        
        // Act & Assert
        $this->expectException(CustomUserMessageAuthenticationException::class);
        $this->expectExceptionMessage('Login could not be found.');
        $credentials = $authenticator->getCredentials($request);
        $authenticator->getUser($credentials, $userProvider);
    }


    public function test_authentication_fails_with_invalid_csrf_token(): void
    {
        // Arrange
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $router = $this->createMock(RouterInterface::class);
        $csrfTokenManager = $this->createMock(CsrfTokenManagerInterface::class);
        $passwordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $cart = $this->createMock(ShoppingCart::class);
        $userProvider = $this->createMock(UserProviderInterface::class);
        $session = $this->createMock(SessionInterface::class);
        
        $request = new Request([], [
            'login' => 'valid_user@example.com',
            'password' => 'ValidPassword123',
            '_csrf_token' => 'invalid_csrf_token'
        ]);
        $request->setSession($session);
        
        $authenticator = new CustomerAuthenticator($entityManager, $router, $csrfTokenManager, $passwordEncoder, $cart);
        
        // Setup mocks
        $csrfTokenManager->method('isTokenValid')->willReturn(false);
        $entityManager->expects($this->never())->method('getRepository');
        
        // Act & Assert
        $this->expectException(InvalidCsrfTokenException::class);
        $credentials = $authenticator->getCredentials($request);
        $authenticator->getUser($credentials, $userProvider);
    }


    public function test_successful_authentication_with_target_path_redirect(): void
    {
        // Arrange
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $router = $this->createMock(RouterInterface::class);
        $csrfTokenManager = $this->createMock(CsrfTokenManagerInterface::class);
        $passwordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $cart = $this->createMock(ShoppingCart::class);
        $userProvider = $this->createMock(UserProviderInterface::class);
        $token = $this->createMock(TokenInterface::class);
        
        $customer = $this->createMock(Customer::class);
        $repository = $this->createMock(EntityRepository::class);
        $session = $this->createMock(SessionInterface::class);
        
        $request = new Request([], [
            'login' => 'valid_user@example.com',
            'password' => 'ValidPassword123',
            '_csrf_token' => 'valid_csrf_token'
        ]);
        $request->attributes->set('_route', 'customer_login');
        $request->setMethod('POST');
        $request->setSession($session);
        
        $authenticator = new CustomerAuthenticator($entityManager, $router, $csrfTokenManager, $passwordEncoder, $cart);
        
        // Setup mocks
        $csrfTokenManager->method('isTokenValid')->willReturn(true);
        $repository->method('findOneBy')->willReturn($customer);
        $entityManager->method('getRepository')->willReturn($repository);
        $passwordEncoder->method('isPasswordValid')->willReturn(true);
        $session->method('get')->with('_security.main.target_path')->willReturn('/checkout');
        $cart->expects($this->once())->method('mergeCarts')->with($customer);
        
        // Act
        $credentials = $authenticator->getCredentials($request);
        $user = $authenticator->getUser($credentials, $userProvider);
        $authenticator->checkCredentials($credentials, $user);
        $response = $authenticator->onAuthenticationSuccess($request, $token, 'main');
        
        // Assert
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals('/checkout', $response->getTargetUrl());
    }


    public function test_successful_authentication_with_valid_credentials(): void
    {
        // Arrange
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $router = $this->createMock(RouterInterface::class);
        $csrfTokenManager = $this->createMock(CsrfTokenManagerInterface::class);
        $passwordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $cart = $this->createMock(ShoppingCart::class);
        $userProvider = $this->createMock(UserProviderInterface::class);
        $token = $this->createMock(TokenInterface::class);
        
        $customer = $this->createMock(Customer::class);
        $repository = $this->createMock(EntityRepository::class);
        $session = $this->createMock(SessionInterface::class);
        
        $request = new Request([], [
            'login' => 'valid_user@example.com',
            'password' => 'ValidPassword123',
            '_csrf_token' => 'valid_csrf_token'
        ]);
        $request->attributes->set('_route', 'customer_login');
        $request->setMethod('POST');
        $request->setSession($session);
        
        $authenticator = new CustomerAuthenticator($entityManager, $router, $csrfTokenManager, $passwordEncoder, $cart);
        
        // Setup mocks
        $csrfTokenManager->method('isTokenValid')->willReturn(true);
        $repository->method('findOneBy')->with(['login' => 'valid_user@example.com'])->willReturn($customer);
        $entityManager->method('getRepository')->with(Customer::class)->willReturn($repository);
        $passwordEncoder->method('isPasswordValid')->with($customer, 'ValidPassword123')->willReturn(true);
        $session->expects($this->once())->method('set')->with('_security.last_username', 'valid_user@example.com');
        $cart->expects($this->once())->method('mergeCarts')->with($customer);
        $router->method('generate')->with('homepage')->willReturn('/homepage');
        
        // Act
        $supports = $authenticator->supports($request);
        $credentials = $authenticator->getCredentials($request);
        $user = $authenticator->getUser($credentials, $userProvider);
        $credentialsValid = $authenticator->checkCredentials($credentials, $user);
        $response = $authenticator->onAuthenticationSuccess($request, $token, 'main');
        
        // Assert
        $this->assertTrue($supports);
        $this->assertEquals('valid_user@example.com', $credentials['login']);
        $this->assertEquals('ValidPassword123', $credentials['password']);
        $this->assertEquals('valid_csrf_token', $credentials['csrf_token']);
        $this->assertSame($customer, $user);
        $this->assertTrue($credentialsValid);
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals('/homepage', $response->getTargetUrl());
    }


}
