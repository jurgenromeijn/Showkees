<?php

namespace Mooi\WallBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Mooi\WallBundle\Entity\Post;
use Mooi\WallBundle\Form\Type\WallPostType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WallController extends Controller
{

    public function indexAction()
    {
        
        $request = $this->getRequest();
        $user = $this->get('security.context')->getToken()->getUser();
        
        $newPost = new Post();
        $form = $this->createForm(new WallPostType(), $newPost);
        
        if ($request->getMethod() == 'POST') 
        {
            
            $form->bindRequest($request);
            
            
            //$post->setWallOwner($userDieDeWallHeeftWaarJeOpZit);         

            if ($form->isValid()) 
            {
                
                //set post data
                $newPost->setTime(new \DateTime);
                $newPost->setSender($user);

                // Save the Post to the database
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($newPost);
                $em->flush();
                
            }
            
        }
        
        $wallOwner = $this->getDoctrine()
        ->getRepository('MooiUserBundle:User')
        ->find(2);/*->findAllById(1); id $_GET*/
        
        $wallOwnerPosts = $wallOwner->getWallOwnerPosts();
        

        return $this->render('MooiWallBundle:Wall:index.html.twig', array(
                'form'              => $form->createView(),
                'wallOwnerPosts'    => $wallOwnerPosts         
                
        ));
        //$wallOwner
        
        
        //show products
        /*$posts = $this->getDoctrine()
        ->getRepository('AcmeWallBundle:Post')
        ->findAllById(1);*///id $_GET
        //'posts' => $post
        
        
    }
    

}
