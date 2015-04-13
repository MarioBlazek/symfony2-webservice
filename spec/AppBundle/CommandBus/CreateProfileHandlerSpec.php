<?php

namespace spec\AppBundle\CommandBus;

use AppBundle\CommandBus\CreateProfile;
use AppBundle\Entity\ProfileRepository;
use Doctrine\Common\Persistence\ObjectManager;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CreateProfileHandlerSpec extends ObjectBehavior
{
    const NAME = 'John Cleese';

    function let(ObjectManager $objectManager, ProfileRepository $profileRepository)
    {
        $this->beConstructedWith($objectManager, $profileRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('AppBundle\CommandBus\CreateProfileHandler');
    }

    function it_creates_a_profile(ObjectManager $objectManager, ProfileRepository $profileRepository)
    {
        $profileRepository->findOneBy(array('name' => self::NAME))->willReturn(null);
        $createdProfile = Argument::type('AppBundle\Entity\Profile');
        $objectManager->persist($createdProfile)->shouldBeCalled();

        $this->handle(new CreateProfile(self::NAME));
    }

    function it_cannot_create_the_profile_if_the_name_has_already_been_registered(ProfileRepository $profileRepository)
    {
        $profile = Argument::type('AppBundle\Entity\Profile');
        $profileRepository->findOneBy(array('name' => self::NAME))->willReturn($profile);

        $domainException = '\DomainException';
        $this->shouldThrow($domainException)->duringHandle(new CreateProfile(self::NAME));
    }
}
