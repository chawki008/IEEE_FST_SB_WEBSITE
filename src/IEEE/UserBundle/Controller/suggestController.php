<?php

namespace IEEE\UserBundle\Controller;

use IEEE\UserBundle\Entity\suggest;
use IEEE\UserBundle\Entity\comment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
/**
 * Suggest controller.
 *
 * @Route("suggest")
 */
class suggestController extends Controller
{
    /**
     * Lists all suggest entities.
     *
     * @Route("/", name="suggest_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $suggests = $em->getRepository('IEEEUserBundle:suggest')->findAll();
        $tab=[];
        foreach ($suggests as $suggest) {
            $tab[$suggest->getId()]=[$suggest->getContent(),$suggest->getDate()->format('d-m-Y'),$suggest->getUser()->getUsername()];
        }
        return new JsonResponse ($tab)
        ;
    }

    /**
     * Creates a new suggest entity.
     *
     * @Route("/new", name="suggest_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {   
        $suggest = new Suggest();
        $em = $this->getDoctrine()->getManager();
        if(!$request->get('suggest_content')) return new Response("suggest_content not found",404);
        $content=trim($request->get('suggest_content'));
        if(!$request->get('user_id')) return new Response("user_id not found",404);
        $id=trim($request->get('user_id'));
        $date=date_create(date("Y/m/d"));  
        $suggest->setContent($content);
        $suggest->setDate($date);
        $query = $em->createQuery("SELECT u FROM \IEEE\UserBundle\Entity\User u WHERE u.id = :id");
        $query->setParameter('id', $id);
        $user= $query->getOneOrNullResult();
        if(!$user) return new Response("user not found",404);
        $suggest->setUser($user);
        $em->persist($suggest);
        $em->flush($suggest);
        return new Response("Ok");
        
    }

    /**
     * Finds and displays a suggest entity.
     *
     * @Route("/{id}/comment", name="suggest_show")
     * @Method({"GET","POST"})
     */
    public function showAction(suggest $suggest , request $request)
    {   
        $em = $this->getDoctrine()->getManager();
        $comment = new Comment();
        if (!$request->get('comment_content')) return new Response("comment_content not found",404);
        $content = $request->get('comment_content');
        $id=trim($request->get('user_id'));
        $date=date_create(date("Y/m/d"));
        $query = $em->createQuery("SELECT u FROM \IEEE\UserBundle\Entity\User u WHERE u.id = :id");
        $query->setParameter('id', $id);
        $user= $query->getOneOrNullResult();
        if(!$user) return new Response("user not found",404);
        $comment->setUser($user);
        $comment->setContent($content);
        $comment->setDate($date);
        $comment->setSuggest($suggest);
        $em->persist($comment);
        $em->flush($comment);
        $suggest->addComment($comment);
        $em->persist($suggest);
        $em->flush($suggest);
        return new Response('Ok');





    }

    /**
     * Displays a form to edit an existing suggest entity.
     *
     * @Route("/{id}/edit", name="suggest_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, suggest $suggest)
    {
        $deleteForm = $this->createDeleteForm($suggest);
        $editForm = $this->createForm('IEEE\UserBundle\Form\suggestType', $suggest);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('suggest_edit', array('id' => $suggest->getId()));
        }

        return $this->render('suggest/edit.html.twig', array(
            'suggest' => $suggest,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a suggest entity.
     *
     * @Route("/{id}", name="suggest_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, suggest $suggest)
    {
        $form = $this->createDeleteForm($suggest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($suggest);
            $em->flush($suggest);
        }

        return $this->redirectToRoute('suggest_index');
    }

    /**
     * Creates a form to delete a suggest entity.
     *
     * @param suggest $suggest The suggest entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(suggest $suggest)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('suggest_delete', array('id' => $suggest->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Displays a form to edit an existing suggest entity.
     *
     * @Route("/{id}/comments", name="suggest_show_comments")
     * @Method({"GET", "POST"})
     */
    public function showCommentsAction(Request $request, suggest $suggest)
    {
        $em = $this->getDoctrine()->getManager();
        $sug = $em->getRepository('IEEEUserBundle:suggest')->find($suggest);
        $comments=$sug->getComments();
        foreach ($comments as $value) {
            $tab[$value->getId()]=[$value->getId(),$value->getContent(),$value->getDate()->format('d-m-Y'),$value->getUser()->getUsername(),$value->getUser()->getId()];
        }
        return new JsonResponse($tab);

        }
}
