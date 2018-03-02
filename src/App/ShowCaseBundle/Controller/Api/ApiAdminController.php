<?php
/**
 * Created by PhpStorm.
 * User: laurentbrau
 * Date: 06/01/2018
 * Time: 16:56
 */

namespace App\ShowCaseBundle\Controller\Api;

use App\ShowCaseBundle\Entity\Project;
use App\ShowCaseBundle\Entity\User;
use App\ShowCaseBundle\Form\ProjectType;
use App\ShowCaseBundle\Form\UserType;
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
use Symfony\Component\Serializer\Encoder\JsonDecode;
use Symfony\Component\Serializer\Exception\BadMethodCallException;

class ApiAdminController extends Controller
{
    /**
     * @Rest\View()
     * @Rest\Get("/users/", name="_users_list", requirements={"_format"=".*"})
     */
    public function getUsersAction()
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $users;
    }

    /**
     * @Rest\View()
     * @Rest\Get("/users/{id}", name="_get_user_by_id", requirements={"id"=".*"})
     */
    public function getUserAction($id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['id' => $id]);

        if (null === $user) {
            return new JsonResponse(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        return $user;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/users/", name="_add_user")
     */
    public function addUserAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->submit($request->request->all());
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $user;

        } else {
            return $form;
        }
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Put("/users/{id}", name="_edit_user")
     */
    public function editUserAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->findOneBy(['id' => $id]);
        $form = $this->createForm(UserType::class, $user);
        $form->submit($request->request->all());
        if ($form->isSubmitted() && $form->isValid()) {
            // todo faire un cas de gestion pour les roles (doublons, roles inexistants et remove d'un role, ajout de plus de deux roles a une user)
            $em->flush();

            return $user;
        }

        return $form;
    }


    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Patch("/users/{id}", name="_modify_user")
     */
    public function modifyUserAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->findOneBy(['id' => $id]);
        $form = $this->createForm(UserType::class, $user);
        $form->submit($request->request->all(),false );
        if ($form->isSubmitted() && $form->isValid()) {
            // todo faire un cas de gestion pour les roles (doublons, roles inexistants et remove d'un role, ajout de plus de deux roles a une user)
            $em->flush();

            return $user;
        }

        return $form;
    }


    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/users/{id}", name="remove_user")
     */
    public function deleteUserAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->findOneBy(['id' => $id]);

        try {
            $em->remove($user);
            $em->flush();
            return $user;
        } catch(\Exception $e) {
            return new JsonResponse([
                'message' => 'User not found in database',
                'exception_message' => $e->getMessage()
            ]);
        }
    }
}