<?php

namespace spec\AppBundle\Entity;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ProfileSpec extends ObjectBehavior
{
    const NAME = 'Arthur Dent';

    function let()
    {
        $this->beConstructedWith(self::NAME);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('AppBundle\Entity\Profile');
    }

    function it_can_be_converted_to_array()
    {
        $this->toArray()->shouldBe(array(
            'id' => null,
            'name' => self::NAME,
        ));
    }
}
