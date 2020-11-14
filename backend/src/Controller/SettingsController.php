<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangeEmailForm;
use App\Form\ChangePasswordForm;
use App\Form\DeleteAccountForm;
use App\Service\SecurityService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class SettingsController extends AbstractController
{
    /** @var TranslatorInterface */
    private $translator;

    /**
     * SettingsController constructor.
     *
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @Route("/settings", name="settings")
     *
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     *
     * @param Request         $request
     * @param MailerInterface $mailer
     * @param SecurityService $securityService
     *
     * @return Response
     *
     * @throws TransportExceptionInterface
     */
    public function index(Request $request, MailerInterface $mailer, SecurityService $securityService): Response
    {
        $changePasswordForm = $this->tryChangePassword($request, $securityService);
        $changeEmailForm = $this->tryChangeEmail($request, $mailer, $securityService);

        return $this->render(
            'settings/index.html.twig',
            [
                'changePasswordForm' => $changePasswordForm->createView(),
                'changeEmailForm'    => $changeEmailForm->createView(),
            ]
        );
    }

    /**
     * @Route("/settings/delete-account", name="delete_account")
     *
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     *
     * @param Request         $request
     * @param SecurityService $securityService
     *
     * @return Response
     */
    public function deleteAccount(Request $request, SecurityService $securityService): Response
    {
        $deleteAccountForm = $this->tryDeleteAccount($request, $securityService);
        $data = $this->getErrorsFromForm($deleteAccountForm);

        if (!empty($data)) {
            return $this->json($data, 400);
        }

        return $this->json($data);
    }

    /**
     * @Route("/confirm-change-email/{token}", name="confirm_change_email")
     *
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     *
     * @param Request         $request
     * @param SecurityService $securityService
     *
     * @return Response
     */
    public function confirm(Request $request, SecurityService $securityService): Response
    {
        $securityService->confirmChangeEmail($request->get('token'));

        return $this->redirect($this->generateUrl('home'));
    }

    /**
     * @param Request         $request
     * @param SecurityService $securityService
     *
     * @return FormInterface
     */
    private function tryChangePassword(Request $request, SecurityService $securityService): FormInterface
    {
        $user = new User();
        $form = $this->createForm(ChangePasswordForm::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $securityService->changePassword($this->getUser(), $user->getPlainPassword());
            $this->addFlash(
                'success',
                $this->translator->trans('Password was successfully changed!')
            );
        }

        return $form;
    }

    /**
     * @param Request         $request
     * @param MailerInterface $mailer
     * @param SecurityService $securityService
     *
     * @return FormInterface
     *
     * @throws TransportExceptionInterface
     */
    private function tryChangeEmail(
        Request $request,
        MailerInterface $mailer,
        SecurityService $securityService
    ): FormInterface {
        $user = new User();
        $form = $this->createForm(ChangeEmailForm::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UserInterface|User $currentUser */
            $currentUser = $this->getUser();
            $securityService->changeEmail($currentUser, $user->getNewEmail());
            $mailer->send(
                (new Email())
                    ->from($this->getParameter('admin_email'))
                    ->to($currentUser->getEmail())
                    ->subject($this->translator->trans('SignUp Confirm'))
                    ->html(
                        $this->renderView(
                            'emails/confirm_change_email.html.twig',
                            ['token' => $currentUser->getToken()]
                        )
                    )
            );
            $this->addFlash('success', $this->translator->trans('Email changed with success!'));
        }

        return $form;
    }

    /**
     * @param Request         $request
     * @param SecurityService $securityService
     *
     * @return FormInterface
     */
    private function tryDeleteAccount(Request $request, SecurityService $securityService): FormInterface
    {
        $user = new User();
        $form = $this->createForm(DeleteAccountForm::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UserInterface|User $currentUser */
            $currentUser = $this->getUser();
            $securityService->deleteAccount($currentUser);
            $this->addFlash('success', $this->translator->trans('You have successfully deleted your account'));
        }

        return $form;
    }

    /**
     * @param FormInterface $form
     *
     * @return array
     */
    private function getErrorsFromForm(FormInterface $form): array
    {
        $errors = [];

        foreach ($form->getErrors() as $error) {
            $errors[] = $error->getMessage();
        }

        foreach ($form->all() as $childForm) {
            if ($childForm instanceof FormInterface) {
                if ($childErrors = $this->getErrorsFromForm($childForm)) {
                    $errors[$childForm->getName()] = $childErrors;
                }
            }
        }

        return $errors;
    }
}
