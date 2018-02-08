<?php

namespace App\ShowCaseBundle\Manager;

use Symfony\Component\HttpFoundation\Response;

class CacheManager
{
    public function addExpirationCacheByDate(Response $response, \DateTime $expirationDate, \DateTime $lastModifiedDate, $public = true)
    {
        $response->setPublic($public);
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