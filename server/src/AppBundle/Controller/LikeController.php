<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;

class LikeController extends FOSRestController
{
    private $em;

    /**
     * @Rest\View(serializerGroups={"image"}, statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/like")
     */
    public function addLikeAction(Request $request)
    {
        $user = $this->em->getRepository('AppBundle:User')->find($request->get('user'));
        $image = $this->em->getRepository('AppBundle:Image')->find($request->get('image'));

        if (!$user or $user->getDeletedAt()) {
            return $this->notFound('User');
        }
        if (!$image or $image->getDeletedAt()) {
            return $this->notFound('Image');
        }

        $image->addLikes($user);
        $this->em->persist($image);
        $this->em->flush();
        return $image;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/like")
     */
    public function removeLikeAction(Request $request)
    {
        $user = $this->em->getRepository('AppBundle:User')->find($request->get('user'));
        $image = $this->em->getRepository('AppBundle:Image')->find($request->get('image'));

        if (!$user or $user->getDeletedAt()) {
            return $this->notFound('User');
        }
        if (!$image or $image->getDeletedAt()) {
            return $this->notFound('Image');
        }

        $image->removeLikes($user);
        $this->em->persist($image);
        $this->em->flush();
    }

    private function notFound($object)
    {
        return View::create(['message' => "$object not found"], Response::HTTP_NOT_FOUND);
    }

    public function setContainer(ContainerInterface $container = null) {
        parent::setContainer($container);
        $this->em = $this->getDoctrine()->getManager();
    }
}
