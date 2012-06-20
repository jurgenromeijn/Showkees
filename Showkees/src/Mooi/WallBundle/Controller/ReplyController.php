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
use Mooi\WallBundle\Entity\Notification;
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
        
        if($post == null)
        {
            
            throw $this->createNotFoundException('Deze post kon niet worden gevonden');
        
        }
        
        //set new post object and create form
        $newReply = new Post();
        $newReply->setSubject($post->getSubject());
        $formReply = $this->createForm(new WallReplyType(), $newReply);
        
        if ($request->getMethod() == 'POST') 
        {

            $formReply->bindRequest($request);   

            if ($formReply->isValid())
            {
                
                $entityManager = $this->getDoctrine()->getEntityManager();
                //create notifications
                if($wallOwner->getId() == $user->getId())
                {
                    //Notifications for teachers
                    foreach ($wallOwner->getTeachers() as $teacher) 
                    {
                        
                        $teacherNotification = new Notification();
                        $teacherNotification->setMessage(($user->getGender() == User::GENDER_MALE) ? 
                                Notification::MESSAGE_WALL_OWN_MALE : 
                                Notification::MESSAGE_WALL_OWN_FEMALE);
                        $teacherNotification->setQuote($newReply);
                        $teacherNotification->setPost($newReply);
                        $teacherNotification->setOwner($teacher);
                        $teacherNotification->setAbout($wallOwner);
                        
                        $entityManager->persist($teacherNotification);
                    
                    }
                }
                else
                {
                    
                    //Notification for student
                    $studentNotification = new Notification();
                    $studentNotification->setMessage(Notification::MESSAGE_WALL_OTHER);
                    $studentNotification->setQuote($newReply);
                    $studentNotification->setPost($newReply);
                    $studentNotification->setOwner($wallOwner);
                    $studentNotification->setAbout($user);
                    
                    $entityManager->persist($studentNotification);
                    
                }
                
                //set post data
                $newReply->setSender($user);
                $newReply->setWallOwner($wallOwner);
                $post->addReply($newReply);

                // Save the Post to the database
                $entityManager = $this->getDoctrine()->getEntityManager();
                $entityManager->persist($post);
                $entityManager->flush();
                
                $this->get("session")->setFlash('notice', 'Je comment is toegevoegd.');
                
                return $this->redirect($this->generateUrl('MooiWallBundle_WallIndex', array(
                    'name'  => $wallOwner->getUsername()
                )));

             }

        }
        
        foreach($wallOwner->getWallOwnerPosts() as $post)
        {
            if($postId == $post->getId())
            {
                
                $replyForm['form']      = $formReply;
                $replyForm['show']      = true;
                
            }
            else
            {
                
                $replyForm['form']      = $this->createForm(new WallReplyType(), $newReply);
                $replyForm['show']      = false;
                
            }
            
            $replyForm['action']    = $this->get('router')->generate('MooiWallBundle_WallReplyAdd', array('postId' => $post->getId()));
            $replyForm['form']      = $replyForm['form']->createView();
            $post->setReplyForm($replyForm);

        }
        
        //set new post object and create form
        $newPost = new Post();
        $formPost = $this->createForm(new WallPostType(), $newPost);
        

        return $this->render('MooiWallBundle:Wall:index.html.twig', array(
                'formPostTitle'     => 'Voeg een post toe',
                'formPostAction'    => $this->get('router')->generate('MooiWallBundle_WallAdd', array('name' => $wallOwner->getUsername())),      
                'formPost'          => $formPost->createView(),
                'wallOwner'         => $wallOwner,
                'showForm'          => false
        ));
        
    }
    
    public function editAction($replyId)
    {
        
        $request = $this->getRequest();
        $user = $this->get('security.context')->getToken()->getUser();
        
        $reply = $this->getDoctrine()
            ->getRepository('MooiWallBundle:Post')
            ->find($replyId);
        $wallOwner = $reply->getWallOwner();
        
        
        //edit reply
        $formReply = $this->createForm(new WallReplyType(), $reply);
        
        if ($request->getMethod() == 'POST') 
        {

            $formReply->bindRequest($request);   

            if ($formReply->isValid())
            {
                //set post data
                $newReply->setTime(new \DateTime);

                // Save the Post to the database
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($post);
                $em->flush();
                
                $this->get("session")->setFlash('notice', 'Je comment is gewijzigd.');
                
                return $this->redirect($this->generateUrl('MooiWallBundle_WallIndex', array(
                    'id'  => $wallOwner->getId()
                )));

             }

        }
        
        foreach($wallOwner->getWallOwnerPosts() as $post)
        {
            if($replyId == $reply->getId())
            {
                
                $replyForm['form']      = $formReply;
                $replyForm['show']      = true;
                
            }
            else
            {
                
                $replyForm['form']      = $this->createForm(new WallReplyType(), $newReply);
                $replyForm['show']      = false;
                
            }
            
            $replyForm['action']    = $this->get('router')->generate('MooiWallBundle_WallReplyAdd', array('postId' => $post->getId()));
            $replyForm['form']      = $replyForm['form']->createView();
            $post->setReplyForm($replyForm);

        }
        
        //set new post object and create form
        $newPost = new Post();
        $formPost = $this->createForm(new WallPostType(), $newPost);
        

        return $this->render('MooiWallBundle:Wall:index.html.twig', array(
                'formPostTitle'     => 'Voeg een post toe',
                'formPostAction'    => $this->get('router')->generate('MooiWallBundle_WallAdd', array('id' => $wallOwner->getId())),      
                'formPost'          => $formPost->createView(),
                'id'                => $wallOwner->getId(),
                'wallOwner'         => $wallOwner,
                'user'              => $user,
                'showForm'          => false
        ));
        
        
    }
    
    public function deleteAction($replyId)
    {
        
       $reply = $this->getDoctrine()
            ->getRepository('MooiWallBundle:Post')
            ->find($replyId);
        
        $user = $this->get('security.context')->getToken()->getUser();
        $wallOwnerId = $reply->getWallOwner()->getId();
        
        if($reply != null)
        {
            
            $entityManager = $this->getDoctrine()->getEntityManager();
            $entityManager->remove($reply);
            $entityManager->flush();

            $this->get("session")->setFlash('notice', 'Het comment is verwijderd.');
            
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
    
    public function likeAction($replyId)
    {
        
        $user = $this->get('security.context')->getToken()->getUser();
        
        $reply = $this->getDoctrine()
            ->getRepository('MooiWallBundle:Post')
            ->find($replyId);
        
        $entityManager = $this->getDoctrine()->getEntityManager();

        //only add a notification if somone else's post is liked
        if($user->getId() != $reply->getSender()->getId())
        {
        
            $notification = new Notification();
            $notification->setMessage(Notification::MESSAGE_LIKE);
            $notification->setQuote($reply);
            $notification->setPost($reply);
            $notification->setOwner($reply->getSender());
            $notification->setAbout($user);
            $entityManager->persist($notification);
        
        }
                
        $amountLikes = $reply->getLikes();
        $amountLikes++;
        $reply->setLikes($amountLikes);
        
        $entityManager->persist($reply);
        $entityManager->flush();
        
        $responseJson = array(
            'succes' => true
        );
        
        return new Response(json_encode($responseJson));
        
    }
            
    
}

?>
