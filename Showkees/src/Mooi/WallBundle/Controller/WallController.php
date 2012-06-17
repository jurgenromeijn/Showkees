<?php

namespace Mooi\WallBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Mooi\WallBundle\Entity\Post;
use Mooi\WallBundle\Form\Type\WallPostType;
use Mooi\WallBundle\Form\Type\WallReplyType;
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
        
        $wallOwnerPosts = $this->getDoctrine()
            ->getRepository('MooiWallBundle:Post')
            ->findMainPostsByUser($id);
        
        //set new post object and create form
        $newPost = new Post();
        $postForm = $this->createForm(new WallPostType(), $newPost);
        
        foreach($wallOwner->getWallOwnerPosts() as $post)
        {
            
            $replyForm['form'] = $this->createForm(new WallReplyType(), new Post());
            $replyForm['form'] = $replyForm['form']->createView();
            $replyForm['action'] = $this->get('router')->generate('MooiWallBundle_WallReplyAdd', array('postId' => $post->getId()));
            $replyForm['show'] = false;
            $post->setReplyForm($replyForm);
            
        }
        
        
        return $this->render('MooiWallBundle:Wall:index.html.twig', array(
                'formPostTitle'     => 'Voeg een post toe',
                'formPostAction'    => $this->get('router')->generate('MooiWallBundle_WallAdd', array('id' => $id)),      
                'formPost'          => $postForm->createView(),
                'id'                => $id,
                'wallOwner'         => $wallOwner,
                'user'              => $user,
                'showForm'          => false
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
        $postForm = $this->createForm(new WallPostType(), $newPost);
        $newReply = new Post();

        if ($request->getMethod() == 'POST') 
        {

            $postForm->bindRequest($request);   

            if ($postForm->isValid()) 
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
                'formPostAction'    => $this->get('router')->generate('MooiWallBundle_WallAdd', array('id' => $id)),      
                'formPost'          => $postForm->createView(),
                'id'                => $id,
                'wallOwner'         => $wallOwner,
                'user'              => $user,
                'showForm'          => true
        ));
        
    }
    
    public function editAction($postId)
    {

        $request = $this->getRequest();
        $user = $this->get('security.context')->getToken()->getUser();
        $post = $this->getDoctrine()
            ->getRepository('MooiWallBundle:Post')
            ->find($postId);
        
        $wallOwnerId = $post->getWallOwner()->getId();
        $wallOwnerPosts = $post->getWallOwner()->getWallOwnerPosts();
        
        if($post == null)
        {
            
            throw $this->createNotFoundException("De post kon niet gevonden worden");
            
        }

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
        
        $newReply = new Post();
        
        foreach($wallOwnerPosts as $post)
        {
            
            $replyForm['form'] = $this->createForm(new WallReplyType(), $newReply);
            $replyForm['form'] = $replyForm['form']->createView();
            $replyForm['action'] = $this->get('router')->generate('MooiWallBundle_WallReplyAdd', array('postId' => $post->getId()));
            $replyForm['show'] = false;
            $post->setReplyForm($replyForm);
            
        }
        
        return $this->render('MooiWallBundle:Wall:index.html.twig', array(
            'formPostTitle'     => 'Wijzig de post',
            'formPostAction'    => $this->get('router')->generate('MooiWallBundle_WallEdit', array('postId' => $postId)),      
            'formPost'          => $form->createView(),
            'id'                => $wallOwnerId,
            'wallOwner'         => $post->getWallOwner(),
            'user'              => $user,
            'showForm'          => true
        ));
        
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
    
    public function likeAction($postId)
    {
        
        $post = $this->getDoctrine()
            ->getRepository('MooiWallBundle:Post')
            ->find($postId);
        
        $amountLikes = $post->getLikes();
        $amountLikes++;
        $post->setLikes($amountLikes);
        
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($post);
        $em->flush();
        
        $responseJson = array(
            'succes' => true
        );
        
        return new Response(json_encode($responseJson));
        
    }

}
