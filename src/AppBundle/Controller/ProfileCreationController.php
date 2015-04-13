<?php

namespace AppBundle\Controller;

use AppBundle\CommandBus\CreateProfile;
use AppBundle\Entity\Profile;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ProfileCreationController extends Controller
{
    /**
     * @Route("/api/v1/profiles")
     * @Method({"POST"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function createProfileAction(Request $request)
    {
        $name = $request->request->get('name');

        $this->get('command_bus')->handle(new CreateProfile($name));
        $createdProfile = $this->get('app.profile_repository')->findOneBy(array('name' => $name));

        return new JsonResponse($createdProfile->toArray(), 201);
    }
}