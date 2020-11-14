<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VipController extends AbstractController
{
    /**
     * @Route("/vip", name="vip")
     */
    public function index(): Response
    {
        return $this->render('vip/index.html.twig');
    }
}
