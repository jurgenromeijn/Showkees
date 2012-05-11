<?php

namespace Mooi\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of UserController
 *
 * @author Jurgen
 */
class UserController extends Controller {

    public function loginAction() {
	return $this->render("MooiUserBundle:User:login.html.twig");
    }

}

?>