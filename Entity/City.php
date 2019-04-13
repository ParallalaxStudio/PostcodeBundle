<?php

namespace Parallalax\PostcodeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * City
 *
 * @ORM\Table(name="city")
 * @ORM\Entity
 */
class City
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     */
    private $name;

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
     * @ORM\ManyToMany(targetEntity="Parallalax\PostcodeBundle\Entity\Postcode", inversedBy="cities")
     * @ORM\JoinTable(name="city_to_postcode",
     *   joinColumns={
     *     @ORM\JoinColumn(name="city_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="postcode_id", referencedColumnName="id")
     *   }
     * )
     */
    private $postcodes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->postcodes = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set name
     *
     * @param string $name
     * @return City
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add postcode
     *
     * @param \Parallalax\PostcodeBundle\Entity\Postcode $postcode
     * @return City
     */
    public function addPostcode(\Parallalax\PostcodeBundle\Entity\Postcode $postcode)
    {
        $this->postcodes[] = $postcode;

        return $this;
    }

    /**
     * Remove postcode
     *
     * @param \Parallalax\PostcodeBundle\Entity\Postcode $postcode
     */
    public function removePostcode(\Parallalax\PostcodeBundle\Entity\Postcode $postcode)
    {
        $this->postcodes->removeElement($postcode);
    }

    /**
     * Get postcode
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPostcodes()
    {
        return $this->postcodes;
    }
}
