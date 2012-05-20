<?php

namespace Mooi\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Mooi\UserBundle\Entity\User;
use Mooi\UserBundle\Form\Type\UserType;

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
    
    public function createAction()
    {
        
        $user = new User();
        $form = $this->createForm(new UserType(), $user);
        
        return $this->render("MooiUserBundle:User:create.html.twig", array(
            'form' => $form->createView()
        ));
        
    }

}

?>