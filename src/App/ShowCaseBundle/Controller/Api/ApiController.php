<?php
/**
 * Created by PhpStorm.
 * User: laurentbrau
 * Date: 06/01/2018
 * Time: 16:56
 */

namespace App\ShowCaseBundle\Controller\Api;

use App\ShowCaseBundle\Entity\Project;
use App\ShowCaseBundle\Form\ProjectType;
use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends Controller
{
    /**
     * @Rest\View()
     * @Rest\Get("/projects/", name="projects_list", requirements={"_format"=".*"})
     */
    public function getProjectsAction()
    {
        $projets = $this->getDoctrine()->getRepository(Project::class)->findBy(['enabled' => true]);

        return $projets;
    }

    /**
     * @Rest\View()
     * @Rest\Get("/projects/{id}", name="project", requirements={"id"=".*"})
     */
    public function getProjectAction($id)
    {
        $projet = $this->getDoctrine()->getRepository(Project::class)->findOneBy(['id' => $id]);

        if (null === $projet) {
            return new JsonResponse(['message' => 'Project not found'], Response::HTTP_NOT_FOUND);
        }

        return $projet;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/projects/", name="new_project")
     */
    public function addProjectAction(Request $request)
    {
        $project = new Project();

        $form = $this->createForm(ProjectType::class, $project);
        $form->submit($request->request->all());
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($project);
            $em->flush();

            return $project;

        } else {
            return $form;
        }
    }
}