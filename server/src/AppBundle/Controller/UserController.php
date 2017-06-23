<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;

class UserController extends FOSRestController
{
    private $em;

    /**
     * @Rest\View(serializerGroups={"user"})
     * @Rest\Get("/users")
     */
    public function usersAction(Request $request)
    {
        $users = $this->em->getRepository('AppBundle:User')->findBy(array('deletedAt' => null));
        return $users;
    }

    /**
     * @Rest\View(serializerGroups={"user"})
     * @Rest\Get("/user/{id}")
     */
    public function userAction(Request $request)
    {
        $id = $request->get('id');
        $user = $this->em->getRepository('AppBundle:User')->find($id);
        if (empty($user) or !is_null($user->getDeletedAt())) {
            return View::create(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }
        return $user;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/user/{id}")
     */
    public function removeUserAction(Request $request)
    {
        $id = $request->get('id');
        $user = $this->em->getRepository('AppBundle:User')->find($id);
        if ($user and is_null($user->getDeletedAt())) {
            $user->resetFollow();
            $user->setDeletedAt(new \DateTime('now'));
            $this->em->persist($user);
            $this->em->flush();
        }
    }

    public function setContainer(ContainerInterface $container = null) {
        parent::setContainer($container);
        $this->em = $this->getDoctrine()->getManager();
    }
}
