<?php

namespace Mooi\WallBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class NotificationController extends Controller
{

    public function overviewAction()
    {
        
        $user = $this->get('security.context')->getToken()->getUser();
        
        $repository = $this->getDoctrine()->getRepository('MooiWallBundle:Notification');
        $repository->markAsRead($user->getId());
        
        return $this->render('MooiWallBundle:Notification:overview.html.twig');
        
    }
    
    public function markAsReadAction()
    {
        
        $user = $this->get('security.context')->getToken()->getUser();
        
        $repository = $this->getDoctrine()->getRepository('MooiWallBundle:Notification');
        $repository->markAsRead($user->getId());
        
        $responseJson = array(
            'succes' => true
        );
                
        return new Response(json_encode($responseJson));
        
    }
    
}

?>
