<?php

namespace Mooi\UserBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Mooi\UserBundle\Entity\Role;

class LoadRoles extends AbstractFixture implements FixtureInterface
{

    public function load(ObjectManager $manager)
    {
        
        
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
        
        $manager->persist($superAdmin);
        $manager->persist($admin);
        $manager->persist($teacher);
        $manager->persist($student);
        $manager->flush();

        $this->addReference('role-superAdmin', $superAdmin);
        $this->addReference('role-admin', $admin);
        $this->addReference('role-teacher', $teacher);
        $this->addReference('role-student', $student);
    }

    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }
    
}

?>
