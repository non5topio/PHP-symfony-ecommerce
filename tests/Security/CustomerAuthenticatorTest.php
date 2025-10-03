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
    public function testSupportsReturnsTrueForLoginPost(): void
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
        
        $request = Request::create('/login', 'POST');
        $request->attributes->set('_route', 'customer_login');
        
        $this->assertTrue($authenticator->supports($request));
    }


    public function testSupportsReturnsFalseForLoginGet(): void
    {
        // Mock dependencies
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $router = $this->createMock(RouterInterface::class);
        $csrfTokenManager = $this->createMock(CsrfTokenManagerInterface::class);
        $passwordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $cart = $this->createMock(ShoppingCart::class);
        
        // Create authenticator
        $authenticator = new CustomerAuthenticator(
            $entityManager,
            $router,
            $csrfTokenManager,
            $passwordEncoder,
            $cart
        );
        
        // Create GET request to login route
        $request = Request::create('/login', 'GET');
        $request->attributes->set('_route', 'customer_login');
        
        // Test supports method
        $result = $authenticator->supports($request);
        
        // Assert authentication is not supported for GET method
        $this->assertFalse($result);
    }


    public function testAuthenticationFailsWithIncorrectPassword(): void
    {
        // Mock dependencies
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $router = $this->createMock(RouterInterface::class);
        $csrfTokenManager = $this->createMock(CsrfTokenManagerInterface::class);
        $passwordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $cart = $this->createMock(ShoppingCart::class);
        
        // Create authenticator
        $authenticator = new CustomerAuthenticator(
            $entityManager,
            $router,
            $csrfTokenManager,
            $passwordEncoder,
            $cart
        );
        
        // Create credentials with incorrect password
        $credentials = [
            'login' => 'test_user',
            'password' => 'wrong_password',
            'csrf_token' => 'valid_token'
        ];
        
        // Mock user
        $user = $this->createMock(Customer::class);
        
        // Mock password encoder to return false (invalid password)
        $passwordEncoder->expects($this->once())
            ->method('isPasswordValid')
            ->with($user, 'wrong_password')
            ->willReturn(false);
        
        // Test checkCredentials
        $result = $authenticator->checkCredentials($credentials, $user);
        
        // Assert authentication fails
        $this->assertFalse($result);
    }


    public function testAuthenticationFailsWithNonExistentUser(): void
    {
        // Mock dependencies
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $router = $this->createMock(RouterInterface::class);
        $csrfTokenManager = $this->createMock(CsrfTokenManagerInterface::class);
        $passwordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $cart = $this->createMock(ShoppingCart::class);
        
        // Create authenticator
        $authenticator = new CustomerAuthenticator(
            $entityManager,
            $router,
            $csrfTokenManager,
            $passwordEncoder,
            $cart
        );
        
        // Create credentials with non-existent login
        $credentials = [
            'login' => 'non_existent_user',
            'password' => 'password123',
            'csrf_token' => 'valid_token'
        ];
        
        // Mock CSRF token validation to succeed
        $csrfTokenManager->expects($this->once())
            ->method('isTokenValid')
            ->willReturn(true);
        
        // Mock repository to return null (user not found)
        $repository = $this->createMock(EntityRepository::class);
        $repository->expects($this->once())
            ->method('findOneBy')
            ->with(['login' => 'non_existent_user'])
            ->willReturn(null);
        
        $entityManager->expects($this->once())
            ->method('getRepository')
            ->willReturn($repository);
        
        // Expect CustomUserMessageAuthenticationException with specific message
        $this->expectException(CustomUserMessageAuthenticationException::class);
        $this->expectExceptionMessage('Login could not be found.');
        
        // Call getUser which should throw the exception
        $authenticator->getUser($credentials, $this->createMock(UserProviderInterface::class));
    }


    public function testAuthenticationFailsWithInvalidCsrfToken(): void
    {
        // Mock dependencies
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $router = $this->createMock(RouterInterface::class);
        $csrfTokenManager = $this->createMock(CsrfTokenManagerInterface::class);
        $passwordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $cart = $this->createMock(ShoppingCart::class);
        
        // Create authenticator
        $authenticator = new CustomerAuthenticator(
            $entityManager,
            $router,
            $csrfTokenManager,
            $passwordEncoder,
            $cart
        );
        
        // Create credentials with invalid CSRF token
        $credentials = [
            'login' => 'test_user',
            'password' => 'password123',
            'csrf_token' => 'invalid_token'
        ];
        
        // Mock CSRF token validation to fail
        $csrfTokenManager->expects($this->once())
            ->method('isTokenValid')
            ->willReturn(false);
        
        // Expect InvalidCsrfTokenException
        $this->expectException(InvalidCsrfTokenException::class);
        
        // Call getUser which should throw the exception
        $authenticator->getUser($credentials, $this->createMock(UserProviderInterface::class));
    }


    public function testSuccessfulAuthenticationWithRedirectToHomepage(): void
    {
        // Mock dependencies
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $router = $this->createMock(RouterInterface::class);
        $csrfTokenManager = $this->createMock(CsrfTokenManagerInterface::class);
        $passwordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $cart = $this->createMock(ShoppingCart::class);
        
        // Create authenticator
        $authenticator = new CustomerAuthenticator(
            $entityManager,
            $router,
            $csrfTokenManager,
            $passwordEncoder,
            $cart
        );
        
        // Create request
        $request = Request::create('/login', 'POST');
        
        // Mock session with no target path
        $session = $this->createMock(SessionInterface::class);
        $session->expects($this->once())
            ->method('get')
            ->with('_security.main.target_path')
            ->willReturn(null);
        $request->method('getSession')->willReturn($session);
        
        // Mock customer
        $customer = $this->createMock(Customer::class);
        
        // Mock router to generate homepage URL
        $router->expects($this->once())
            ->method('generate')
            ->with('homepage')
            ->willReturn('/home');
        
        // Mock cart merge
        $cart->expects($this->once())
            ->method('mergeCarts')
            ->with($customer);
        
        // Create token
        $token = $this->createMock(TokenInterface::class);
        
        // Test onAuthenticationSuccess with no target path
        $response = $authenticator->onAuthenticationSuccess($request, $token, 'main');
        
        // Assert redirect to homepage
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals('/home', $response->getTargetUrl());
    }


    public function testSuccessfulAuthenticationWithValidCredentials(): void
    {
        // Mock dependencies
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $router = $this->createMock(RouterInterface::class);
        $csrfTokenManager = $this->createMock(CsrfTokenManagerInterface::class);
        $passwordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $cart = $this->createMock(ShoppingCart::class);
        
        // Create authenticator
        $authenticator = new CustomerAuthenticator(
            $entityManager,
            $router,
            $csrfTokenManager,
            $passwordEncoder,
            $cart
        );
        
        // Create request with valid credentials
        $request = Request::create('/login', 'POST');
        $request->request->set('login', 'test_user');
        $request->request->set('password', 'password123');
        $request->request->set('_csrf_token', 'valid_token');
        
        // Mock session
        $session = $this->createMock(SessionInterface::class);
        $session->expects($this->once())
            ->method('set')
            ->with('_security.last_username', 'test_user');
        $request->method('getSession')->willReturn($session);
        
        // Test getCredentials
        $credentials = $authenticator->getCredentials($request);
        $this->assertEquals('test_user', $credentials['login']);
        $this->assertEquals('password123', $credentials['password']);
        $this->assertEquals('valid_token', $credentials['csrf_token']);
        
        // Mock repository and customer
        $customer = $this->createMock(Customer::class);
        $repository = $this->createMock(EntityRepository::class);
        $repository->expects($this->once())
            ->method('findOneBy')
            ->with(['login' => 'test_user'])
            ->willReturn($customer);
        
        $entityManager->expects($this->once())
            ->method('getRepository')
            ->willReturn($repository);
        
        // Mock CSRF token validation
        $csrfTokenManager->expects($this->once())
            ->method('isTokenValid')
            ->willReturn(true);
        
        // Test getUser
        $user = $authenticator->getUser($credentials, $this->createMock(UserProviderInterface::class));
        $this->assertSame($customer, $user);
        
        // Test checkCredentials
        $passwordEncoder->expects($this->once())
            ->method('isPasswordValid')
            ->with($customer, 'password123')
            ->willReturn(true);
        
        $result = $authenticator->checkCredentials($credentials, $customer);
        $this->assertTrue($result);
        
        // Test onAuthenticationSuccess with target path
        $token = $this->createMock(TokenInterface::class);
        $session->expects($this->once())
            ->method('get')
            ->with('_security.main.target_path')
            ->willReturn('/target');
        
        $cart->expects($this->once())
            ->method('mergeCarts')
            ->with($customer);
        
        $response = $authenticator->onAuthenticationSuccess($request, $token, 'main');
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals('/target', $response->getTargetUrl());
    }


    public function testGetCredentialsWithEmptyStrings(): void
    {
        // Mock dependencies
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $router = $this->createMock(RouterInterface::class);
        $csrfTokenManager = $this->createMock(CsrfTokenManagerInterface::class);
        $passwordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $cart = $this->createMock(ShoppingCart::class);
        
        // Create authenticator
        $authenticator = new CustomerAuthenticator(
            $entityManager,
            $router,
            $csrfTokenManager,
            $passwordEncoder,
            $cart
        );
        
        // Create request with empty string parameters
        $request = Request::create('/login', 'POST');
        $request->request->set('login', '');
        $request->request->set('password', '');
        $request->request->set('_csrf_token', '');
        
        // Mock session
        $session = $this->createMock(SessionInterface::class);
        $session->expects($this->once())
            ->method('set')
            ->with('_security.last_username', '');
        $request->method('getSession')->willReturn($session);
        
        // Test getCredentials with empty strings
        $credentials = $authenticator->getCredentials($request);
        
        // Assert credentials array contains empty strings
        $this->assertSame('', $credentials['login']);
        $this->assertSame('', $credentials['password']);
        $this->assertSame('', $credentials['csrf_token']);
    }


    public function testGetCredentialsWithMissingFields(): void
    {
        // Mock dependencies
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $router = $this->createMock(RouterInterface::class);
        $csrfTokenManager = $this->createMock(CsrfTokenManagerInterface::class);
        $passwordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $cart = $this->createMock(ShoppingCart::class);
        
        // Create authenticator
        $authenticator = new CustomerAuthenticator(
            $entityManager,
            $router,
            $csrfTokenManager,
            $passwordEncoder,
            $cart
        );
        
        // Create request with missing parameters
        $request = Request::create('/login', 'POST');
        
        // Mock session
        $session = $this->createMock(SessionInterface::class);
        $session->expects($this->once())
            ->method('set')
            ->with('_security.last_username', null);
        $request->method('getSession')->willReturn($session);
        
        // Test getCredentials with missing fields
        $credentials = $authenticator->getCredentials($request);
        
        // Assert credentials array contains null values
        $this->assertNull($credentials['login']);
        $this->assertNull($credentials['password']);
        $this->assertNull($credentials['csrf_token']);
    }


    public function testSupportsReturnsFalseForWrongRoute(): void
    {
        // Mock dependencies
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $router = $this->createMock(RouterInterface::class);
        $csrfTokenManager = $this->createMock(CsrfTokenManagerInterface::class);
        $passwordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $cart = $this->createMock(ShoppingCart::class);
        
        // Create authenticator
        $authenticator = new CustomerAuthenticator(
            $entityManager,
            $router,
            $csrfTokenManager,
            $passwordEncoder,
            $cart
        );
        
        // Test with customer_register route
        $request = Request::create('/register', 'POST');
        $request->attributes->set('_route', 'customer_register');
        $this->assertFalse($authenticator->supports($request));
        
        // Test with homepage route
        $requestHome = Request::create('/home', 'POST');
        $requestHome->attributes->set('_route', 'homepage');
        $this->assertFalse($authenticator->supports($requestHome));
        
        // Test with null route
        $requestNull = Request::create('/login', 'POST');
        $requestNull->attributes->set('_route', null);
        $this->assertFalse($authenticator->supports($requestNull));
    }


    public function testSupportsReturnsFalseForNonPostMethods(): void
    {
        // Mock dependencies
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $router = $this->createMock(RouterInterface::class);
        $csrfTokenManager = $this->createMock(CsrfTokenManagerInterface::class);
        $passwordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $cart = $this->createMock(ShoppingCart::class);
        
        // Create authenticator
        $authenticator = new CustomerAuthenticator(
            $entityManager,
            $router,
            $csrfTokenManager,
            $passwordEncoder,
            $cart
        );
        
        // Test PUT method
        $requestPut = Request::create('/login', 'PUT');
        $requestPut->attributes->set('_route', 'customer_login');
        $this->assertFalse($authenticator->supports($requestPut));
        
        // Test DELETE method
        $requestDelete = Request::create('/login', 'DELETE');
        $requestDelete->attributes->set('_route', 'customer_login');
        $this->assertFalse($authenticator->supports($requestDelete));
        
        // Test PATCH method
        $requestPatch = Request::create('/login', 'PATCH');
        $requestPatch->attributes->set('_route', 'customer_login');
        $this->assertFalse($authenticator->supports($requestPatch));
    }


    public function testGetLoginUrlReturnsCustomerLoginRoute(): void
    {
        // Mock dependencies
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $router = $this->createMock(RouterInterface::class);
        $csrfTokenManager = $this->createMock(CsrfTokenManagerInterface::class);
        $passwordEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $cart = $this->createMock(ShoppingCart::class);
        
        // Mock router to return login URL
        $router->expects($this->once())
            ->method('generate')
            ->with('customer_login')
            ->willReturn('/customer/login');
        
        // Create authenticator
        $authenticator = new CustomerAuthenticator(
            $entityManager,
            $router,
            $csrfTokenManager,
            $passwordEncoder,
            $cart
        );
        
        // Use reflection to access protected method
        $reflection = new \ReflectionClass($authenticator);
        $method = $reflection->getMethod('getLoginUrl');
        $method->setAccessible(true);
        
        // Call getLoginUrl
        $result = $method->invoke($authenticator);
        
        // Assert correct URL is returned
        $this->assertEquals('/customer/login', $result);
    }

    

}
