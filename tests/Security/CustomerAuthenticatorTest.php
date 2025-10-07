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

    

    public function test_get_login_url_returns_correct_route(): void
    {
        // Arrange
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $router = $this->createMock(RouterInterface::class);
        $csrfTokenManager = $this->createMock(CsrfTokenManagerInterface::class);
        $passwordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $cart = $this->createMock(ShoppingCart::class);
    
        $router->expects($this->once())
            ->method('generate')
            ->with('customer_login')
            ->willReturn('/customer/login');
    
        $authenticator = new CustomerAuthenticator($entityManager, $router, $csrfTokenManager, $passwordEncoder, $cart);
    
        // Act
        $reflection = new \ReflectionClass($authenticator);
        $method = $reflection->getMethod('getLoginUrl');
        $method->setAccessible(true);
        $result = $method->invoke($authenticator);
    
        // Assert
        $this->assertEquals('/customer/login', $result);
    }


    public function test_authentication_fails_with_incorrect_password(): void
    {
        // Arrange
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $router = $this->createMock(RouterInterface::class);
        $csrfTokenManager = $this->createMock(CsrfTokenManagerInterface::class);
        $passwordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $cart = $this->createMock(ShoppingCart::class);
        $customer = $this->createMock(Customer::class);
    
        $passwordEncoder->method('isPasswordValid')->with($customer, 'WrongPassword123')->willReturn(false);
    
        $authenticator = new CustomerAuthenticator($entityManager, $router, $csrfTokenManager, $passwordEncoder, $cart);
    
        $credentials = [
            'login' => 'valid_user@example.com',
            'password' => 'WrongPassword123',
            'csrf_token' => 'valid_token'
        ];
    
        // Act
        $result = $authenticator->checkCredentials($credentials, $customer);
    
        // Assert
        $this->assertFalse($result);
    }


    public function test_authentication_fails_with_nonexistent_user(): void
    {
        // Arrange
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $router = $this->createMock(RouterInterface::class);
        $csrfTokenManager = $this->createMock(CsrfTokenManagerInterface::class);
        $passwordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $cart = $this->createMock(ShoppingCart::class);
        $repository = $this->createMock(EntityRepository::class);
        $userProvider = $this->createMock(UserProviderInterface::class);
    
        $csrfTokenManager->method('isTokenValid')->willReturn(true);
        $entityManager->method('getRepository')->with(Customer::class)->willReturn($repository);
        $repository->method('findOneBy')->with(['login' => 'nonexistent@example.com'])->willReturn(null);
    
        $authenticator = new CustomerAuthenticator($entityManager, $router, $csrfTokenManager, $passwordEncoder, $cart);
    
        $credentials = [
            'login' => 'nonexistent@example.com',
            'password' => 'AnyPassword123',
            'csrf_token' => 'valid_token'
        ];
    
        // Assert
        $this->expectException(CustomUserMessageAuthenticationException::class);
        $this->expectExceptionMessage('Login could not be found.');
    
        // Act
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
        $session = $this->createMock(SessionInterface::class);
        $request = $this->createMock(Request::class);
        $userProvider = $this->createMock(UserProviderInterface::class);
    
        $request->request = new \Symfony\Component\HttpFoundation\ParameterBag([
            'login' => 'valid_user@example.com',
            'password' => 'ValidPassword123',
            '_csrf_token' => 'invalid_token'
        ]);
    
        $request->method('getSession')->willReturn($session);
        $csrfTokenManager->method('isTokenValid')->willReturn(false);
        
        $entityManager->expects($this->never())->method('getRepository');
    
        $authenticator = new CustomerAuthenticator($entityManager, $router, $csrfTokenManager, $passwordEncoder, $cart);
    
        $credentials = [
            'login' => 'valid_user@example.com',
            'password' => 'ValidPassword123',
            'csrf_token' => 'invalid_token'
        ];
    
        // Assert
        $this->expectException(InvalidCsrfTokenException::class);
    
        // Act
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
        $session = $this->createMock(SessionInterface::class);
        $request = $this->createMock(Request::class);
        $customer = $this->createMock(Customer::class);
        $repository = $this->createMock(EntityRepository::class);
        $token = $this->createMock(TokenInterface::class);
    
        $request->attributes = new \Symfony\Component\HttpFoundation\ParameterBag(['_route' => 'customer_login']);
        $request->request = new \Symfony\Component\HttpFoundation\ParameterBag([
            'login' => 'valid_user@example.com',
            'password' => 'ValidPassword123',
            '_csrf_token' => 'valid_token'
        ]);
    
        $request->method('getSession')->willReturn($session);
        $csrfTokenManager->method('isTokenValid')->willReturn(true);
        $entityManager->method('getRepository')->with(Customer::class)->willReturn($repository);
        $repository->method('findOneBy')->with(['login' => 'valid_user@example.com'])->willReturn($customer);
        $passwordEncoder->method('isPasswordValid')->willReturn(true);
        $cart->expects($this->once())->method('mergeCarts')->with($customer);
        
        $session->method('get')->with('_security.main.target_path')->willReturn('/target/path');
    
        $authenticator = new CustomerAuthenticator($entityManager, $router, $csrfTokenManager, $passwordEncoder, $cart);
    
        // Act
        $response = $authenticator->onAuthenticationSuccess($request, $token, 'main');
    
        // Assert
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals('/target/path', $response->getTargetUrl());
    }


    public function test_successful_authentication_with_valid_credentials(): void
    {
        // Arrange
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $router = $this->createMock(RouterInterface::class);
        $csrfTokenManager = $this->createMock(CsrfTokenManagerInterface::class);
        $passwordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $cart = $this->createMock(ShoppingCart::class);
        $session = $this->createMock(SessionInterface::class);
        $request = $this->createMock(Request::class);
        $customer = $this->createMock(Customer::class);
        $repository = $this->createMock(EntityRepository::class);
        $userProvider = $this->createMock(UserProviderInterface::class);
        $token = $this->createMock(TokenInterface::class);
    
        $request->attributes = new \Symfony\Component\HttpFoundation\ParameterBag(['_route' => 'customer_login']);
        $request->request = new \Symfony\Component\HttpFoundation\ParameterBag([
            'login' => 'valid_user@example.com',
            'password' => 'ValidPassword123',
            '_csrf_token' => 'valid_token'
        ]);
    
        $request->method('isMethod')->with('POST')->willReturn(true);
        $request->method('getSession')->willReturn($session);
        
        $session->expects($this->once())->method('set')->with(
            \Symfony\Component\Security\Core\Security::LAST_USERNAME,
            'valid_user@example.com'
        );
        
        $csrfTokenManager->method('isTokenValid')->willReturn(true);
        $entityManager->method('getRepository')->with(Customer::class)->willReturn($repository);
        $repository->method('findOneBy')->with(['login' => 'valid_user@example.com'])->willReturn($customer);
        $passwordEncoder->method('isPasswordValid')->with($customer, 'ValidPassword123')->willReturn(true);
        $cart->expects($this->once())->method('mergeCarts')->with($customer);
        $router->method('generate')->with('homepage')->willReturn('/homepage');
        $session->method('get')->willReturn(null);
    
        $authenticator = new CustomerAuthenticator($entityManager, $router, $csrfTokenManager, $passwordEncoder, $cart);
    
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
        $this->assertEquals('valid_token', $credentials['csrf_token']);
        $this->assertSame($customer, $user);
        $this->assertTrue($credentialsValid);
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals('/homepage', $response->getTargetUrl());
    }


    public function test_check_credentials_with_empty_password_returns_false(): void
    {
        // Arrange
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $router = $this->createMock(RouterInterface::class);
        $csrfTokenManager = $this->createMock(CsrfTokenManagerInterface::class);
        $passwordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $cart = $this->createMock(ShoppingCart::class);
        $customer = $this->createMock(Customer::class);
    
        $passwordEncoder->expects($this->once())
            ->method('isPasswordValid')
            ->with($customer, '')
            ->willReturn(false);
    
        $authenticator = new CustomerAuthenticator($entityManager, $router, $csrfTokenManager, $passwordEncoder, $cart);
    
        $credentials = [
            'login' => 'user@example.com',
            'password' => '',
            'csrf_token' => 'valid_token'
        ];
    
        // Act
        $result = $authenticator->checkCredentials($credentials, $customer);
    
        // Assert
        $this->assertFalse($result);
    }


    public function test_authentication_success_with_empty_target_path_redirects_to_homepage(): void
    {
        // Arrange
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $router = $this->createMock(RouterInterface::class);
        $csrfTokenManager = $this->createMock(CsrfTokenManagerInterface::class);
        $passwordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $cart = $this->createMock(ShoppingCart::class);
        $session = $this->createMock(SessionInterface::class);
        $request = $this->createMock(Request::class);
        $customer = $this->createMock(Customer::class);
        $token = $this->createMock(TokenInterface::class);
    
        $request->method('getSession')->willReturn($session);
        $cart->expects($this->once())->method('mergeCarts')->with($customer);
        
        // Target path returns empty string
        $session->method('get')->with('_security.main.target_path')->willReturn('');
        $router->expects($this->once())->method('generate')->with('homepage')->willReturn('/homepage');
    
        // Set customer property via reflection to simulate authenticated user
        $authenticator = new CustomerAuthenticator($entityManager, $router, $csrfTokenManager, $passwordEncoder, $cart);
        $reflection = new \ReflectionClass($authenticator);
        $customerProperty = $reflection->getProperty('customer');
        $customerProperty->setAccessible(true);
        $customerProperty->setValue($authenticator, $customer);
    
        // Act
        $response = $authenticator->onAuthenticationSuccess($request, $token, 'main');
    
        // Assert
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals('/homepage', $response->getTargetUrl());
    }


    public function test_get_credentials_with_missing_csrf_token_field(): void
    {
        // Arrange
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $router = $this->createMock(RouterInterface::class);
        $csrfTokenManager = $this->createMock(CsrfTokenManagerInterface::class);
        $passwordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $cart = $this->createMock(ShoppingCart::class);
        $session = $this->createMock(SessionInterface::class);
        $request = $this->createMock(Request::class);
    
        $request->request = new \Symfony\Component\HttpFoundation\ParameterBag([
            'login' => 'user@example.com',
            'password' => 'ValidPassword123'
        ]);
    
        $request->method('getSession')->willReturn($session);
        $session->expects($this->once())->method('set')->with(
            \Symfony\Component\Security\Core\Security::LAST_USERNAME,
            'user@example.com'
        );
    
        $authenticator = new CustomerAuthenticator($entityManager, $router, $csrfTokenManager, $passwordEncoder, $cart);
    
        // Act
        $credentials = $authenticator->getCredentials($request);
    
        // Assert
        $this->assertEquals('user@example.com', $credentials['login']);
        $this->assertEquals('ValidPassword123', $credentials['password']);
        $this->assertNull($credentials['csrf_token']);
    }


    public function test_get_credentials_with_missing_password_field(): void
    {
        // Arrange
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $router = $this->createMock(RouterInterface::class);
        $csrfTokenManager = $this->createMock(CsrfTokenManagerInterface::class);
        $passwordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $cart = $this->createMock(ShoppingCart::class);
        $session = $this->createMock(SessionInterface::class);
        $request = $this->createMock(Request::class);
    
        $request->request = new \Symfony\Component\HttpFoundation\ParameterBag([
            'login' => 'user@example.com',
            '_csrf_token' => 'valid_token'
        ]);
    
        $request->method('getSession')->willReturn($session);
        $session->expects($this->once())->method('set')->with(
            \Symfony\Component\Security\Core\Security::LAST_USERNAME,
            'user@example.com'
        );
    
        $authenticator = new CustomerAuthenticator($entityManager, $router, $csrfTokenManager, $passwordEncoder, $cart);
    
        // Act
        $credentials = $authenticator->getCredentials($request);
    
        // Assert
        $this->assertEquals('user@example.com', $credentials['login']);
        $this->assertNull($credentials['password']);
        $this->assertEquals('valid_token', $credentials['csrf_token']);
    }


    public function test_get_credentials_with_missing_login_field(): void
    {
        // Arrange
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $router = $this->createMock(RouterInterface::class);
        $csrfTokenManager = $this->createMock(CsrfTokenManagerInterface::class);
        $passwordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $cart = $this->createMock(ShoppingCart::class);
        $session = $this->createMock(SessionInterface::class);
        $request = $this->createMock(Request::class);
    
        $request->request = new \Symfony\Component\HttpFoundation\ParameterBag([
            'password' => 'ValidPassword123',
            '_csrf_token' => 'valid_token'
        ]);
    
        $request->method('getSession')->willReturn($session);
        $session->expects($this->once())->method('set')->with(
            \Symfony\Component\Security\Core\Security::LAST_USERNAME,
            null
        );
    
        $authenticator = new CustomerAuthenticator($entityManager, $router, $csrfTokenManager, $passwordEncoder, $cart);
    
        // Act
        $credentials = $authenticator->getCredentials($request);
    
        // Assert
        $this->assertNull($credentials['login']);
        $this->assertEquals('ValidPassword123', $credentials['password']);
        $this->assertEquals('valid_token', $credentials['csrf_token']);
    }


    public function test_supports_returns_false_when_both_route_and_method_are_incorrect(): void
    {
        // Arrange
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $router = $this->createMock(RouterInterface::class);
        $csrfTokenManager = $this->createMock(CsrfTokenManagerInterface::class);
        $passwordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $cart = $this->createMock(ShoppingCart::class);
        $request = $this->createMock(Request::class);
    
        $request->attributes = new \Symfony\Component\HttpFoundation\ParameterBag(['_route' => 'homepage']);
        $request->method('isMethod')->with('POST')->willReturn(false);
    
        $authenticator = new CustomerAuthenticator($entityManager, $router, $csrfTokenManager, $passwordEncoder, $cart);
    
        // Act
        $result = $authenticator->supports($request);
    
        // Assert
        $this->assertFalse($result);
    }


    public function test_supports_returns_false_when_method_is_not_post(): void
    {
        // Arrange
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $router = $this->createMock(RouterInterface::class);
        $csrfTokenManager = $this->createMock(CsrfTokenManagerInterface::class);
        $passwordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $cart = $this->createMock(ShoppingCart::class);
        $request = $this->createMock(Request::class);
    
        $request->attributes = new \Symfony\Component\HttpFoundation\ParameterBag(['_route' => 'customer_login']);
        $request->method('isMethod')->with('POST')->willReturn(false);
    
        $authenticator = new CustomerAuthenticator($entityManager, $router, $csrfTokenManager, $passwordEncoder, $cart);
    
        // Act
        $result = $authenticator->supports($request);
    
        // Assert
        $this->assertFalse($result);
    }


    public function test_supports_returns_false_when_route_is_not_customer_login(): void
    {
        // Arrange
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $router = $this->createMock(RouterInterface::class);
        $csrfTokenManager = $this->createMock(CsrfTokenManagerInterface::class);
        $passwordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $cart = $this->createMock(ShoppingCart::class);
        $request = $this->createMock(Request::class);
    
        $request->attributes = new \Symfony\Component\HttpFoundation\ParameterBag(['_route' => 'different_route']);
        $request->method('isMethod')->with('POST')->willReturn(true);
    
        $authenticator = new CustomerAuthenticator($entityManager, $router, $csrfTokenManager, $passwordEncoder, $cart);
    
        // Act
        $result = $authenticator->supports($request);
    
        // Assert
        $this->assertFalse($result);
    }


}
