<?php

namespace JPG\LunchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Family
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="JPG\LunchBundle\Entity\FamilyRepository")
 */
class Family
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="schoolID", type="integer")
     */
    private $schoolID;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="Username", type="string", length=255)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="emails", type="string", length=255)
     */
    private $emails;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set schoolID
     *
     * @param integer $schoolID
     * @return Family
     */
    public function setSchoolID($schoolID)
    {
        $this->schoolID = $schoolID;

        return $this;
    }

    /**
     * Get schoolID
     *
     * @return integer 
     */
    public function getSchoolID()
    {
        return $this->schoolID;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Family
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return Family
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Family
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set emails
     *
     * @param string $emails
     * @return Family
     */
    public function setEmails($emails)
    {
        $this->emails = $emails;

        return $this;
    }

    /**
     * Get emails
     *
     * @return string 
     */
    public function getEmails()
    {
        return $this->emails;
    }
}
