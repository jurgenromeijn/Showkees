<?php

namespace Mooi\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TeacherController extends Controller
{
    
    public function overviewAction()
    {
        
        $roleRepository = $this->getDoctrine()
            ->getRepository('MooiUserBundle:Role');
        
        $admins   = $roleRepository->findOneByName('admin')->getUsers();
        $teachers = $roleRepository->findOneByName('leerkracht')->getUsers();
        
        return $this->render('MooiUserBundle:Teacher:overview.html.twig', array(
            'admins'   => $admins,
            'teachers' => $teachers
        ));
        
    }

    public function studentOverviewAction()
    {
                
        $roleRepository = $this->getDoctrine()
            ->getRepository('MooiUserBundle:Role');
        
        $teacher   = $this->get('security.context')->getToken()->getUser();
        $students  = $roleRepository->findOneByName('leerling')->getUsers();
        $pupilList = array();
        
        foreach ($teacher->getStudents() as $student) 
        {
            
            $pupilList[] = $student->getId();
            
        }
        
        return $this->render("MooiUserBundle:Teacher:studentOverview.html.twig", array(
            'students'  => $students,
            'pupilList' => $pupilList,
            'teacher'   => $teacher
        ));
        
    }
    
    public function addStudentAction($username)
    {
        
        $teacher = $this->get('security.context')->getToken()->getUser();
        
        $userRepository = $this->getDoctrine()
            ->getRepository('MooiUserBundle:User');
        
        $student = $userRepository->findOneByUsername($username);
                
        if($student != null && $student->getRole()->getName() == 'leerling')
        {
                        
            try
            {
                
                $teacher->addUser($student);

                $entityManager = $this->getDoctrine()->getEntityManager();
                $entityManager->persist($teacher);
                $entityManager->flush();

                $this->get("session")->setFlash('notice', $student->getFullName() . ' is nu een van jouw leerlingen.');

            }
            catch(\PDOException $exception)
            {
                
                $this->get("session")->setFlash('notice', $student->getFullName() . ' is al een van jouw leerlingen.');
                
            }
            
        }
        
        return $this->redirect($this->generateUrl('MooiUserBundle_TeacherStudentOverview'));
        
    }
    
    public function removeStudentAction($username)
    {
        
        $userRepository = $this->getDoctrine()
            ->getRepository('MooiUserBundle:User');

        $teacher = $this->get('security.context')->getToken()->getUser();
        $student = $userRepository->findOneByUsername($username);
                
        if($student != null)
        {
                        
                
            $teacher->getStudents()->removeElement($student);

            $entityManager = $this->getDoctrine()->getEntityManager();
            $entityManager->persist($teacher);
            $entityManager->flush();

            $this->get("session")->setFlash('notice', $student->getFullName() . ' is niet langer een van jouw leerlingen.');

        }
        
        return $this->redirect($this->generateUrl('MooiUserBundle_TeacherStudentOverview'));
       
    }
    
}

?>
