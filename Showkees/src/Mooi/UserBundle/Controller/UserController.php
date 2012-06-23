<?php

namespace Mooi\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Mooi\UserBundle\Entity\User;
use Mooi\UserBundle\Form\Type\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Mooi\UserBundle\Model\UserFactory;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Mooi\WallBundle\Form\Type\ImageType;

/**
 * Description of UserController
 *
 * @author Jurgen
 */
class UserController extends Controller 
{

    public function loginAction() 
    {
        $request = $this->getRequest();
        $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) 
        {
        
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
            
        }
        else 
        {
            
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
            
        }        
                
	return $this->render("MooiUserBundle:User:login.html.twig", array(
            // last username entered by the user
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
        ));
        
    }

    public function createAction(Request $request)
    {
        
        $securityUser = $this->get('security.context')->getToken()->getUser();
       
        $roleRepository = $this->getDoctrine()->getRepository('MooiUserBundle:Role');
        
        // Create a user and set up the form
        $user = new User();
        $user->setRole($roleRepository->find(4));
        $form = $this->createForm(new UserType($securityUser), $user, array(
            "validation_groups" => array("Default", "registration")
        ));
                
        if ($request->getMethod() == 'POST') 
        {
            
            $form->bindRequest($request);
            
            if ($form->isValid())
            {
                
                if($user->getRole()->getId() < $securityUser->getRole()->getId())
                {
                    
                    throw new AccessDeniedException("Je mag geen rang hoger dan je eigen instellen");
                    
                }

                // Get User factory and let it encode the password
                $userFactory = new UserFactory($this->get('security.encoder_factory'));
                $user->setPassword($userFactory->encode($user));
                
                // Save the User to the database
                $entityManager = $this->getDoctrine()->getEntityManager();
                $entityManager->persist($user);
                $entityManager->flush();
                
                // Set flash message and redirect to another page
                $this->get("session")->setFlash('notice', 'Het account is toegevoegd.');
                return $this->redirect($this->generateUrl('index'));
                
            }
            
        }

        // Show the form
        return $this->render("MooiUserBundle:User:create.html.twig", array(
            'form' => $form->createView()
        ));
        
    }
    
    public function editAction(Request $request, $username)
    {
        
        $user;
        $securityUser = $this->get('security.context')->getToken()->getUser();
        $ownAccount = false;
                
        if($username == null)
        {
    
            $user = $securityUser;
            
        }
        else
        {

            $userRepository = $this->getDoctrine()
                ->getRepository('MooiUserBundle:User');

            $user = $userRepository->findOneByUsername($username);
            
        }
        
        $currentAvatar = $user->getAvatar()->getWebPath();
        
        if($user == null)
        {
            
            throw $this->createNotFoundException('Deze gebruiker kon niet worden gevonden');
        
        }
        elseif($securityUser->getUsername() == $user->getUsername())
        {
            
            $ownAccount = true;
            
        }
                
        $form = $this->createForm(new UserType($securityUser, !$ownAccount, false, false, true), $user, array(
            "validation_groups" => array("Default", "update")
        ));
        
        $originalPassword = $user->getPassword();
        $newPassword = "";
        
        if ($request->getMethod() == 'POST') 
        {
            
            $form->bindRequest($request);
            
            if ($form->isValid()) 
            {

                // Save the User to the database
                $entityManager = $this->getDoctrine()->getEntityManager();
                
                if($user->getRole()->getId() < $securityUser->getRole()->getId())
                {
                    
                    throw new AccessDeniedException("Je mag geen rang hoger dan je eigen instellen");
                    
                }
                elseif($securityUser->getRole()->getId() == 4)
                {
                    
                    // if a user gets set to student, make sure he has no studnets under him
                    $user->getStudents()->clear();
                    
                }
                
                $newPassword = $user->getPassword();
                                
                if(!empty($newPassword))
                {
                             
                    $userFactory = new UserFactory($this->get('security.encoder_factory'));
                    $user->setPassword($userFactory->encode($user));
                    
                }
                else 
                {
                    
                    $user->setPassword($originalPassword);
                    
                }
                                
                if($user->getAvatar()->getId() == null && !$user->getAvatar()->isFileSet())
                {
                    
                    $user->setAvatar(null);
                    
                }
                else
                {
                    
                    $entityManager->persist($user->getAvatar());
                    
                }
                                                
                $entityManager->persist($user);
                $entityManager->flush();
                
                // Set flash message and redirect to another page
                $this->get("session")->setFlash('notice', 'De instellingen zijn aangepast.');
                return $this->redirect($this->generateUrl('index'));
                
            }
            
        }
        
        return $this->render("MooiUserBundle:User:edit.html.twig", array(
            'form'          => $form->createView(),
            'user'          => $user,
            'currentAvatar' => $currentAvatar
        ));
        
    }
    
    public function changeStyleAction(Request $request)
    {
        
        $style = $request->get("style");
        
        $user = $this->get('security.context')->getToken()->getUser();
        $user->setStyle($style);
        
        $succes = false;
        
        try
        {
        
            $entityManager = $this->getDoctrine()->getEntityManager();
            $entityManager->persist($user);
            $entityManager->flush();
            
            $succes = true;
        
        }
        catch(\Exception $exception)
        {
            // Don't really care if things go wrong, so do nothing
        }
        
        return new Response(json_encode(array('succes' => $succes)));
        
    }

}

?>
