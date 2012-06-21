<?php

namespace Mooi\WallBundle\Controller;

use Mooi\WallBundle\Entity\Image;
use Mooi\WallBundle\Form\Type\WallImageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class FileController extends Controller
{

    public function uploadAction()
    {
        
        $post = $this->getDoctrine()
            ->getRepository('MooiWallBundle:Post')
            ->find(2);
        
        $image = new Image();
        $form = $this->createForm(new WallImageType(), $image);

        if ($this->getRequest()->getMethod() === 'POST') {
            $form->bindRequest($this->getRequest());
                $em = $this->getDoctrine()->getEntityManager();
                
                $image->setTime(new \DateTime);
                $image->upload();
                $image->setPosts($post);
                
                $em->persist($image);
                $em->flush();
                
                $this->get("session")->setFlash('notice', 'Je upload ' . $image->path);
                
                $this->redirect($this->generateUrl('MooiWallBundle_WallFileUpload'));
        }

        return $this->render('MooiWallBundle:Wall:upload.html.twig', array(
                'form' => $form->createView()
        ));
        
    }

    
    
    
}

?>
