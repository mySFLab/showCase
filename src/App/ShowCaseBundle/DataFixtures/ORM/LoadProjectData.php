<?php

namespace App\ShowCaseBundle\DataFixtures\ORM;

use App\ShowCaseBundle\Entity\Project;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadProjectData extends Fixture
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for($i = 0; $i < 10 ; ++$i)
        {
            $project = new Project();
            $label = sprintf("project : %s", $i);
            $project->setProjectName($label);
            $project->setPicPath("http://lorempixel.com/400/200/");
            $project->setEnabled(1);
            $project->setContentText("Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias assumenda aut consectetur dolor eius explicabo fugit in, ipsum laboriosam laudantium nam perferendis porro, quas quibusdam quidem rem, repellat reprehenderit tempora.");

            $manager->persist($project);
        }

        $manager->flush();
    }
}