<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(): Response
    {
        return $this->render('blog/index.html.twig');
    }

    /**
     * @Route("/blog/{id}", name="blog_view")
     *
     * @param int $id
     *
     * @return Response
     */
    public function view(int $id = 1): Response
    {
        // todo fetch from db by $id
        return $this->render('blog/view.html.twig');
    }
}
