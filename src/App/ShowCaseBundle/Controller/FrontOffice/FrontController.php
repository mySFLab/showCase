<?php
/**
 * Created by PhpStorm.
 * User: laurentbrau
 * Date: 06/01/2018
 * Time: 16:56
 */

namespace App\ShowCaseBundle\Controller\FrontOffice;

use App\ShowCaseBundle\Entity\Contact;
use App\ShowCaseBundle\Entity\Project;
use App\ShowCaseBundle\Form\ContactType;
use App\ShowCaseBundle\Manager\CacheManager;
use App\ShowCaseBundle\Manager\MailerManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;

class FrontController extends Controller
{
    public function homePageAction(Request $request)
    {
        return $this->render("@AppShowCase/front/home_page.html.twig");
    }

    public function contactAction(Request $request)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $response = $this->render('@AppShowCase/front/contact.html.twig', ['form' => $form->createView()]);
        $this->get(CacheManager::class)
            ->addExpirationCacheByDate($response, new \DateTime("+1 hour"), new \DateTime("-2 minutes"));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();
            $view = $this->renderView(':Emails/contact_message.tpl:contact_message.tpl.html.twig', array('name' => 'super mega name'));
            $this->get(MailerManager::class)->send($view, 'Look le bo goss','application_de_ton_cheri@gmail.com', 'laurent.brau@gmail.com', $type = 'text/html');
        }

        return $response;
    }

    public function aboutAction(Request $request)
    {
        $response = $this->render('@AppShowCase/front/about.html.twig');
        $this->get(CacheManager::class)
            ->addExpirationCacheByDate($response, new \DateTime("+10 seconds"), new \DateTime("-2 minutes"));

        return $response;
    }

    public function freelanceAction(Request $request)
    {
        return $this->render('@AppShowCase/front/freelance.html.twig');
    }

    public function projectAction(Request $request)
    {
        $query = $this->getDoctrine()->getManager()->getRepository(Project::class)->getProjectsQuery();
        $projects = clone $query;
        $numberProjects = count($projects->getResult());
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $this->getParameter('knp_paginator.page_range')/*limit per page*/
        );

        // parameters to template
        $response = $this->render('@AppShowCase/front/project.html.twig', array('projects' => $pagination, 'paginationNb'=> $numberProjects));

        $this->get(CacheManager::class)
            ->addExpirationCacheByDate($response, new \DateTime("+1 hour"), new \DateTime("-1 hour"));

        return $response;
    }

    public function learningAction(Request $request)
    {
        return $this->render('@AppShowCase/front/learning.html.twig');
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function loginAction(Request $request)
    {
        /** @var $session Session */
        $session = $request->getSession();

        $authErrorKey = Security::AUTHENTICATION_ERROR;
        $lastUsernameKey = Security::LAST_USERNAME;

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has($authErrorKey)) {
            $error = $request->attributes->get($authErrorKey);
        } elseif (null !== $session && $session->has($authErrorKey)) {
        $error = $session->get($authErrorKey);
            $session->remove($authErrorKey);
        } else {
            $error = null;
        }

        if (!$error instanceof AuthenticationException) {
            $error = null; // The value does not come from the security component.
        }

        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);

        $csrfToken = $this->has('security.csrf.token_manager')
            ? $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue()
            : null;

        return $this->renderLogin(array(
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
        ));
    }

    /**
     * Renders the login template with the given parameters. Overwrite this function in
     * an extended controller to provide additional data for the login template.
     *
     * @param array $data
     *
     * @return Response
     */
    protected function renderLogin(array $data)
    {
        return $this->render('@AppShowCase/security/login.html.twig', $data);
    }

    public function getProjectsClientViewAction()
    {
        return $this->render("@AppShowCase/client_side/projects_list.html.twig");
    }
}