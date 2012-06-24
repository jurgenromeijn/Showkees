<?php

namespace Mooi\WallBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class FrontpageController extends Controller
{

    public function indexAction(Request $request)
    {
                        
        if ($this->get('security.context')->isGranted('ROLE_ADMIN'))
        {
            
            return $this->forward('MooiUserBundle:Teacher:overview');
            
        }
        elseif($this->get('security.context')->isGranted('ROLE_TEACHER'))
        {
            
            return $this->forward('MooiUserBundle:Teacher:studentOverview');
            
        }
        else
        {
            
            return $this->forward('MooiWallBundle:Wall:index', array('name' => null));
            
        }
        
    }
    
    public function aboutAction()
    {
        
        //waiting for text
        
    }
    
}

?>
