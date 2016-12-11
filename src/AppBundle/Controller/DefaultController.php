<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use IEEE\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Response;  
use Symfony\Component\HttpFoundation\JsonResponse;  
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;



class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
             
        }

    /**
     * @Route("/auth", name="auth")
     */
    public function authAction(Request $request) 
    {
        $username = trim($request->get('username'));
    $password = trim($request->get('password'));
    $em = $this->get('doctrine')->getEntityManager();   
    $query = $em->createQuery("SELECT u FROM \IEEE\UserBundle\Entity\User u WHERE u.username = :username");
    $query->setParameter('username', $username);
    $user = $query->getOneOrNullResult();
    if(!$user) return new Response("invalid credentials",404);
    $isValid = $this->get('security.password_encoder')
            ->isPasswordValid($user, $password);
    if (!$isValid) {
     return new Response("invalid credentials",404);
        }        
    $token = $this->get('lexik_jwt_authentication.encoder')
            ->encode([
                'username' => $user->getUsername(),
                'exp' => time() + 4800 // 1 hour expiration
            ]);    

            
          
     return new JsonResponse(['token' => $token , "username"=>$user->getUsername() , 'id'=>$user->getId()]); 
    }    

}
