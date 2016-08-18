<?php

namespace AppBundle\Repository;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

/**
 * WordRepository
 */
class WordRepository extends EntityRepository
{
    /*************************
     * Admin
     *************************/

    /**
     * Finds all Words Query.
     *
     * @return Query
     */
    public function findAllQB()
    {
        $q = $this->createQueryBuilder('wo')
            ->orderBy('wo.name', 'asc')
            ->getQuery();

        return $q->getArrayResult();
    }

    /**
     * Counts number of Words.
     *
     * @return integer
     */
    public function countQB()
    {
        $q = $this->createQueryBuilder('wo')
            ->select('COUNT(wo)')
            ->getQuery();

        return $q->getSingleScalarResult();
    }

    /*************************
     * Front
     *************************/

    /**
     * Finds Words by slug.
     *
     * @param string $slug
     * @return Word
     */
    public function findOneBySlugQB($slug)
    {
        $q = $this->createQueryBuilder('wo')
            ->where('wo.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery();

        try {
            $word = $q->getSingleResult();
        } catch (NoResultException $e) {
            throw new NotFoundHttpException();
        }

        return $word;
    }
}
