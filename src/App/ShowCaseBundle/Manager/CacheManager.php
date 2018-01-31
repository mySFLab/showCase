<?php

namespace App\ShowCaseBundle\Manager;

use Symfony\Component\HttpFoundation\Response;

class CacheManager
{
    public function addExpirationCacheByDate(Response $response, \DateTime $expirationDate, \DateTime $lastModifiedDate)
    {
        $response->setPublic();
        $response->setExpires($expirationDate);
        $response->setLastModified($lastModifiedDate);

        return $response;
    }

    public function addExpirationCacheByDataTime()
    {

    }

    public function addValidationCache()
    {

    }
}