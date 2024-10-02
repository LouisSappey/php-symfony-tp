<?php 

declare(strict_types=1);

namespace App\Controller\Other;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class OtherController extends AbstractController
{
    #[Route(path: 'abonnements', name: 'page_abonnements')]
    public function abonnements()
    {
        return $this->render(view: 'other/abonnements.html.twig');
    }

    #[Route(path: 'upload', name: 'page_upload')]
    public function upload()
    {
        return $this->render(view: 'other/upload.html.twig');
    }

    #[Route(path: 'lists', name: 'page_lists')]
    public function lists()
    {
        return $this->render(view: 'other/lists.html.twig');
    }
}