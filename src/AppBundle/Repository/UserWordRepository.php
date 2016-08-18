<?php

namespace AppBundle\Repository;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

/**
 * UserWordRepository
 */
class UserWordRepository extends EntityRepository
{
    /*************************
     * Admin
     *************************/

    /**
     * Finds all UserWord Query.
     *
     * @return Query
     */
    public function findAllQB()
    {
        $q = $this->createQueryBuilder('uw')
            ->addSelect('us, wo')
            ->innerJoin('uw.user', 'us')
            ->innerJoin('uw.word', 'wo')
            ->orderBy('uw.id', 'desc')
            ->getQuery();

        return $q->getArrayResult();
    }

    /**
     * Counts number of UserWord.
     *
     * @return integer
     */
    public function countQB()
    {
        $q = $this->createQueryBuilder('uw')
            ->select('COUNT(uw)')
            ->getQuery();

        return $q->getSingleScalarResult();
    }

    /**
     * Counts number of UserWord by User.
     *
     * @return integer
     */
    public function countByUserQB($user)
    {
        $q = $this->createQueryBuilder('uw')
            ->select('COUNT(uw)')
            ->where('uw.user.id = :user')
            ->setParameter('user', $user)
            ->getQuery();

        return $q->getSingleScalarResult();
    }

    /**
     * Counts number of UserWord by Word.
     *
     * @return integer
     */
    public function countByWordQB($word)
    {
        $q = $this->createQueryBuilder('uw')
            ->select('COUNT(uw)')
            ->where('uw.word.id = :word')
            ->setParameter('word', $word)
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
