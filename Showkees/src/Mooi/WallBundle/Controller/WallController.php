<?php

namespace Mooi\WallBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WallController extends Controller
{

    public function indexAction()
    {
        
        $request = $this->getRequest();
        $session = $request->getSession();
        
        //check if wall_owner or teacher
        
        return $this->render('MooiWallBundle:Wall:index.html.twig', array('name' => 'Dubbele column'));
        
        
    }
}
