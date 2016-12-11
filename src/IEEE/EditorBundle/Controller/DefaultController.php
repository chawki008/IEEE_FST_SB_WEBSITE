<?php

namespace IEEE\EditorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


/**
 * Editor controller.
 *
 * @Route("editor" , name="editor_index")
 */
class DefaultController extends Controller
{
	/**
     * @Route("/", name="editor_index")
     * @Method("GET")
     */
    public function indexAction()

    {
    	//$user=$this->get('security.token_storage')->getToken()->getUser();
        return $this->render('IEEEEditorBundle:Default:index.html.twig');
    }
}
