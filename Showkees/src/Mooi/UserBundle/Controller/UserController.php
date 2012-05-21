<?php

namespace Mooi\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Mooi\UserBundle\Entity\User;
use Mooi\UserBundle\Form\Type\UserType;
use Symfony\Component\HttpFoundation\Request;
use Mooi\UserBundle\Model\UserFactory;

/**
 * Description of UserController
 *
 * @author Jurgen
 */
class UserController extends Controller {

    
    public function indexAction()
    {
        
        return $this->render("MooiUserBundle:User:index.html.twig");
        
    }

    public function loginAction() 
    {
                
	return $this->render("MooiUserBundle:User:login.html.twig");
        
    }
    
    public function createAction(Request $request)
    {
        
        // Create a suer and set up the form
        $user = new User();
        $form = $this->createForm(new UserType(), $user, array(
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

}

?>