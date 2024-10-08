<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route(path: '/home', name: 'page_homepage')]
    public function home()
    {
        return $this->render(view: 'index.html.twig');
    }
}
