<?php

namespace App\ShowCaseBundle\Repository;

/**
 * ProjectRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProjectRepository extends \Doctrine\ORM\EntityRepository
{
    public function getProjectsQuery($pro)
    {
        $qb = $this->createQueryBuilder('p');
        $qb
            ->where('p.professionnalProject = :pro')
            ->setParameter('pro', $pro)
        ;
        return $qb->getQuery();
    }
}
