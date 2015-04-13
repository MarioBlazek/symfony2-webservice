<?php

namespace AppBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ForbiddenExceptionListener
{
    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        if ( !$exception instanceof AccessDeniedException ) {
            return;
        }

        $error = 'The credentials are either missing or incorrect';
        $event->setResponse(new JsonResponse(array('error' => $error), 403));
    }
}