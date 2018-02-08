<?php
/**
 * Created by PhpStorm.
 * User: laurentbrau
 * Date: 06/01/2018
 * Time: 16:56
 */

namespace App\ShowCaseBundle\Controller\Api;

use App\ShowCaseBundle\Entity\User;
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

class ApiProjectController extends Controller
{
    /**
     * @Rest\View()
     * @Rest\Get("/admin/project/list", name="projects_list_admin", requirements={"_format"=".*"})
     */
    public function projectListAction()
    {
        $projets = $this->getDoctrine()->getRepository(Project::class)->findBy(['enabled' => true]);

        return $projets;
    }

    /**
     * @Rest\View()
     * @Rest\Get("/admin/user/list/", name="users_list_admin", requirements={"_format"=".*"})
     */
    public function userListAction()
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $users;
    }
}