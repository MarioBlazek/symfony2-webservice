<?php

namespace AppBundle\CommandBus;

use AppBundle\Entity\Profile;
use AppBundle\Entity\ProfileRepository;
use Doctrine\Common\Persistence\ObjectManager;
use SimpleBus\Message\Handler\MessageHandler;
use SimpleBus\Message\Message;

class CreateProfileHandler implements MessageHandler
{

    private $objectManager;
    private $profileRepository;

    public function __construct(ObjectManager $objectManager, ProfileRepository $profileRepository)
    {
        $this->objectManager = $objectManager;
        $this->profileRepository = $profileRepository;
    }

    public function handle(Message $message)
    {
        $profile = $this->profileRepository->findOneBy(array('name' => $message->name));

        if ( null !== $profile ) {
            throw new \DomainException(sprintf("The name %s is already taken", $message->name));
        }
        $newProfile = new Profile($message->name);
        $this->objectManager->persist($newProfile);
        $this->objectManager->flush();
    }
}
