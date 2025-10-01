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

    

}
