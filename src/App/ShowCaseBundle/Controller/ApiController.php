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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\Annotations as Rest;

class ApiController extends Controller
{


    /**
     * @Rest\Get("/projects/", name="projects_list", requirements={"_format"=".*"})
     */
    public function getProjectsAction()
    {
        $projets = $this->getDoctrine()->getRepository(Project::class)->findAll();
        $data = $this->toArray($projets);

        return new JsonResponse($data);
    }

    public function toArray($objects)
    {
        $data = [];

        if (is_array($objects)) {
            /** @var Project $item */
            foreach ($objects as $key=>$item) {
                $data[$key]['id'] = $item->getId();
                $data[$key]['name'] = $item->getProjectName();
                $data[$key]['path'] = $item->getPicPath();
            }
        } else {
            $data['id'] = $objects->getId();
            $data['name'] = $objects->getProjectName();
            $data['path'] = $objects->getPicPath();
        }

        return $data;
    }

    /**
     * @Rest\Get("/projects/{id}", name="project", requirements={"id"=".*"})
     */
    public function getProjectAction($id)
    {
        $projet = $this->getDoctrine()->getRepository(Project::class)->findOneBy(['id' => $id]);
        $data = $this->toArray($projet);

        return new JsonResponse($data);
    }
}