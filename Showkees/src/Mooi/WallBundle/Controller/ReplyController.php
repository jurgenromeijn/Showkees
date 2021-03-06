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
use Mooi\UserBundle\Entity\User;
use Mooi\WallBundle\Entity\Notification;
use Mooi\WallBundle\Form\Type\WallPostType;
use Mooi\WallBundle\Form\Type\WallReplyType;
use Mooi\WallBundle\Form\Type\WallFilterType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ReplyController extends Controller
{
    
    public function addAction($postId)
    {
         
        $request = $this->getRequest();
        $user = $this->get('security.context')->getToken()->getUser();
        
        if(!$user->hasWallPermisions($user->getUsername()))
        {
            
            throw $this->createNotFoundException('Je hebt niet genoeg rechten om deze wall te bezoeken.');
            
        }
        
        $post = $this->getDoctrine()
            ->getRepository('MooiWallBundle:Post')
            ->find($postId);
        $wallOwner = $post->getWallOwner();
        $wallOwnerPosts = $this->getDoctrine()
                ->getRepository('MooiWallBundle:Post')
                ->findMainPostsByUser($wallOwner->getUserName());
        
        if($post == null)
        {
            
            throw $this->createNotFoundException('Dit bericht kon niet worden gevonden.');
        
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
                $newReply->setType('reply');
                $post->addReply($newReply);

                // Save the Post to the database
                $entityManager = $this->getDoctrine()->getEntityManager();
                $entityManager->persist($post);
                $entityManager->flush();
                
                $this->get("session")->setFlash('notice', 'Je reactie is toegevoegd.');
                
                return $this->redirect($this->generateUrl('MooiWallBundle_WallIndex', array(
                    'name'  => $wallOwner->getUsername()
                )) . '#reply' . $newReply->getId() );

             }

        }
   
        foreach($wallOwnerPosts as $singlePost)
        {
            if($postId == $singlePost->getId())
            {
                
                $replyForm['form']      = $formReply;
                $replyForm['show']      = 1;
                
            }
            else
            {
                
                $replyForm['form']      = $this->createForm(new WallReplyType(), $newReply);
                $replyForm['show']      = 0;
                
            }
            
            $replyForm['action']    = $this->get('router')->generate('MooiWallBundle_WallReplyAdd', array('name' => $singlePost->getUserName()));
            $replyForm['form']      = $replyForm['form']->createView();
            $singlePost->setReplyForm($replyForm);
            
        }
        
        //set new post object and create form
        $newPost = new Post();
        $formPost = $this->createForm(new WallPostType(), $newPost);
        
        $yearsOfPosts   = array();
        $subjectsPosts  = array();
        
        $years = $this->getDoctrine()
                ->getRepository('MooiWallBundle:Post')
                ->getYearsOfPosts($user->getUserName());
        
        $subjects = $this->getDoctrine()
                ->getRepository('MooiWallBundle:Subject')
                ->getAllSubjectsByName();
        
        foreach($years as $year => $value)
        {
            
            $yearsOfPosts[$value[1]] = $value[1];
            
        }

        foreach($subjects as $subject => $value)
        {
            
            $id = (int)$value['id'];
            $subjectsPosts[$id] = $value['name'];
            
        }
        
        //filter form
        $filterForm = $this->createForm(new WallFilterType($subjectsPosts, $yearsOfPosts));
        $filterForm = $filterForm->createView();
        

        return $this->render('MooiWallBundle:Wall:index.html.twig', array(
                'formPostTitle'     => 'Voeg een bericht toe',
                'formPostAction'    => $this->get('router')->generate('MooiWallBundle_WallAdd', array('name' => $wallOwner->getUsername())),      
                'formPost'          => $formPost->createView(),
                'wallOwner'         => $wallOwner,
                'filterForm'        => $filterForm,
                'wallOwnerPosts'    => $wallOwnerPosts,
                'showForm'          => false
        ));
        
    }
    
    public function editAction($replyId)
    {
        
        $request = $this->getRequest();
        $user = $this->get('security.context')->getToken()->getUser();
        
        if(!$user->hasWallPermisions($user->getUsername()))
        {
            
            throw $this->createNotFoundException('Je hebt niet genoeg rechten om deze wall te bezoeken.');
            
        }
        
        $reply = $this->getDoctrine()
            ->getRepository('MooiWallBundle:Post')
            ->find($replyId);
        $wallOwner = $reply->getWallOwner();
        $wallOwnerPosts = $this->getDoctrine()
                ->getRepository('MooiWallBundle:Post')
                ->findMainPostsByUser($wallOwner->getUserName());
        
        //edit reply
        $formReply = $this->createForm(new WallReplyType(), $reply);
        
        if ($request->getMethod() == 'POST') 
        {

            $formReply->bindRequest($request);   

            if ($formReply->isValid())
            {

                // Save the Post to the database
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($reply);
                $em->flush();
                
                $this->get("session")->setFlash('notice', 'Je reactie is gewijzigd.');
                
                return $this->redirect($this->generateUrl('MooiWallBundle_WallIndex', array(
                    'name'  => $wallOwner->getUserName()
                )) . '#reply' . $reply->getId() );

             }

        }
        
        foreach($wallOwner->getWallOwnerPosts() as $singePost)
        {
            if($replyId == $singePost->getId())
            {

                $replyForm['form']      = $this->createForm(new WallReplyType(), $reply);
                $replyForm['show']      = true;
  
            }
            else
            {

                $replyForm['form']      = $this->createForm(new WallReplyType(), new Post());
                $replyForm['show']      = false;
                
            }
            
            
            $replyForm['form']          = $replyForm['form']->createView();
            $replyForm['action']        = $this->get('router')->generate('MooiWallBundle_WallReplyAdd', array('postId' => $singePost->getId()));
            $singePost->setReplyForm($replyForm);
            
        }
        
        //set new post object and create form
        $newPost = new Post();
        $formPost = $this->createForm(new WallPostType(), $newPost);

        $yearsOfPosts   = array();
        $subjectsPosts  = array();
        
        $years = $this->getDoctrine()
                ->getRepository('MooiWallBundle:Post')
                ->getYearsOfPosts($user->getUserName());
        
        $subjects = $this->getDoctrine()
                ->getRepository('MooiWallBundle:Subject')
                ->getAllSubjectsByName();
        
        foreach($years as $year => $value)
        {
            
            $yearsOfPosts[$value[1]] = $value[1];
            
        }

        foreach($subjects as $subject => $value)
        {
            
            $id = (int)$value['id'];
            $subjectsPosts[$id] = $value['name'];
            
        }
        
        //filter form
        $filterForm = $this->createForm(new WallFilterType($subjectsPosts, $yearsOfPosts));
        $filterForm = $filterForm->createView();
        
        return $this->render('MooiWallBundle:Wall:index.html.twig', array(
                'formPostTitle'     => 'Voeg een bericht toe',
                'formPostAction'    => $this->get('router')->generate('MooiWallBundle_WallAdd', array('name' => $wallOwner->getUserName())),      
                'formPost'          => $formPost->createView(),
                'id'                => $wallOwner->getId(),
                'wallOwner'         => $wallOwner,
                'wallOwnerPosts'    => $wallOwnerPosts,
                'user'              => $user,
                'filterForm'        => $filterForm,
                'editReplyForm'     => true,
                'showForm'          => false
        ));
        
        
    }
    
    public function deleteAction($replyId)
    {
        
        $user = $this->get('security.context')->getToken()->getUser();
        
        if(!$user->hasWallPermisions($user->getUsername()))
        {
            
            throw $this->createNotFoundException('Je hebt niet genoeg rechten om deze wall te bezoeken.');
            
        }
        
        $reply = $this->getDoctrine()
            ->getRepository('MooiWallBundle:Post')
            ->find($replyId);
        
        $wallOwnerUserName = $reply->getWallOwner()->getUserName();
        
        if($reply != null)
        {
            
            $entityManager = $this->getDoctrine()->getEntityManager();
            $entityManager->remove($reply);
            $entityManager->flush();

            $this->get("session")->setFlash('notice', 'De reactie is verwijderd.');
            
            return $this->redirect($this->generateUrl('MooiWallBundle_WallIndex', array(
                'name'  => $wallOwnerUserName,
            )));
            
        }
        else
        {
            
            return $this->redirect($this->generateUrl('MooiWallBundle_WallIndex', array(
                'name'  => $wallOwnerUserName,
            )));
            
        } 
        
    }
    
    public function likeAction($replyId)
    {
        
        $user = $this->get('security.context')->getToken()->getUser();
        
        if(!$user->hasWallPermisions($user->getUsername()))
        {
            
            throw $this->createNotFoundException('Je hebt niet genoeg rechten om deze wall te bezoeken.');
            
        }
        
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
