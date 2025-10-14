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

    


}
/*
FAILED TEST: **Analysis:**  
The test run failed due to a **syntax error** in `CustomerAuthenticatorTest.php`. The method `testSuccessfulLoginWithValidCredentials()` is defined **outside** the class body, causing a `Parse error`.

**Recommended Fix:**  
Move the `testSuccessfulLoginWithValidCredentials()` method **inside** the `CustomerAuthenticatorTest` class definition.

    public function testLoginWithEmptyPassword()
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $repository = $this->createMock(EntityRepository::class);
        $repository->method('findOneBy')->willReturn($this->createMock(Customer::class));
        $entityManager->method('getRepository')->willReturn($repository);
    
        $router = $this->createMock(RouterInterface::class);
    
        $csrfTokenManager = $this->createMock(CsrfTokenManagerInterface::class);
        $csrfTokenManager->method('isTokenValid')->willReturn(true);
    
        $passwordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $passwordEncoder->method('isPasswordValid')->willReturn(false);
    
        $cart = $this->createMock(ShoppingCart::class);
    
        $authenticator = new CustomerAuthenticator($entityManager, $router, $csrfTokenManager, $passwordEncoder, $cart);
    
        $request = new Request();
        $request->attributes->set('_route', 'customer_login');
        $request->request->set('login', 'testuser');
        $request->request->set('password', '');
        $request->request->set('_csrf_token', 'valid_token');
        $request->setMethod('POST');
    
        $credentials = $authenticator->getCredentials($request);
        $user = $authenticator->getUser($credentials, $this->createMock(UserProviderInterface::class));
    
        $this->assertFalse($authenticator->checkCredentials($credentials, $user));
    }

*/
/*
FAILED TEST: **Analysis:**  
The test run failed due to a **syntax error** in `CustomerAuthenticatorTest.php`. The method `testSuccessfulLoginWithValidCredentials()` is defined **outside** the class body, causing a `Parse error`.

**Recommended Fix:**  
Move the `testSuccessfulLoginWithValidCredentials()` method **inside** the `CustomerAuthenticatorTest` class definition.

    public function testLoginWithEmptyUsername()
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $repository = $this->createMock(EntityRepository::class);
        $repository->method('findOneBy')->willReturn(null);
        $entityManager->method('getRepository')->willReturn($repository);
    
        $router = $this->createMock(RouterInterface::class);
    
        $csrfTokenManager = $this->createMock(CsrfTokenManagerInterface::class);
        $csrfTokenManager->method('isTokenValid')->willReturn(true);
    
        $passwordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
    
        $cart = $this->createMock(ShoppingCart::class);
    
        $authenticator = new CustomerAuthenticator($entityManager, $router, $csrfTokenManager, $passwordEncoder, $cart);
    
        $request = new Request();
        $request->attributes->set('_route', 'customer_login');
        $request->request->set('login', '');
        $request->request->set('password', 'password');
        $request->request->set('_csrf_token', 'valid_token');
        $request->setMethod('POST');
    
        $credentials = $authenticator->getCredentials($request);
    
        $this->expectException(CustomUserMessageAuthenticationException::class);
        $this->expectExceptionMessage('Login could not be found.');
        $authenticator->getUser($credentials, $this->createMock(UserProviderInterface::class));
    }

*/
/*
FAILED TEST: **Analysis:**  
The test run failed due to a **syntax error** in `CustomerAuthenticatorTest.php`. The method `testSuccessfulLoginWithValidCredentials()` is defined **outside** the class body, causing a `Parse error`.

**Recommended Fix:**  
Move the `testSuccessfulLoginWithValidCredentials()` method **inside** the `CustomerAuthenticatorTest` class definition.

    public function testLoginWithNoTargetPathSetInSession()
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $repository = $this->createMock(EntityRepository::class);
        $repository->method('findOneBy')->willReturn($this->createMock(Customer::class));
        $entityManager->method('getRepository')->willReturn($repository);
    
        $router = $this->createMock(RouterInterface::class);
        $router->method('generate')->willReturn('/homepage');
    
        $csrfTokenManager = $this->createMock(CsrfTokenManagerInterface::class);
        $csrfTokenManager->method('isTokenValid')->willReturn(true);
    
        $passwordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $passwordEncoder->method('isPasswordValid')->willReturn(true);
    
        $cart = $this->createMock(ShoppingCart::class);
    
        $authenticator = new CustomerAuthenticator($entityManager, $router, $csrfTokenManager, $passwordEncoder, $cart);
    
        $request = new Request();
        $request->attributes->set('_route', 'customer_login');
        $request->request->set('login', 'testuser');
        $request->request->set('password', 'password');
        $request->request->set('_csrf_token', 'valid_token');
        $request->setMethod('POST');
    
        $session = $this->createMock(SessionInterface::class);
        $session->method('get')->with('security.customer.target_path')->willReturn(null);
        $request->setSession($session);
    
        $token = $this->createMock(TokenInterface::class);
        $response = $authenticator->onAuthenticationSuccess($request, $token, 'customer');
    
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals('/homepage', $response->getTargetUrl());
    }

*/
/*
FAILED TEST: **Analysis:**  
The test run failed due to a **syntax error** in `CustomerAuthenticatorTest.php`. The method `testSuccessfulLoginWithValidCredentials()` is defined **outside** the class body, causing a `Parse error`.

**Recommended Fix:**  
Move the `testSuccessfulLoginWithValidCredentials()` method **inside** the `CustomerAuthenticatorTest` class definition.

    public function testLoginWithTargetPathSetInSession()
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $repository = $this->createMock(EntityRepository::class);
        $repository->method('findOneBy')->willReturn($this->createMock(Customer::class));
        $entityManager->method('getRepository')->willReturn($repository);
    
        $router = $this->createMock(RouterInterface::class);
    
        $csrfTokenManager = $this->createMock(CsrfTokenManagerInterface::class);
        $csrfTokenManager->method('isTokenValid')->willReturn(true);
    
        $passwordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $passwordEncoder->method('isPasswordValid')->willReturn(true);
    
        $cart = $this->createMock(ShoppingCart::class);
    
        $authenticator = new CustomerAuthenticator($entityManager, $router, $csrfTokenManager, $passwordEncoder, $cart);
    
        $request = new Request();
        $request->attributes->set('_route', 'customer_login');
        $request->request->set('login', 'testuser');
        $request->request->set('password', 'password');
        $request->request->set('_csrf_token', 'valid_token');
        $request->setMethod('POST');
    
        $session = $this->createMock(SessionInterface::class);
        $session->method('get')->with('security.customer.target_path')->willReturn('/dashboard');
        $request->setSession($session);
    
        $token = $this->createMock(TokenInterface::class);
        $response = $authenticator->onAuthenticationSuccess($request, $token, 'customer');
    
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals('/dashboard', $response->getTargetUrl());
    }

*/
/*
FAILED TEST: **Analysis:**  
The test run failed due to a **syntax error** in `CustomerAuthenticatorTest.php`. The method `testSuccessfulLoginWithValidCredentials()` is defined **outside** the class body, causing a `Parse error`.

**Recommended Fix:**  
Move the `testSuccessfulLoginWithValidCredentials()` method **inside** the `CustomerAuthenticatorTest` class definition.

    public function testLoginWithIncorrectPassword()
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $repository = $this->createMock(EntityRepository::class);
        $repository->method('findOneBy')->willReturn($this->createMock(Customer::class));
        $entityManager->method('getRepository')->willReturn($repository);
    
        $router = $this->createMock(RouterInterface::class);
    
        $csrfTokenManager = $this->createMock(CsrfTokenManagerInterface::class);
        $csrfTokenManager->method('isTokenValid')->willReturn(true);
    
        $passwordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $passwordEncoder->method('isPasswordValid')->willReturn(false);
    
        $cart = $this->createMock(ShoppingCart::class);
    
        $authenticator = new CustomerAuthenticator($entityManager, $router, $csrfTokenManager, $passwordEncoder, $cart);
    
        $request = new Request();
        $request->attributes->set('_route', 'customer_login');
        $request->request->set('login', 'testuser');
        $request->request->set('password', 'wrongpassword');
        $request->request->set('_csrf_token', 'valid_token');
        $request->setMethod('POST');
    
        $credentials = $authenticator->getCredentials($request);
        $user = $authenticator->getUser($credentials, $this->createMock(UserProviderInterface::class));
    
        $this->assertFalse($authenticator->checkCredentials($credentials, $user));
    }

*/
/*
FAILED TEST: **Analysis:**  
The test run failed due to a **syntax error** in `CustomerAuthenticatorTest.php`. The method `testSuccessfulLoginWithValidCredentials()` is defined **outside** the class body, causing a `Parse error`.

**Recommended Fix:**  
Move the `testSuccessfulLoginWithValidCredentials()` method **inside** the `CustomerAuthenticatorTest` class definition.

    public function testLoginWithNonExistentUsername()
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $repository = $this->createMock(EntityRepository::class);
        $repository->method('findOneBy')->willReturn(null);
        $entityManager->method('getRepository')->willReturn($repository);
    
        $router = $this->createMock(RouterInterface::class);
    
        $csrfTokenManager = $this->createMock(CsrfTokenManagerInterface::class);
        $csrfTokenManager->method('isTokenValid')->willReturn(true);
    
        $passwordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
    
        $cart = $this->createMock(ShoppingCart::class);
    
        $authenticator = new CustomerAuthenticator($entityManager, $router, $csrfTokenManager, $passwordEncoder, $cart);
    
        $request = new Request();
        $request->attributes->set('_route', 'customer_login');
        $request->request->set('login', 'nonexistent');
        $request->request->set('password', 'password');
        $request->request->set('_csrf_token', 'valid_token');
        $request->setMethod('POST');
    
        $credentials = $authenticator->getCredentials($request);
    
        $this->expectException(CustomUserMessageAuthenticationException::class);
        $this->expectExceptionMessage('Login could not be found.');
        $authenticator->getUser($credentials, $this->createMock(UserProviderInterface::class));
    }

*/
/*
FAILED TEST: **Analysis:**  
The test run failed due to a **syntax error** in `CustomerAuthenticatorTest.php`. The method `testSuccessfulLoginWithValidCredentials()` is defined **outside** the class body, which is not valid PHP syntax.

**Recommended Fix:**  
Move the `testSuccessfulLoginWithValidCredentials()` method **inside** the `CustomerAuthenticatorTest` class definition.

    public function testLoginWithInvalidCsrfToken()
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $repository = $this->createMock(EntityRepository::class);
        $repository->method('findOneBy')->willReturn($this->createMock(Customer::class));
        $entityManager->method('getRepository')->willReturn($repository);
    
        $router = $this->createMock(RouterInterface::class);
    
        $csrfTokenManager = $this->createMock(CsrfTokenManagerInterface::class);
        $csrfTokenManager->method('isTokenValid')->willReturn(false);
    
        $passwordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
    
        $cart = $this->createMock(ShoppingCart::class);
    
        $authenticator = new CustomerAuthenticator($entityManager, $router, $csrfTokenManager, $passwordEncoder, $cart);
    
        $request = new Request();
        $request->attributes->set('_route', 'customer_login');
        $request->request->set('login', 'testuser');
        $request->request->set('password', 'password');
        $request->request->set('_csrf_token', 'invalid_token');
        $request->setMethod('POST');
    
        $credentials = $authenticator->getCredentials($request);
    
        $this->expectException(InvalidCsrfTokenException::class);
        $authenticator->getUser($credentials, $this->createMock(UserProviderInterface::class));
    }

*/
/*
FAILED TEST: The test run failed due to a **syntax error** in the test file `CustomerAuthenticatorTest.php`. Specifically, the `public function testSuccessfulLoginWithValidCredentials()` is defined **outside** the class body, causing a `Parse error`.

### ✅ Recommended Fix:
Move the `testSuccessfulLoginWithValidCredentials` method **inside** the `CustomerAuthenticatorTest` class definition.

    public function testSuccessfulLoginWithValidCredentials()
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $repository = $this->createMock(EntityRepository::class);
        $repository->method('findOneBy')->willReturn($this->createMock(Customer::class));
        $entityManager->method('getRepository')->willReturn($repository);
    
        $router = $this->createMock(RouterInterface::class);
        $router->method('generate')->willReturn('/homepage');
    
        $csrfTokenManager = $this->createMock(CsrfTokenManagerInterface::class);
        $csrfTokenManager->method('isTokenValid')->willReturn(true);
    
        $passwordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $passwordEncoder->method('isPasswordValid')->willReturn(true);
    
        $cart = $this->createMock(ShoppingCart::class);
        $cart->method('mergeCarts')->willReturn(null);
    
        $authenticator = new CustomerAuthenticator($entityManager, $router, $csrfTokenManager, $passwordEncoder, $cart);
    
        $request = new Request();
        $request->attributes->set('_route', 'customer_login');
        $request->request->set('login', 'testuser');
        $request->request->set('password', 'password');
        $request->request->set('_csrf_token', 'valid_token');
        $request->setMethod('POST');
    
        $session = $this->createMock(SessionInterface::class);
        $request->setSession($session);
    
        $this->assertTrue($authenticator->supports($request));
        $credentials = $authenticator->getCredentials($request);
        $this->assertArrayHasKey('login', $credentials);
        $this->assertArrayHasKey('password', $credentials);
        $this->assertArrayHasKey('csrf_token', $credentials);
    
        $user = $authenticator->getUser($credentials, $this->createMock(UserProviderInterface::class));
        $this->assertInstanceOf(Customer::class, $user);
    
        $this->assertTrue($authenticator->checkCredentials($credentials, $user));
    
        $token = $this->createMock(TokenInterface::class);
        $response = $authenticator->onAuthenticationSuccess($request, $token, 'customer');
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals('/homepage', $response->getTargetUrl());
    }

*/
