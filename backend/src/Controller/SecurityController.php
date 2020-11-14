<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationForm;
use App\Security\LoginFormAuthenticator;
use App\Service\SecurityService;
use LogicException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/sign-in", name="signin")
     *
     * @param AuthenticationUtils $authenticationUtils
     *
     * @return Response
     */
    public function signIn(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'security/sign-in.html.twig',
            [
                'last_username' => $lastUsername,
                'error'         => $error,
            ]
        );
    }

    /**
     * @Route("/sign-up", name="signup")
     *
     * @param Request         $request
     * @param MailerInterface $mailer
     * @param SecurityService $securityService
     *
     * @return Response
     *
     * @throws TransportExceptionInterface
     */
    public function signUp(Request $request, MailerInterface $mailer, SecurityService $securityService): Response
    {
        $registrationForm = $this->tryRegistration($request, $mailer, $securityService);

        return $this->render(
            'security/sign-up.html.twig',
            [
                'registrationForm' => $registrationForm->createView(),
            ]
        );
    }

    /**
     * @Route("/confirm/{token}", name="confirm")
     *
     * @param Request                   $request
     * @param SecurityService           $securityService
     * @param GuardAuthenticatorHandler $guardHandler
     * @param LoginFormAuthenticator    $loginFormAuthenticator
     *
     * @return Response
     */
    public function confirm(
        Request $request,
        SecurityService $securityService,
        GuardAuthenticatorHandler $guardHandler,
        LoginFormAuthenticator $loginFormAuthenticator
    ): Response {
        $guardHandler->authenticateUserAndHandleSuccess(
            $securityService->confirmRegistration($request->get('token')),
            $request,
            $loginFormAuthenticator,
            'main'
        );

        return $this->redirect($this->generateUrl('home'));
    }

    /**
     * @Route("/logout", name="logout")
     *
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function logout()
    {
        throw new LogicException(
            'This method can be blank - it will be intercepted by the logout key on your firewall.'
        );
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
    private function tryRegistration(
        Request $request,
        MailerInterface $mailer,
        SecurityService $securityService
    ): FormInterface {
        $user = new User();
        $form = $this->createForm(RegistrationForm::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $securityService->register($user);
            $mailer->send(
                (new Email())
                    ->from($this->getParameter('admin_email'))
                    ->to($user->getEmail())
                    ->subject('Account confirmation')
                    ->html(
                        $this->renderView(
                            'emails/confirm_registration.html.twig',
                            ['token' => $user->getToken()]
                        )
                    )
            );
            $this->addFlash('success', 'Success');
        }

        return $form;
    }
}
