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
        $post = new Post();
        $form = $this->createForm(new WallPostType(), $post);
        
        if ($request->getMethod() == 'POST') 
        {
            
            $form->bindRequest($request);
            $post->setTime(new \DateTime);
            
            if ($form->isValid()) 
            {
                // Save the Post to the database
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($post);
                $em->flush();
                
            }
            
        }
        
        return $this->render('MooiWallBundle:Wall:index.html.twig', array(
                'form' => $form->createView()
        ));
        
        
    }
    
     public function createAction(Request $request)
     {
         
         
         
     }
}
