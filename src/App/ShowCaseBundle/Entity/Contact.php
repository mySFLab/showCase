<?php

namespace App\ShowCaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contact
 *
 * @ORM\Table(name="contact")
 * @ORM\Entity(repositoryClass="App\ShowCaseBundle\Repository\ContactRepository")
 */
class Contact
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
     * @ORM\Column(name="contact_lastname", type="string", length=50)
     */
    private $contactLastname;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_firstname", type="string", length=50)
     */
    private $contactFirstname;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var int
     *
     * @ORM\Column(name="phone", type="integer")
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="message_content", type="text")
     */
    private $messageContent;

    /**
     * @var string
     *
     * @ORM\Column(name="method", type="string", length=255)
     */
    private $method;


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
     * Set contactName
     *
     * @param string $contactName
     *
     * @return Contact
     */
    public function setContactLastname($contactLastname)
    {
        $this->contactLastname = $contactLastname;

        return $this;
    }

    /**
     * Get contactName
     *
     * @return string
     */
    public function getContactLastname()
    {
        return $this->contactLastname;
    }

    /**
     * Set contactFirstname
     * @param string $contactFirstname
     * @return Contact
     */
    public function setContactFirstname($contactFirstname)
    {
        $this->contactFirstname = $contactFirstname;

        return $this;
    }

    /**
     * Get contactName
     * @return string
     */
    public function getContactFirstname()
    {
        return $this->contactFirstname;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Contact
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set phone
     *
     * @param integer $phone
     *
     * @return Contact
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return int
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set messageContent
     *
     * @param string $messageContent
     *
     * @return Contact
     */
    public function setMessageContent($messageContent)
    {
        $this->messageContent = $messageContent;

        return $this;
    }

    /**
     * Get messageContent
     *
     * @return string
     */
    public function getMessageContent()
    {
        return $this->messageContent;
    }

    /**
     * Set method
     *
     * @param string $method
     *
     * @return Contact
     */
    public function setMethod($method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * Get method
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }
}

