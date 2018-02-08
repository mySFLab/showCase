<?php

namespace App\ShowCaseBundle\DataFixtures\ORM;

use App\ShowCaseBundle\Entity\Project;
use App\ShowCaseBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class LoadUserData extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for($i = 0; $i < 10 ; ++$i)
        {
            $user = new User();
            $user->setUsername('admin'.$i);

            $password = $this->encoder->encodePassword($user, 'admin');
            $user->setPassword($password);
            $user->setEmail('laurent'.$i.'.brau@gmail.com');

            $manager->persist($user);
            $manager->flush();
        }

        $manager->flush();
    }
}