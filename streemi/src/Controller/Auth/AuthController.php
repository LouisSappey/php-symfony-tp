<?php 

declare(strict_types=1);

namespace App\Controller\Auth;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    #[Route(path: '/login', name: 'login')]
    public function login()
    {
        return $this->render(view: 'auth/login.html.twig');
    }

    #[Route(path: '/register', name: 'register')]
    public function register()
    {
        return $this->render(view: 'auth/register.html.twig');
    }

    #[Route(path: '/forgot-password', name: 'forgot-password')]
    public function forgotPassword()
    {
        return $this->render(view: 'auth/forgot.html.twig');
    }

    #[Route(path: '/reset-password', name: 'reset-password')]
    public function resetPassword()
    {
        return $this->render(view: 'auth/reset.html.twig');
    }
}