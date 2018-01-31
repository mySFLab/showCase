<?php
/**
 * Created by PhpStorm.
 * User: laurentbrau
 * Date: 06/01/2018
 * Time: 16:56
 */

namespace App\ShowCaseBundle\Controller;

use App\ShowCaseBundle\Entity\Contact;
use App\ShowCaseBundle\Entity\Project;
use App\ShowCaseBundle\Form\ContactType;
use App\ShowCaseBundle\Manager\CacheManager;
use App\ShowCaseBundle\Manager\MailerManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
            ->addExpirationCacheByDate($response, new \DateTime("+1 minute"), new \DateTime("-2 minutes"));

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
            6/*limit per page*/
        );

        // parameters to template
        return $this->render('@AppShowCase/front/project.html.twig', array('projects' => $pagination, 'paginationNb'=> $numberProjects));
    }

    public function learningAction(Request $request)
    {
        return $this->render('@AppShowCase/front/learning.html.twig');
    }
}