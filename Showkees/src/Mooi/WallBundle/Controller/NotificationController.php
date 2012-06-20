<?php

namespace Mooi\WallBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NotificationController extends Controller
{

    public function overviewAction()
    {
        
        return $this->render('MooiWallBundle:Notification:overview.html.twig');
        
    }
    
}

?>
