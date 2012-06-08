<?php

namespace Mooi\WallBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Mooi\WallBundle\Entity\Subject;
use Mooi\WallBundle\Form\Type\SubjectType;
use Symfony\Component\HttpFoundation\Request;

class SubjectController extends Controller
{
    
    public function indexAction()
    {
        
        $repository = $this->getDoctrine()
            ->getRepository('MooiWallBundle:Subject');
        $subjects = $repository->findAll();
                
        return $this->render('MooiWallBundle:Subject:index.html.twig', array(
            'subjects' => $subjects
        ));
        
    }
    
    public function addAction(Request $request)
    {
                
        $subject = new Subject();
        $form = $this->createForm(new SubjectType(), $subject);
        
        if ($request->getMethod() == 'POST') 
        {
            
            $form->bindRequest($request);
            
            if ($form->isValid()) 
            {

                // Save the User to the database
                $entityManager = $this->getDoctrine()->getEntityManager();
                $entityManager->persist($subject);
                $entityManager->flush();
                
                // Set flash message and redirect to another page
                $this->get("session")->setFlash('notice', 'Het vak '. $subject->getName() .' is toegevoegd.');
                return $this->redirect($this->generateUrl('MooiWallBundle_SubjectIndex'));
                
            }
            
        }

         return $this->render('MooiWallBundle:Subject:add.html.twig', array(
            'form' => $form->createView()
        ));
        
    }
    
    public function editAction($name, Request $request)
    {

        $repository = $this->getDoctrine()
            ->getRepository('MooiWallBundle:Subject');
        $subject = $repository->findOneByName($name);
        $form = $this->createForm(new SubjectType(), $subject);
        
        if ($request->getMethod() == 'POST') 
        {
            
            $form->bindRequest($request);
            
            if ($form->isValid()) 
            {

                // Save the User to the database
                $entityManager = $this->getDoctrine()->getEntityManager();
                $entityManager->persist($subject);
                $entityManager->flush();
                
                // Set flash message and redirect to another page
                $this->get("session")->setFlash('notice', 'Het vak '. $subject->getName() .' is aangepast.');
                return $this->redirect($this->generateUrl('MooiWallBundle_SubjectIndex'));
                
            }
            
        }

         return $this->render('MooiWallBundle:Subject:edit.html.twig', array(
            'form' => $form->createView(),
            'subject' => $subject
        ));
        
    }
    
    public function deleteAction($name)
    {
        
        $repository = $this->getDoctrine()
            ->getRepository('MooiWallBundle:Subject');
        $subject = $repository->findOneByName($name);
        
        if($subject != null)
        {
            
            $entityManager = $this->getDoctrine()->getEntityManager();
            $entityManager->remove($subject);
            $entityManager->flush();

            $this->get("session")->setFlash('notice', 'Het vak '. $subject->getName() .' is verwijderd.');
            
        }
        
        return $this->redirect($this->generateUrl('MooiWallBundle_SubjectIndex'));
        
    }
    
}

?>
