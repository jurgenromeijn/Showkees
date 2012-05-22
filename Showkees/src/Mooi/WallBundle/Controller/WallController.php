<?php

namespace Mooi\WallBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class WallController extends Controller
{

    public function indexAction()
    {
        
        return $this->render('MooiWallBundle:Wall:index.html.twig', array('name' => 'Dubbele column'));
        
    }
}
