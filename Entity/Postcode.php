<?php

namespace Parallalax\PostcodeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Postcode
 *
 * @ORM\Table(name="postcode")
 * @ORM\Entity
 */
class Postcode
{
    /**
     * @var string
     *
     * @ORM\Column(name="num", type="string", length=5, nullable=false)
     */
    private $num;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Parallalax\PostcodeBundle\Entity\City", mappedBy="postcodes")
     * @ORM\OrderBy({
     *     "name"="ASC"
     * })
     */
    private $cities;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cities = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set num
     *
     * @param integer $num
     * @return Postcode
     */
    public function setNum($num)
    {
        $this->num = $num;

        return $this;
    }

    /**
     * Get num
     *
     * @return integer
     */
    public function getNum()
    {
        return $this->num;
    }

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
     * Add city
     *
     * @param \Parallalax\PostcodeBundle\Entity\City $city
     * @return Postcode
     */
    public function addCity(\Parallalax\PostcodeBundle\Entity\City $city)
    {
        $this->cities[] = $city;

        return $this;
    }

    /**
     * Remove city
     *
     * @param \Parallalax\PostcodeBundle\Entity\City $city
     */
    public function removeCity(\Parallalax\PostcodeBundle\Entity\City $city)
    {
        $this->cities->removeElement($city);
    }

    /**
     * Get city
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCities()
    {
        return $this->cities;
    }
}
