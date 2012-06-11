<?php

namespace Mooi\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Mooi\UserBundle\Entity\Role;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Domain\RoleSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

class SetupController extends Controller
{

    public function rolesAction()
    {
        
        // Create roles
        $entityManager = $this->getDoctrine()->getEntityManager();
        
        $superAdmin = new Role();
        $superAdmin->setName("superadmin");
        $superAdmin->setInternalName("ROLE_SUPERADMIN");
        
        $admin = new Role();
        $admin->setName("admin");
        $admin->setInternalName("ROLE_ADMIN");
        
        $teacher = new Role();
        $teacher->setName("leerkracht");
        $teacher->setInternalName("ROLE_TEACHER");
        
        $student = new Role();
        $student->setName("leerling");
        $student->setInternalName("ROLE_STUDENT");
        
        $entityManager->persist($superAdmin);
        $entityManager->persist($admin);
        $entityManager->persist($teacher);
        $entityManager->persist($student);
        $entityManager->flush();
        
        return new Response('Roles toegevoegd');
        
    }
    
    public function rolesACLAction()
    {
        
        $repository = $this->getDoctrine()->getRepository("MooiUserBundle:Role");
        
        $student = $repository->findOneByName('leerling');
        $teacher = $repository->findOneByName('leerkracht');
        $admin = $repository->findOneByName('admin');
        $superAdmin = $repository->findOneByName('superadmin');
        
        /**
         * Setup acls 
         */
        $aclProvider = $this->get('security.acl.provider');
        
            // Student acl
            $studentIdentify = ObjectIdentity::fromDomainObject($student);
            
            $studentAcl = $aclProvider->createAcl($studentIdentify);

            $studentID = new RoleSecurityIdentity("ROLE_STUDENT"); 
            $studentAcl->insertClassAce($studentID, MaskBuilder::MASK_OWNER);

            $teacherId = new RoleSecurityIdentity("ROLE_TEACHER"); 
            $studentAcl->insertClassAce($teacherId, MaskBuilder::MASK_OWNER);
            
            $aclProvider->updateAcl($studentAcl);
                        
            // teacher acl
            $teacherIdenify = ObjectIdentity::fromDomainObject($teacher);
            $teacherAcl = $aclProvider->createAcl($teacherIdenify);

            $adminId = new RoleSecurityIdentity("ROLE_ADMIN"); 
            $teacherAcl->insertClassAce($adminId, MaskBuilder::MASK_OWNER); 
            
            $aclProvider->updateAcl($teacherAcl);
            
            // admin acl
            $adminIdentify = ObjectIdentity::fromDomainObject($admin);
            $adminAcl = $aclProvider->createAcl($adminIdentify);

            $superAdminId = new RoleSecurityIdentity("ROLE_SUPERADMIN"); 
            $adminAcl->insertClassAce($superAdminId, MaskBuilder::MASK_OWNER); 
            
            $aclProvider->updateAcl($adminAcl);
        
        return new Response('Roles toegevoegd');
        
    }
    
}

?>
