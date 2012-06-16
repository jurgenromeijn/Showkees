<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ReplyController
 *
 * @author henk
 */
namespace Mooi\WallBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Mooi\WallBundle\Entity\Post;
use Mooi\WallBundle\Form\Type\WallPostType;
use Mooi\WallBundle\Form\Type\WallReplyType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ReplyController extends Controller
{
    
    public function addAction($postId)
    {
         
        $request = $this->getRequest();
        $user = $this->get('security.context')->getToken()->getUser();
        
        $post = $this->getDoctrine()
            ->getRepository('MooiWallBundle:Post')
            ->find($postId);
        $wallOwner = $post->getWallOwner();
        
        
        //set new post object and create form
        $newReply = new Post();
        $form = $this->createForm(new WallPostType(), $newReply);
        
        if ($request->getMethod() == 'POST') 
        {

            $form->bindRequest($request);   
            
            if ($form->isValid()) 
            {
                
                return new Response('dasdas');
                
                //set post data
                /*$newReply->setTime(new \DateTime);
                $newReply->setSender($user);
                $newReply->setWallOwner($wallOwner);
                $post->addReply($newReply);

                // Save the Post to the database
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($post);
                $em->flush();
                
                $this->get("session")->setFlash('notice', 'Je comment is toegevoegd.');
                
                return $this->redirect($this->generateUrl('MooiWallBundle_WallIndex', array(
                    'id'  => $wallOwner->getId()
                )));*/

            }

        }
        //set new post object and create form
        $newPost = new Post();
        $postForm = $this->createForm(new WallPostType(), $newPost);

        foreach($wallOwner->getWallOwnerPosts() as $post)
        {

            $replyForm['form'] = $this->createForm(new WallReplyType(), $newReply);
            $replyForm['form'] = $replyForm['form']->createView();
            $replyForm['action'] = $this->get('router')->generate('MooiWallBundle_WallReplyAdd', array('postId' => $post->getId()));
            $replyForm['show'] = false;
            $post->setReplyForm($replyForm);

        }


        return $this->render('MooiWallBundle:Wall:index.html.twig', array(
                'formPostTitle'     => 'Voeg een post toe',
                'formPostAction'    => $this->get('router')->generate('MooiWallBundle_WallAdd', array('id' => $wallOwner->getId())),      
                'formPost'          => $postForm->createView(),
                'id'                => $wallOwner->getId(),
                'wallOwner'         => $wallOwner,
                'user'              => $user,
                'showForm'          => false
        ));
        
        
         
    }
    
}

?>
