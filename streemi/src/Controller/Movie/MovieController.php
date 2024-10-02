<?php 

declare(strict_types=1);

namespace App\Controller\Movie;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

// category.html.twig confirm.html.twig detail.html.twig detail_serie.html.twig index.html.twig discover.html.twig

class MovieController extends AbstractController
{
    #[Route(path: '/movies/discover', name: 'discover')]
    public function discover()
    {
        return $this->render(view: 'movie/discover.html.twig');
    }

    #[Route(path: '/movies/category', name: 'category')]
    public function category()
    {
        return $this->render(view: 'movie/category.html.twig');
    }

    #[Route(path: '/movies/detail', name: 'detail')]
    public function detail()
    {
        return $this->render(view: 'movie/detail.html.twig');
    }

    #[Route(path: '/movies/detail-serie', name: 'detail-serie')]
    public function detailSerie()
    {
        return $this->render(view: 'movie/detail_serie.html.twig');
    }

    #[Route(path: '/movies/confirm', name: 'confirm')]
    public function confirm()
    {
        return $this->render(view: 'movie/confirm.html.twig');
    }
}