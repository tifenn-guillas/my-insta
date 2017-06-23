<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;

class CommentController extends FOSRestController
{
    private $em;

    /**
     * @Rest\View(serializerGroups={"comment"})
     * @Rest\Get("/comments")
     */
    public function commentsAction(Request $request)
    {
        $comments = $this->em->getRepository('AppBundle:Comment')->findBy(array(
            'deletedAt' => null
        ));

        return $comments;
    }

    /**
     * @Rest\View(serializerGroups={"comment"}, statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/comments")
     */
    public function addCommentAction(Request $request)
    {
        $message = $request->request->get('message');
        $user = $this->em->getRepository('AppBundle:User')->find($request->request->get('user'));
        $image = $this->em->getRepository('AppBundle:Image')->find($request->request->get('image'));

        if (!$user or $user->getDeletedAt()) {
            return $this->notFound('User');
        } elseif (!$image or $image->getDeletedAt()) {
            return $this->notFound('Image');
        } elseif (!$message) {
            return $this->noMessage();
        }

        $comment = new Comment();
        $comment->setPostedBy($user);
        $comment->setImage($image);
        $comment->setMessage($message);
        $this->em->persist($comment);
        $this->em->flush();
        return $comment;
    }

    /**
     * @Rest\View(serializerGroups={"comment"})
     * @Rest\Get("/comment/{id}")
     */
    public function commentAction(Request $request)
    {
        $comment = $this->em->getRepository('AppBundle:Comment')->find($request->get('id'));
        return (empty($comment) or !is_null($comment->getDeletedAt())) ? $this->notFound('Comment') : $comment;
    }

    /**
     * @Rest\View(serializerGroups={"comment"})
     * @Rest\Put("/comment/{id}")
     */
    public function updateCommentAction(Request $request)
    {
        $comment = $this->em->getRepository('AppBundle:Comment')->find($request->get('id'));
        $message = $request->request->get('message');

        if (!$comment or $comment->getDeletedAt()) {
            return $this->notFound('Comment');
        } elseif (!$message) {
            return $this->noMessage();
        }

        $comment->setMessage($message);
        $comment->setModifiedAt(new \DateTime('now'));
        $this->em->persist($comment);
        $this->em->flush();

        return $comment;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/comment/{id}")
     */
    public function removeCommentAction(Request $request)
    {
        $id = $request->get('id');
        $comment = $this->em->getRepository('AppBundle:Comment')->find($id);
        if ($comment and is_null($comment->getDeletedAt())) {
            $comment->setDeletedAt(new \DateTime('now'));
            $this->em->persist($comment);
            $this->em->flush();
        }
    }

    private function noMessage()
    {
        return View::create(['message' => 'Comment message required'], Response::HTTP_CONFLICT);
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
