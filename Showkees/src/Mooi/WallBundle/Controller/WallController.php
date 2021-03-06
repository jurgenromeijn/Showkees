<?php

namespace Mooi\WallBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Mooi\WallBundle\Entity\Post;
use Mooi\UserBundle\Entity\User;
use Mooi\WallBundle\Entity\Image;
use Mooi\WallBundle\Entity\Filter;
use Mooi\WallBundle\Entity\Notification;
use Mooi\WallBundle\Form\Type\WallPostType;
use Mooi\WallBundle\Form\Type\WallReplyType;
use Mooi\WallBundle\Form\Type\WallFilterType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class WallController extends Controller
{

    public function indexAction($name)
    {
        
        $user = $this->get('security.context')->getToken()->getUser();
        
        if($name == null)
        {
            $wallOwner = $user;
            $wallOwnerPosts = $this->getDoctrine()
                ->getRepository('MooiWallBundle:Post')
                ->findMainPostsByUser($wallOwner->getUserName());
            
        }
        else if(!$user->hasWallPermisions($name))
        {
            
            throw $this->createNotFoundException('Je hebt niet genoeg rechten om deze Showkees te bezoeken.');
            
        }
        else
        {
            
            $wallOwner = $this->getDoctrine()
                ->getRepository('MooiUserBundle:User')
                ->findOneByUsername($name);
            $wallOwnerPosts = $this->getDoctrine()
                ->getRepository('MooiWallBundle:Post')
                ->findMainPostsByUser($name);
            
        }
        if($wallOwner == null)
        {
            
            throw $this->createNotFoundException('Deze gebruiker kon niet worden gevonden.');
        
        }
        //set new post object and create form
        $newPost = new Post();
        $postForm = $this->createForm(new WallPostType(), $newPost);
                
        foreach($wallOwnerPosts as $singlePost)
        {
            
            $replyForm['form'] = $this->createForm(new WallReplyType(), new Post());
            $replyForm['form'] = $replyForm['form']->createView();
            $replyForm['show'] = false;
            $singlePost->setReplyForm($replyForm);
            
        }
        
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
                'formPost'          => $postForm->createView(),
                'wallOwner'         => $wallOwner,
                'wallOwnerPosts'    => $wallOwnerPosts,
                'filterForm'        => $filterForm,
                'showForm'          => false
        ));
   
    }
    
    public function addAction($name)
    {
        
        $request = $this->getRequest();
        $user = $this->get('security.context')->getToken()->getUser();
       
        if(!$user->hasWallPermisions($name))
        {
            
            throw $this->createNotFoundException('Je hebt niet genoeg rechten om deze pagina te bezoeken.');
            
        }
        
        $wallOwner = $this->getDoctrine()
            ->getRepository('MooiUserBundle:User')
            ->findOneByUsername($name);   
        $wallOwnerPosts = $this->getDoctrine()
            ->getRepository('MooiWallBundle:Post')
            ->findMainPostsByUser($name);

        if($wallOwner == null)
        {
            
            throw $this->createNotFoundException('Deze gebruiker kon niet worden gevonden.');
        
        }
        
        //set new post object and create form
        $post = new Post();
        $postForm = $this->createForm(new WallPostType(), $post);
        $reply = new Post();

        if ($request->getMethod() == 'POST') 
        {

            $postForm->bindRequest($request);   

            if ($postForm->isValid()) 
            {

                $entityManager = $this->getDoctrine()->getEntityManager();
                
                //check files
                foreach ($post->getImages() as $image) 
                {
                    
                    if($image->getId() == null && !$image->isFileSet())
                    {
                        
                        $post->getImages()->removeElement($image);

                    }
                    else
                    {

                        $entityManager->persist($image);

                    }
                    
                }
                
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
                        $teacherNotification->setQuote($post);
                        $teacherNotification->setPost($post);
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
                    $studentNotification->setQuote($post);
                    $studentNotification->setPost($post);
                    $studentNotification->setOwner($wallOwner);
                    $studentNotification->setAbout($user);
                    
                    $entityManager->persist($studentNotification);
                    
                }
                
                //set post data
                $post->setSender($user);
                $post->setWallOwner($wallOwner);
                $post->setType('post');
                
                // Save the Post to the database
                $entityManager->persist($post);
                $entityManager->flush();
                
                $this->get("session")->setFlash('notice', 'Het bericht is toegevoegd.');
                
                return $this->redirect($this->generateUrl('MooiWallBundle_WallIndex', array(
                    'name'  => $wallOwner->getUsername()
                )) . '#post' . $post->getId() );

            }

        }
        
        foreach($wallOwnerPosts as $singlePost)
        {
            
            $replyForm['form']      = $this->createForm(new WallReplyType(), $reply);
            $replyForm['form']      = $replyForm['form']->createView();
            $replyForm['action']    = $this->get('router')->generate('MooiWallBundle_WallReplyAdd', array('postId' => $singlePost->getId()));
            $replyForm['show']      = false;
            $singlePost->setReplyForm($replyForm);
            
        }
        
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
                'formPost'          => $postForm->createView(),
                'wallOwner'         => $wallOwner,
                'wallOwnerPosts'    => $wallOwnerPosts,
                'filterForm'        => $filterForm,
                'showForm'          => true
        ));
        
    }
    
    public function editAction($postId)
    {

        $request = $this->getRequest();
        $user = $this->get('security.context')->getToken()->getUser();
        
        if(!$user->hasWallPermisions($user->getUsername()))
        {
            
            throw $this->createNotFoundException('Je hebt niet genoeg rechten om deze pagina te bezoeken.');
            
        }
        $post = $this->getDoctrine()
            ->getRepository('MooiWallBundle:Post')
            ->find($postId);
        
        $wallOwnerPosts = $post->getWallOwner()->getWallOwnerPosts();
        $wallOwnerPostsExReply = $this->getDoctrine()
                ->getRepository('MooiWallBundle:Post')
                ->findMainPostsByUser($post->getWallOwner()->getUserName());
        
        if($post == null)
        {
            
            throw $this->createNotFoundException("Het bericht kon niet gevonden worden.");
            
        }

        $form = $this->createForm(new WallPostType(), $post);
        
        if ($request->getMethod() == 'POST') 
        {

            $form->bindRequest($request);   

            if ($form->isValid()) 
            {
                
                $entityManager = $this->getDoctrine()->getEntityManager();
                
                //check files
                foreach ($post->getImages() as $image) 
                {
                    
                    if($image->getId() == null && !$image->isFileSet())
                    {
                        
                        $post->getImages()->removeElement($image);

                    }
                    else
                    {

                        $entityManager->persist($image);

                    }
                    
                }

                // Save the Post to the database
                $entityManager->persist($post);
                $entityManager->flush();

                $this->get("session")->setFlash('notice', 'Het bericht is gewijzigd.');

                return $this->redirect($this->generateUrl('MooiWallBundle_WallIndex', array(
                    'name'  => $post->getWallOwner()->getUsername())
                ) . '#post' . $post->getId() );

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
            'formPostTitle'     => 'Bericht wijzigen',
            'formPostAction'    => $this->get('router')->generate('MooiWallBundle_WallEdit', array('postId' => $postId)),      
            'formPost'          => $form->createView(),
            'wallOwner'         => $post->getWallOwner(),
            'wallOwnerPosts'    => $wallOwnerPostsExReply,
            'filterForm'        => $filterForm,
            'showForm'          => true
        ));
        
    }
    
    public function deleteAction($postId)
    {
        
        $user = $this->get('security.context')->getToken()->getUser();
        
        if(!$user->hasWallPermisions($user->getUserName()))
        {
            
            throw $this->createNotFoundException('Je hebt niet genoeg rechten om deze Showkees te bezoeken.');
            
        }
        
        $post = $this->getDoctrine()
            ->getRepository('MooiWallBundle:Post')
            ->find($postId);
        
        $userNameWallOwner = $post->getWallOwner()->getUserName();
        
        if($post == null)
        {
            
            throw $this->createNotFoundException('Het bericht kon niet worden gevonden.');
        
        }
            
        $entityManager = $this->getDoctrine()->getEntityManager();
        $entityManager->remove($post);
        $entityManager->flush();

        $this->get("session")->setFlash('notice', 'Het bericht is verwijderd.');

        return $this->redirect($this->generateUrl('MooiWallBundle_WallIndex', array(
            'name'  => $userNameWallOwner
        )));
            
    }
    
    public function likeAction($postId)
    {
        
        $user = $this->get('security.context')->getToken()->getUser();
        
        if(!$user->hasWallPermisions($user->getUserName()))
        {
            
            throw $this->createNotFoundException('Je hebt niet genoeg rechten om deze pagina te bezoeken.');
            
        }
        
        $post = $this->getDoctrine()
            ->getRepository('MooiWallBundle:Post')
            ->find($postId);
        
        $entityManager = $this->getDoctrine()->getEntityManager();

        //only add a notification if somone else's post is liked
        if($user->getId() != $post->getSender()->getId())
        {
        
            $notification = new Notification();
            $notification->setMessage(Notification::MESSAGE_LIKE);
            $notification->setQuote($post);
            $notification->setPost($post);
            $notification->setOwner($post->getSender());
            $notification->setAbout($user);
            $entityManager->persist($notification);
        
        }
                
        $amountLikes = $post->getLikes();
        $amountLikes++;
        $post->setLikes($amountLikes);
        
        $entityManager->persist($post);
        $entityManager->flush();
        
        $responseJson = array(
            'succes' => true
        );
        
        return new Response(json_encode($responseJson));
        
    }
    
    public function filterAction($name)
    {
        
        $request = $this->getRequest();
        $warningFilter = null;
        $user = $this->get('security.context')->getToken()->getUser();
        
        if($name == null)
        {
            $wallOwner = $user;
            $wallOwnerPosts = $this->getDoctrine()
                ->getRepository('MooiWallBundle:Post')
                ->findMainPostsByUser($wallOwner->getUserName());
            
        }

        if(!$user->hasWallPermisions($name))
        {
            
            throw $this->createNotFoundException('Je hebt niet genoeg rechten om deze Showkees te bezoeken.');
            
        }
        else
        {
            
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

                foreach($subjects as $singleSubject => $value)
                {

                    $id = (int)$value['id'];
                    $subjectsPosts[$id] = $value['name'];

                }
            
            $filterForm = $this->createForm(new WallFilterType($subjectsPosts, $yearsOfPosts));
            
            if(($request->getMethod() == 'POST'))
            {
                
                $filterForm->bindRequest($request);   
                
                $data = $request->request->all();

                $subject = $data['WallFilter']['subject'];
                $year = $data['WallFilter']['years'];
                
                $wallOwner = $this->getDoctrine()
                ->getRepository('MooiUserBundle:User')
                ->findOneByUsername($name);
                $wallOwnerPosts = $this->getDoctrine()
                    ->getRepository('MooiWallBundle:Subject')
                    ->filterByYearAndSubject($name, $subject, (int)$year);

                if($wallOwnerPosts)
                {
                    
                     $wallOwnerPosts = $wallOwnerPosts[0]->getPosts();
                    
                }
                else
                {
                    
                    $warningFilter = 'Er konden geen berichten gevonden worden die voldeden aan je zoekopdracht.';
                    
                }
                
            }
            else
            {
                
                throw $this->createNotFoundException('Er is geen filter ingesteld.');
                
            }

        }
        
        if($wallOwner == null)
        {
            
            throw $this->createNotFoundException('Deze gebruiker kon niet worden gevonden.');
        
        }
        //set new post object and create form
        $newPost = new Post();
        
        $postForm = $this->createForm(new WallPostType(), $newPost);
        
        foreach($wallOwnerPosts as $post)
        {
            
            $replyForm['form'] = $this->createForm(new WallReplyType(), new Post());
            $replyForm['form'] = $replyForm['form']->createView();
            $replyForm['action'] = $this->get('router')->generate('MooiWallBundle_WallReplyAdd', array('postId' => $post->getId()));
            $replyForm['show'] = false;
            $post->setReplyForm($replyForm);
            
        }
        
        return $this->render('MooiWallBundle:Wall:index.html.twig', array(
                'formPostTitle'     => 'Voeg een bericht toe',
                'formPostAction'    => $this->get('router')->generate('MooiWallBundle_WallAdd', array('name' => $wallOwner->getUserName())),     
                'formPost'          => $postForm->createView(),
                'wallOwner'         => $wallOwner,
                'wallOwnerPosts'    => $wallOwnerPosts,
                'filterForm'        => $filterForm->createView(),
                'showForm'          => false,
                'warningFilter'     => $warningFilter
        ));
        
    }

}
