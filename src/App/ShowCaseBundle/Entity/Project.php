<?php

namespace App\ShowCaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Project
 *
 * @ORM\Table(name="project")
 * @ORM\Entity(repositoryClass="App\ShowCaseBundle\Repository\ProjectRepository")
 */
class Project
{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="project_name", type="string", length=255, unique=true)
     */
    private $projectName;

    /**
     * @var string
     *
     * @ORM\Column(name="content_text", type="text")
     */
    private $contentText;

    /**
     * @var string
     *
     * @ORM\Column(name="picPath", type="string", length=255)
     */
    private $picPath;

    /**
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled;

    /**
     * @var string
     *
     * @ORM\Column(name="professionnal_project", type="boolean")
     */
    private $professionnalProject;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set projectName
     *
     * @param string $projectName
     *
     * @return Project
     */
    public function setProjectName($projectName)
    {
        $this->projectName = $projectName;

        return $this;
    }

    /**
     * Get projectName
     *
     * @return string
     */
    public function getProjectName()
    {
        return $this->projectName;
    }

    /**
     * Set projectName
     *
     * @param string $contentText
     *
     * @return Project
     */
    public function setContentText($contentText)
    {
        $this->contentText = $contentText;

        return $this;
    }

    /**
     * Get contentText
     *
     * @return string
     */
    public function getContentText()
    {
        return $this->contentText;
    }

    /**
     * Set picPath
     *
     * @param string $picPath
     *
     * @return Project
     */
    public function setPicPath($picPath)
    {
        $this->picPath = $picPath;

        return $this;
    }

    /**
     * Get picPath
     *
     * @return string
     */
    public function getPicPath()
    {
        return $this->picPath;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     *
     * @return Project
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return bool
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set professionnalProject
     *
     * @param boolean $professionnalProject
     *
     * @return Project
     */
    public function setProfessionnalProject($professionnalProject)
    {
        $this->professionnalProject = $professionnalProject;

        return $this;
    }

    /**
     * Get professionnalProject
     *
     * @return boolean
     */
    public function getProfessionnalProject()
    {
        return $this->professionnalProject;
    }
}
