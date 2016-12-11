<?php

namespace IEEE\UserBundle\Controller;

use IEEE\UserBundle\Entity\User;
use IEEE\UserBundle\Entity\task;
use IEEE\UserBundle\Entity\UserTask;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use IEEE\UserBundle\Entity\feedback;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * Task controller.
 *
 * @Route("task")
 */
class taskController extends Controller
{
    /**
     * Lists all task entities.
     *
     * @Route("/", name="task_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tasks = $em->getRepository('IEEEUserBundle:task')->findAll();

        return $this->render('task/index.html.twig', array(
            'tasks' => $tasks,
        ));
    }

    /**
     * Creates a new task entity.
     *
     * @Route("/new", name="task_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $task = new Task();
        $content=trim($request->get('task_content'));
        $date=date_create(date("Y/m/d"));
        $dl = trim($request->get('deadline'));
        $respo_id = trim($request->get('respo_id'));
        $responsible = $em->getRepository('IEEEUserBundle:User')->findOneById($respo_id);
        $task->setResponsible($responsible);
        $deadline = date_create($dl);
        $task->setContent($content);
        $task->setDate($date);
        $task->setDeadline($deadline);
        $task->setDone(false);
        $em->persist($task);
        $em->flush($task);
        $i=1;
        
        
            
        while($user = $request->get('user_no_'.$i))
        {
        $userTask = new UserTask();
        $userTask->setTask($task);
        $u=$em->getRepository('IEEEUserBundle:User')->findOneById($user);
        $userTask->setUser($u);
        $em->persist($userTask);
        $em->flush($userTask);
        $i++;
        }            
            return new Response("Ok");

           /* return $this->redirectToRoute('task_show', array('id' => $task->getId()));
        }

        return $this->render('task/new.html.twig', array(
            'task' => $task,
            'form' => $form->createView(),
        ));*/
    }

    /**
     * Finds and displays a task entity.
     *
     * @Route("/{id}", name="task_show")
     * @Method("GET")
     */
    public function showAction(task $task)
    {
        //$deleteForm = $this->createDeleteForm($task);

        return $this->render('task/show.html.twig', array(
            'task' => $task,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing task entity.
     *
     * @Route("/{id}/edit", name="task_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, task $task)
    {
        $deleteForm = $this->createDeleteForm($task);
        $editForm = $this->createForm('IEEE\UserBundle\Form\taskType', $task);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('task_edit', array('id' => $task->getId()));
        }

        return $this->render('task/edit.html.twig', array(
            'task' => $task,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    

    /**
     * Creates a form to delete a task entity.
     *
     * @param task $task The task entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(task $task)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('task_delete', array('id' => $task->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Displays a form to edit an existing task entity.
     *
     * @Route("/{id}/update", name="task_update")
     * @Method({"GET", "POST"})
     */
    public function taskUpdateAction(Request $request, task $task)
    {
        $em = $this->getDoctrine()->getManager();
        $update = new Feedback();
        if (!$request->get('update_content')) return new Response("update_content not found",404);
        $content = $request->get('update_content');
        $id=trim($request->get('user_id'));
        $date=date_create(date("Y/m/d"));
        $query = $em->createQuery("SELECT u FROM \IEEE\UserBundle\Entity\User u WHERE u.id = :id");
        $query->setParameter('id', $id);
        $user= $query->getOneOrNullResult();
        if(!$user) return new Response("user not found",404);
        $update->setUser($user);
        $update->setContent($content);
        $update->setDate($date);
        $update->setTask($task);
        $em->persist($update);
        $em->flush($update);
        $task->addUpdate($update);
        $em->persist($task);
        $em->flush($task);
        return new Response('Ok');
       
    }

    /**
     * Displays a form to edit an existing suggest entity.
     *
     * @Route("/{id}/updates", name="task_show_updates")
     * @Method({"GET", "POST"})
     */
    public function showUpdatesAction(Request $request, task $task)
    {
        $em = $this->getDoctrine()->getManager();
        $task = $em->getRepository('IEEEUserBundle:task')->find($task);
        $updates=$task->getupdates();
        foreach ($updates as $value) {
            $tab[$value->getId()]=[$value->getContent(),$value->getDate()->format('d-m-Y'),$value->getUser()->getUsername(),$value->getUser()->getId()];
        }
        return new JsonResponse($tab);

        }

    /**
     *
     *
     * @Route("/{id}/addUser/{Uid}", name="task_new_user")
     * @Method({"GET", "POST"})
     */
    public function addUserAction(Request $request , Task $task ,$Uid)   {
        $em = $this->getDoctrine()->getEntityManager();
        $query = $em->createQuery("SELECT u FROM \IEEE\UserBundle\Entity\User u WHERE u.id = :id");
        $query->setParameter('id', $Uid);
        $user= $query->getOneOrNullResult();
        if(!$user) return new Response("user not found",404);
        $this->denyAccessUnlessGranted('add', $task);
        $userTask = new UserTask();
        $userTask->setPost('member');
        $userTask->setTask($task);
        $userTask->setUser($user);
        $em->persist($userTask);
        $em->flush($userTask);

        return new Response('OK');



    } 
}
