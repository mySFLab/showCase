<?php
/**
 * Created by PhpStorm.
 * User: laurentbrau
 * Date: 06/01/2018
 * Time: 16:56
 */

namespace App\ShowCaseBundle\Controller\Api;

use App\ShowCaseBundle\Entity\User;
use App\ShowCaseBundle\Form\UserType;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use App\ShowCaseBundle\Entity\Project;
use App\ShowCaseBundle\Form\ProjectType;
use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation as Doc;
use Swagger\Annotations as SWG;

class ApiProjectController extends Controller
{
    /**
     * @Rest\View()
     * @Rest\Get("/admin/projects/", name="projects_list_admin")
     * @SWG\Response(
     *     response=200,
     *     description="Return projects list",
     *     @SWG\Schema(
     *         type="object",
     *         @Model(type=Project::class)
     *     )
     * )
     */
    public function projectListAction()
    {
        $projets = $this->getDoctrine()->getRepository(Project::class)->findBy(['enabled' => true]);

        return $projets;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/projects/", name="_add_project")
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

    /**
     * @Rest\View(statusCode=Response::HTTP_ACCEPTED)
     * @Rest\Put("/projects/{id}", requirements={"id"=".*"})
     *
     */
    public function editProjectAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $project = $em->getRepository(Project::class)->findOneBy(['id' => $id]);
        $form = $this->createForm(ProjectType::class, $project);
        $form->submit($request, false);
        if ($form->isValid()) {
            $em->merge($project);
            $em->flush();
        }

        return $project;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Patch("/projects/{id}", name="_modify_project")
     */
    public function modifyProjectAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $projet = $em->getRepository(Project::class)->findOneBy(['id' => $id]);
        $form = $this->createForm(UserType::class, $projet);
        $form->submit($request->request->all(), false);
        if ($form->isSubmitted() && $form->isValid()) {
            // todo faire un cas de gestion pour les roles (doublons, roles inexistants et remove d'un role, ajout de plus de deux roles a une user)
            $em->flush();

            return $projet;
        }

        return $form;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/projects/{id}", name="remove_project", requirements={"id"=".*"})
     */
    public function deleteProjectAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $project = $em->getRepository(Project::class)->findOneBy(['id' => $id]);

        try {
            $em->remove($project);
            $em->flush();
        } catch(\Exception $e) {
            return new JsonResponse([
                'message' => 'Project not found in database',
                'exception_message' => $e->getMessage()
            ]);
        }
    }



}