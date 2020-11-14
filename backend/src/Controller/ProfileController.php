<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Service\ProfileService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="profile", methods={"GET"})
     *
     * @param ProfileService $profileService
     *
     * @return Response
     */
    public function index(ProfileService $profileService): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();

        return $this->render(
            'profile/index.html.twig',
            [
                'forms' => $profileService->generateEditFormsViews($currentUser),
            ]
        );
    }

    /**
     * @Route("/profile/edit", name="profile_edit", methods={"POST"})
     *
     * @param Request             $request
     * @param ProfileService      $profileService
     * @param TranslatorInterface $translator
     *
     * @return Response
     *
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws Exception
     */
    public function edit(Request $request, ProfileService $profileService, TranslatorInterface $translator): Response
    {
        $form = $profileService->handleFormEdit($request->request->all(), $this->getUser());
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $profileService->updateUserData($form->getData());
            $this->addFlash(
                'success',
                $translator->trans('Profile was updated successfully')
            );

            return $this->redirectToRoute('profile');
        }
        $formViews = $profileService->generateEditFormsViews($this->getUser());
        $formViews[$form->getName()] = $form->createView();

        return $this->render(
            'profile/index.html.twig',
            [
                'forms' => $formViews,
            ]
        );
    }

    /**
     * @Route("/profile/create", name="profile_create")
     *
     * @return Response
     */
    public function create(): Response
    {
        return $this->render('profile/create.html.twig');
    }
}
