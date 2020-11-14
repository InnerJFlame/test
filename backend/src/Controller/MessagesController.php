<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessagesController extends AbstractController
{
    /**
     * @Route("/messages", name="messages")
     */
    public function index(): Response
    {
        return $this->render('messages/index.html.twig');
    }

    /**
     * @Route("/messages/{id}", name="message_view")
     *
     * @param int $id
     *
     * @return Response
     */
    public function view(int $id = 1): Response
    {
        // todo fetch from db by $id
        return $this->render('messages/view.html.twig');
    }
}
