<?php

namespace Mooi\UserBundle\Repository;

use Mooi\UserBundle\Entity\Role;
use Doctrine\ORM\EntityRepository;

/**
 * RoleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RoleRepository extends EntityRepository
{
    
    public function findLowerRolesQueryBuilder(Role $role)
    {
                
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        
        $queryBuilder->select('r')
                ->from('MooiUserBundle:role', 'r')
                ->where('r.id > :role_id')
                ->orderBy('r.id', 'DESC')
                ->setParameter('role_id', $role->getId());
        
        return $queryBuilder;
        
    }
    
}

?>
