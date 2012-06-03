<?php

namespace Mooi\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Mooi\UserBundle\Entity\User;
use Mooi\UserBundle\Form\Type\UserRegistrationType;
use Mooi\UserBundle\Form\Type\UserEditType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Mooi\UserBundle\Model\UserFactory;

/**
 * Description of UserController
 *
 * @author Jurgen
 */
class UserController extends Controller {

    
    public function indexAction()
    {
        
        $userId = $this->get('security.context')
                            ->getToken()
                            ->getUser()
                            ->getId();
        
        return $this->forward('MooiWallBundle:Wall:index', array(
            'id'  => $userId
        ));
        
    }

    public function loginAction() 
    {
        $request = $this->getRequest();
        $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
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
        
        // Create a suer and set up the form
        $user = new User();
        $form = $this->createForm(new UserRegistrationType(), $user, array(
            "validation_groups" => array("Default", "registration")
        ));
        
        if ($request->getMethod() == 'POST') 
        {
            
            $form->bindRequest($request);
            
            if ($form->isValid()) 
            {

                // Get User factory and let it encode the password
                $userFactory = new UserFactory($this->get('security.encoder_factory'));
                $user->setPassword($userFactory->encode($user));
                
                // Save the User to the database
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($user);
                $em->flush();
                
                // Set flash message and redirect to another page
                $this->get("session")->setFlash('notice', 'Het account is toegevoegd.');
                return $this->redirect($this->generateUrl('MooiUserBundle_UserIndex'));
                
            }
            
        }

        // Show the form
        return $this->render("MooiUserBundle:User:create.html.twig", array(
            'form' => $form->createView()
        ));
        
    }
    
    public function editAction(Request $request)
    {
        
        $user = $this->get('security.context')->getToken()->getUser();
        $form = $this->createForm(new UserEditType(), $user, array(
            "validation_groups" => array("Default")
        ));
        
        $originalPassword = $user->getPassword();
        $newPassword = "";
        
        if ($request->getMethod() == 'POST') 
        {
            
            $form->bindRequest($request);
            
            if ($form->isValid()) 
            {

                $newPassword = $user->getPassword();
                
                if(!empty($newPassword))
                {
                    
                    $userFactory = new UserFactory($this->get('security.encoder_factory'));
                    $user->setPassword($userFactory->encode($user));
                    //echo "new";
                    
                }
                else 
                {
                    
                    $user->setPassword($originalPassword);
                    //echo "old";
                    
                }
                
                // Get User factory and let it encode the password
                $userFactory = new UserFactory($this->get('security.encoder_factory'));
                $user->setPassword($userFactory->encode($user));
                
                /*
                // Save the User to the database
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($user);
                $em->flush();
                
                // Set flash message and redirect to another page
                $this->get("session")->setFlash('notice', 'Het account is toegevoegd.');
                return $this->redirect($this->generateUrl('MooiUserBundle_UserIndex'));
                 */
                
            }
            
        }
        
        return $this->render("MooiUserBundle:User:edit.html.twig", array(
            'form' => $form->createView(),
            'originalPassword' => $originalPassword,
            'newPassword' => $newPassword
        ));
        
    }

}

?>