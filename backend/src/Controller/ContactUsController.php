<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\ContactMessage;
use App\Form\ContactMessageForm;
use App\Service\ContactMessageService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class ContactUsController extends AbstractController
{
    /**
     * @var TranslatorInterface $translator
     */
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @Route("/contact-us", name="contact-us")
     *
     * @param Request               $request
     * @param MailerInterface       $mailer
     * @param ContactMessageService $contactMessageService
     *
     * @return Response
     *
     * @throws TransportExceptionInterface
     */
    public function index(
        Request $request,
        MailerInterface $mailer,
        ContactMessageService $contactMessageService
    ): Response {
        $contactUsForm = $this->tryContactUs($request, $mailer, $contactMessageService);

        return $this->render(
            'contact-us/index.html.twig',
            [
                'contactUsForm' => $contactUsForm->createView(),
                'themes'        => $contactMessageService->getAvailableThemes(),
            ]
        );
    }

    /**
     * @param Request               $request
     * @param MailerInterface       $mailer
     * @param ContactMessageService $contactMessageService
     *
     * @return FormInterface
     *
     * @throws TransportExceptionInterface
     */
    private function tryContactUs(
        Request $request,
        MailerInterface $mailer,
        ContactMessageService $contactMessageService
    ): FormInterface {
        $contactMessage = new ContactMessage();
        $contactMessage->setIp($request->getClientIp());
        $form = $this->createForm(ContactMessageForm::class, $contactMessage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactMessage = $contactMessageService->createInbox($contactMessage);
            $mailer->send(
                (new Email())
                    ->from($contactMessage->getEmail())
                    ->to($this->getParameter('admin_email'))
                    ->subject($contactMessage->getName())
                    ->html($contactMessage->getContent())
            );

            $this->addFlash('success', $this->translator->trans('Success'));
        }

        return $form;
    }
}
