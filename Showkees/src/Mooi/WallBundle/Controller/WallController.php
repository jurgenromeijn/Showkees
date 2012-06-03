<?php

namespace Mooi\WallBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Mooi\WallBundle\Entity\Post;
use Mooi\WallBundle\Form\Type\WallPostType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WallController extends Controller
{

    public function indexAction($id)
    {
        
        $request = $this->getRequest();
        $user = $this->get('security.context')->getToken()->getUser();
        $wallOwner = $this->getDoctrine()
            ->getRepository('MooiUserBundle:User')
            ->find($id);
        $roleId = $user->getRole()->getId();
        
        //checks if the logged user is a teacher or the wallowner
        if($roleId == 2 || $wallOwner->getId() == $user->getId())
        {
            
            //set new post object and create form
            $newPost = new Post();
            $form = $this->createForm(new WallPostType(), $newPost);
            
            if ($request->getMethod() == 'POST') 
            {

                $form->bindRequest($request);   

                if ($form->isValid()) 
                {

                    //set post data
                    $newPost->setTime(new \DateTime);
                    $newPost->setSender($user);
                    $newPost->setWallOwner($wallOwner);
                    
                    // Save the Post to the database
                    $em = $this->getDoctrine()->getEntityManager();
                    $em->persist($newPost);
                    $em->flush();
                    return $this->redirect($this->generateUrl('MooiWallBundle_WallIndex', array(
                        'id'  => $id
                    )));

                }

            }
            
            return $this->render('MooiWallBundle:Wall:index.html.twig', array(
                    'form'              => $form->createView(),
                    'id'                => $id,
                    'wallOwner'         => $wallOwner
            ));

        }
        else
        {
            
            return new Response('Nee nee daar dit mag jij niet zijn');
            
        }

        
    }
    

}
