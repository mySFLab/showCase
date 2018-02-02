<?php
/**
 * Created by PhpStorm.
 * User: laurentbrau
 * Date: 06/01/2018
 * Time: 16:56
 */

namespace App\ShowCaseBundle\Controller;

use App\ShowCaseBundle\Entity\Project;
use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\Annotations as Rest;

class ApiController extends Controller
{


    /**
     * @Rest\View()
     * @Rest\Get("/projects/", name="projects_list", requirements={"_format"=".*"})
     */
    public function getProjectsAction()
    {
        $projets = $this->getDoctrine()->getRepository(Project::class)->findAll();

        return $projets;
    }

    /**
     * @Rest\View()
     * @Rest\Get("/projects/{id}", name="project", requirements={"id"=".*"})
     */
    public function getProjectAction($id)
    {
        $projet = $this->getDoctrine()->getRepository(Project::class)->findOneBy(['id' => $id]);

        return $projet;
    }
}