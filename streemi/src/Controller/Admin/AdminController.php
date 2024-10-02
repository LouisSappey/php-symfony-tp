<?php 

declare(strict_types=1);

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route(path: '/admin', name: 'page_admin')]
    public function admin()
    {
        return $this->render(view: 'admin/admin.html.twig');
    }

    #[Route(path: '/admin/users', name: 'page_admin_users')]
    public function users()
    {
        return $this->render(view: 'admin/admin_users.html.twig');
    }
    // admin_add_fils.html.twig admin_films.html.twig

    #[Route(path: '/admin/films', name: 'page_admin_films')]
    public function films()
    {
        return $this->render(view: 'admin/admin_films.html.twig');
    }

    #[Route(path: '/admin/add-films', name: 'page_admin_add_films')]
    public function addFilms()
    {
        return $this->render(view: 'admin/admin_add_films.html.twig');
    }
}