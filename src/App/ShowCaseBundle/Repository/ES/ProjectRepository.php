<?php

namespace App\ShowCaseBundle\Repository\ES;

use FOS\ElasticaBundle\Repository;

class ProjectRepository extends Repository
{
    public function findWithCustomQuery()
    {
        dump('es repo');die;
    }
}
