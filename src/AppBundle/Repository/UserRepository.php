<?php

namespace AppBundle\Repository;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

/**
 * UserRepository
 */
class UserRepository extends EntityRepository
{
    /*************************
     * Admin
     *************************/

    /**
     * Finds all Users Query.
     *
     * @return Query
     */
    public function findAllQB()
    {
        $q = $this->createQueryBuilder('us')
            ->orderBy('us.name', 'asc')
            ->getQuery();

        return $q->getArrayResult();
    }

    /**
     * Counts number of Users.
     *
     * @return integer
     */
    public function countQB()
    {
        $q = $this->createQueryBuilder('us')
            ->select('COUNT(us)')
            ->getQuery();

        return $q->getSingleScalarResult();
    }

    /*************************
     * Front
     *************************/

    /**
     * Finds User by slug.
     *
     * @param string $slug
     * @return User
     */
    public function findOneBySlugQB($slug)
    {
        $q = $this->createQueryBuilder('us')
            ->where('us.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery();

        try {
            $user = $q->getSingleResult();
        } catch (NoResultException $e) {
            throw new NotFoundHttpException();
        }

        return $user;
    }
}
