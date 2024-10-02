<?php 

declare(strict_types=1);

namespace App\Controller\Movie;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

// category.html.twig confirm.html.twig detail.html.twig detail_serie.html.twig index.html.twig discover.html.twig

class MovieController extends AbstractController
{
    #[Route(path: '/movies/discover', name: 'page_discover')]
    public function discover()
    {
        return $this->render(view: 'movie/discover.html.twig');
    }

    #[Route(path: '/movies/category', name: 'page_category')]
    public function category()
    {
        return $this->render(view: 'movie/category.html.twig');
    }

    #[Route(path: '/movies/detail', name: 'page_detail')]
    public function detail()
    {
        return $this->render(view: 'movie/detail.html.twig');
    }

    #[Route(path: '/movies/detail-serie', name: 'page_detail_serie')]
    public function detailSerie()
    {
        return $this->render(view: 'movie/detail_serie.html.twig');
    }

    #[Route(path: '/movies/confirm', name: 'page_confirm')]
    public function confirm()
    {
        return $this->render(view: 'movie/confirm.html.twig');
    }
}