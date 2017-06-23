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

class ImageController extends FOSRestController
{
    private $em;

    /**
     * @Rest\View(serializerGroups={"image"})
     * @Rest\Get("/images")
     */
    public function imagesAction(Request $request)
    {
        $images = $this->em->getRepository('AppBundle:Image')->findBy(array('deletedAt' => null));
        return $images;
    }

    /**
     * @Rest\View(serializerGroups={"image"}, statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/images")
     */
    public function addImageAction(Request $request)
    {
        $user = $this->em->getRepository('AppBundle:User')->find($request->request->get('user'));
        $description = $request->request->get('description');
        $tags = $request->request->get('tags');

        if (!$user or $user->getDeletedAt()) {
            return $this->notFound('User');
        }

        $image = new Image();
        $image->setUploadedBy($user);
        $image->setDescription($description);
        foreach ($tags as $t) {
            $tag = $this->em->getRepository('AppBundle:Tag')->find($t);
            if (!$tag) {
                $tag = new Tag();
                $tag->setTag($t);
                $this->em->persist($tag);
            }
            $image->addTags($tag);
        }
        $this->em->persist($image);
        $this->em->flush();
        return $image;
    }

    /**
     * @Rest\View(serializerGroups={"image"})
     * @Rest\Get("/image/{id}")
     */
    public function imageAction(Request $request)
    {
        $id = $request->get('id');
        $image = $this->em->getRepository('AppBundle:Image')->find($id);
        return (empty($image) or !is_null($image->getDeletedAt())) ? $this->notFound('Image') : $image;
    }

    /**
     * @Rest\View(serializerGroups={"image"})
     * @Rest\Put("/image/{id}")
     */
    public function updateImageAction(Request $request)
    {
        $image = $this->em->getRepository('AppBundle:Image')->find($request->get('id'));
        $description = $request->request->get('description');
        $tags = $request->request->get('tags');

        if (!$image or $image->getDeletedAt()) {
            return $this->notFound('Image');
        }
        $tagsOld = $image->getTags();

        $image->setDescription($description);
        foreach ($tagsOld as $t) {
            $image->removeTags($t);
        }
        foreach ($tags as $t) {
            $tag = $this->em->getRepository('AppBundle:Tag')->find($t);
            if (!$tag) {
                $tag = new Tag();
                $tag->setTag($t);
                $this->em->persist($tag);
            }
            $image->addTags($tag);
        }
        $image->setModifiedAt(new \DateTime('now'));
        $this->em->persist($image);
        $this->em->flush();
        return $image; // TODO: return updated object
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/image/{id}")
     */
    public function removeImageAction(Request $request)
    {
        $image = $this->em->getRepository('AppBundle:Image')->find($request->get('id'));
        if ($image and is_null($image->getDeletedAt())) {
            $image->setDeletedAt(new \DateTime('now'));
            $this->em->persist($image);
            $this->em->flush();
        }
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
