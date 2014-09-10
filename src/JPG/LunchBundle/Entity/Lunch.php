<?php

namespace JPG\LunchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lunch
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="JPG\LunchBundle\Entity\LunchRepository")
 */
class Lunch
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var integer
     *
     * @ORM\Column(name="studentIDs", type="integer")
     */
    private $studentIDs;

    /**
     * @var float
     *
     * @ORM\Column(name="cost", type="decimal", scale=2)
     */
    private $cost = 3.75;


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
     * Set date
     *
     * @param \DateTime $date
     * @return Lunch
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set studentIDs
     *
     * @param integer $studentIDs
     * @return Lunch
     */
    public function setStudentIDs($studentIDs)
    {
        $this->studentIDs = $studentIDs;

        return $this;
    }

    /**
     * Get studentIDs
     *
     * @return integer 
     */
    public function getStudentIDs()
    {
        return $this->studentIDs;
    }

    /**
     * Set cost
     *
     * @param float $cost
     * @return Lunch
     */
    public function setCost($cost)
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * Get cost
     *
     * @return float 
     */
    public function getCost()
    {
        return $this->cost;
    }
}
