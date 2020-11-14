<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LanguageController extends AbstractController
{
    /**
     * @Route("/set-language/{locale}", name="set_language", methods="GET", requirements={"locale"="[a-z_A-Z]+"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function setLanguage(Request $request): Response
    {
        $response = new Response();
        $response->headers->setCookie(
            Cookie::create('locale')
                ->withValue($request->get('locale'))
                ->withExpires('+1 year')
                ->withDomain($request->getHost())
                ->withSecure($request->isSecure())
        );
        $response->headers->set('Location', $request->headers->get('referer', '/'));

        return $response;
    }
}
