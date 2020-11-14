<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    /**
     * @Route("/account", name="account")
     */
    public function index(): Response
    {
        return $this->render('account/index.html.twig');
    }

    /**
     * @Route("/account/{id}", name="account_view")
     *
     * @param int $id
     *
     * @return Response
     */
    public function view(int $id = 1): Response
    {
        // todo fetch from db by $id
        return $this->render('account/view.html.twig');
    }
}
