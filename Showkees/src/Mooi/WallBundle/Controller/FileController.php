<?php

namespace Mooi\WallBundle\Controller;

use Mooi\WallBundle\Entity\Image;
use Mooi\WallBundle\Form\Type\ImageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class FileController extends Controller
{

    public function uploadAction(Request $request)
    {
                
        $image = new Image();
        $form = $this->createForm(new ImageType(), $image);

        if ($this->getRequest()->getMethod() === 'POST') 
        {
            
            $form->bindRequest($this->getRequest());
            
            if($form->isValid())
            {
                        
                $entityManager = $this->getDoctrine()->getEntityManager();

                $entityManager->persist($image);
                $entityManager->flush();

                $this->get("session")->setFlash('notice', 'Je upload ' . $image->getWebPath());

                $this->redirect($this->generateUrl('MooiWallBundle_WallFileUpload'));
            
            }
            
        }

        return $this->render('MooiWallBundle:Wall:upload.html.twig', array(
                'form' => $form->createView()
        ));
        
    }

    
    
    
}

?>
