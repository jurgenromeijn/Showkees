<?php

namespace Mooi\WallBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Mooi\WallBundle\Entity\Post;
use Mooi\WallBundle\Entity\Reply;
use Mooi\WallBundle\Form\Type\WallPostType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class WallController extends Controller
{

    public function indexAction($id)
    {
        
        $user = $this->get('security.context')->getToken()->getUser();
        $wallOwner = $this->getDoctrine()
            ->getRepository('MooiUserBundle:User')
            ->find($id);
        
        return $this->render('MooiWallBundle:Wall:index.html.twig', array(
                'id'                => $id,
                'wallOwner'         => $wallOwner,
                'user'              => $user
        ));
   
    }
    
    public function addAction($id)
    {
        
        $request = $this->getRequest();
        $user = $this->get('security.context')->getToken()->getUser();
        $wallOwner = $this->getDoctrine()
            ->getRepository('MooiUserBundle:User')
            ->find($id);
        
        
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
                
                $this->get("session")->setFlash('notice', 'De post is toegevoegd.');
                
                return $this->redirect($this->generateUrl('MooiWallBundle_WallIndex', array(
                    'id'  => $id
                )));

            }

        }
        
        return $this->render('MooiWallBundle:Wall:add.html.twig', array(
                    'form'              => $form->createView(),
                    'id'                => $id,
                    'wallOwner'         => $wallOwner
        ));
        
    }
    
    public function editAction($postId)
    {
        
        $request = $this->getRequest();
        $post = $this->getDoctrine()
            ->getRepository('MooiWallBundle:Post')
            ->find($postId);
        
        $wallOwnerId = $post->getWallOwner()->getId();
        
        if($post == null)
        {
            
            throw $this->createNotFoundException("De post kon niet gevonden worden");
            
        }
        else
        {
            
            $form = $this->createForm(new WallPostType(), $post);
        
            if ($request->getMethod() == 'POST') 
            {

                $form->bindRequest($request);   

                if ($form->isValid()) 
                {

                    //set post data
                    $post->setTime(new \DateTime);

                    // Save the Post to the database
                    $em = $this->getDoctrine()->getEntityManager();
                    $em->persist($post);
                    $em->flush();

                    $this->get("session")->setFlash('notice', 'De post is gewijzigd.');

                    return $this->redirect($this->generateUrl('MooiWallBundle_WallIndex', array(
                        'id'  => $wallOwnerId
                    )));

                }

            }
            else
            {
                
                return $this->render('MooiWallBundle:Wall:edit.html.twig', array(
                    'form'              => $form->createView(),
                    'post'            => $post
                ));
                
            }
            
            
        }
        
    }
    
    public function deleteAction($postId)
    {
        
        $post = $this->getDoctrine()
            ->getRepository('MooiWallBundle:Post')
            ->find($postId);
        
        $user = $this->get('security.context')->getToken()->getUser();
        $wallOwnerId = $post->getWallOwner()->getId();
        
        if($post != null)
        {
            
            $entityManager = $this->getDoctrine()->getEntityManager();
            $entityManager->remove($post);
            $entityManager->flush();

            $this->get("session")->setFlash('notice', 'De post is verwijderd.');
            
            return $this->redirect($this->generateUrl('MooiWallBundle_WallIndex', array(
                'id'  => $wallOwnerId
            )));
            
        }
        else
        {
            
            return $this->redirect($this->generateUrl('MooiWallBundle_WallIndex', array(
                'id'  => $user->getId()
            )));
            
        }
         
    }
    

}
