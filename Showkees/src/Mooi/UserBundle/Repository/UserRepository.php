<?php

namespace Mooi\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository
{
    
    /*public function findByRole($role)
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT u, r FROM MooiUserBundle:User u
                JOIN u.role r
                WHERE r.name = :role'
            )->setParameter('role', $role);

        try {
            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }*/
    
}