<?php

namespace AppBundle\EventListener;

use DomainException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class DomainExceptionListener
{
    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();
        if ( !$exception instanceof DomainException ) {
            return;
        }

        $error = $exception->getMessage();
        $event->setResponse(new JsonResponse(array('error' => $error), 422));
    }
}