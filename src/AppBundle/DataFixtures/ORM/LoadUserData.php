<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use IEEE\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use IEEE\UserBundle\Entity\image;
use IEEE\UserBundle\Entity\task;
use IEEE\UserBundle\Entity\feedback;

class LoadUserData extends Controller implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {   $user = new User();
    	$image = new Image();
    	$user->setUsername('chawki_008'); 
        $user->setRoles(['ROLE_ADMIN']);
    	$image->setUrl('uploads/img/'.$user->getUsername().'.jpg');
    	$image->setAlt($user->getUsername());
    	$user->setImage($image);
   		$user->setApiKey('00000000');
		$user->setSalt(base64_encode(random_bytes(10)));
		$encoder = $this->container->get('security.password_encoder');
		$encoded = $encoder->encodePassword($user, '00000000');
		$user->setPassword($encoded);
        $manager->persist($user);
        $manager->flush();
        $user1 = new User();
    	$image1 = new Image();
    	$user1->setUsername('hzitoun'); 
    	$image1->setUrl('uploads/img/'.$user1->getUsername().'.jpg');
    	$image1->setAlt($user1->getUsername());
    	
    	$user1->setImage($image1);
   		$user1->setApiKey('0000hghg00000000');
		$user1->setSalt(base64_encode(random_bytes(10)));
		$encoded = $encoder->encodePassword($user1, '00000000');
		$user1->setPassword($encoded);
        $manager->persist($user1);
        $user2 = new User();
        $image2 = new Image();
        $user2->setUsername('yesmineBl'); 
        $image2->setUrl('uploads/img/'.$user2->getUsername().'.jpg');
        $image2->setAlt($user2->getUsername());
        $user2->setImage($image2);
        $user2->setApiKey('0000001321600');
        $user2->setRoles(['ROLE_EDITOR']);
        $user2->setSalt(base64_encode(random_bytes(10)));
        $encoded = $encoder->encodePassword($user2, '00000000');
        $user2->setPassword($encoded);
        $manager->persist($user2);
        $manager->flush();
        
    }
}