<?php

namespace Mooi\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Mooi\UserBundle\Entity\User;
use Mooi\UserBundle\Form\Type\UserType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of UserController
 *
 * @author Jurgen
 */
class UserController extends Controller {

    public function loginAction() 
    {
        
	return $this->render("MooiUserBundle:User:login.html.twig");
        
    }
    
    public function createAction(Request $request)
    {
        
        $user = new User();
        $form = $this->createForm(new UserType(), $user, array(
            "validation_groups" => array("Default", "registration")
        ));
        
        if ($request->getMethod() == 'POST') 
        {
            
            $form->bindRequest($request);

            if ($form->isValid()) 
            {

                
            }
            
        }

        
        return $this->render("MooiUserBundle:User:create.html.twig", array(
            'form' => $form->createView()
        ));
        
    }

}

?>