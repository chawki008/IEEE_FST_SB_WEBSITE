<?php

namespace IEEE\UserBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends Controller
{	
    public function indexAction(Request $request)
    {
    	$this->get('security.token_storage')->setToken(null);
        $request->getSession()->invalidate();
        return new Response(var_dump($request->getSession()->all()));
    }
}
