<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Image;
use AppBundle\Entity\Tag;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;

class TagController extends FOSRestController
{
    private $em;

    /**
     * @Rest\View(serializerGroups={"tag"})
     * @Rest\Get("/tags")
     */
    public function tagsAction(Request $request)
    {
        $tag = $this->em->getRepository('AppBundle:Tag')->findAll();
        return $tag;
    }

    public function setContainer(ContainerInterface $container = null) {
        parent::setContainer($container);
        $this->em = $this->getDoctrine()->getManager();
    }
}
