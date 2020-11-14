<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class LanguageSubscriber implements EventSubscriberInterface
{
    private $supportedLanguages;

    public function __construct(array $languages)
    {
        $this->supportedLanguages = $languages;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();
        $request->setLocale(
            $request->cookies->get('locale', $request->getPreferredLanguage($this->supportedLanguages))
        );
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.request' => [['onKernelRequest', 20]],
        ];
    }
}
