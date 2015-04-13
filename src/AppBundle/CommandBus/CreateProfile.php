<?php

namespace AppBundle\CommandBus;

use SimpleBus\Message\Message;

class CreateProfile implements Message
{
    public $name;

    public function __construct($name)
    {
        if ( null === $name ) {
            throw new \DomainException('The "name" parameter is missing from the request\'s body');
        }
        $this->name = $name;
    }
}