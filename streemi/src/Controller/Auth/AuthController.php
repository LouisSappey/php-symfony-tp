<?php 

declare(strict_types=1);

namespace App\Controller\Auth;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    #[Route(path: '/login', name: 'page_login')]
    public function login()
    {
        return $this->render(view: 'auth/login.html.twig');
    }

    #[Route(path: '/register', name: 'page_register')]
    public function register()
    {
        return $this->render(view: 'auth/register.html.twig');
    }

    #[Route(path: '/forgot-password', name: 'page_forgot_password')]
    public function forgotPassword()
    {
        return $this->render(view: 'auth/forgot.html.twig');
    }

    #[Route(path: '/reset-password', name: 'page_reset-password')]
    public function resetPassword()
    {
        return $this->render(view: 'auth/reset.html.twig');
    }
}