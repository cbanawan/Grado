<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;

/**
 * A semester entity.
 *
 * @ORM\Entity
 * @ORM\Table(name="semester")
 * @property string $id
 * @property string $semester
 * @property string $school_year
 * @property int $description
 */
class Semester extends EntityAbstract 
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $semester;

    /**
     * @ORM\Column(type="string")
     */
    protected $school_year;

    /**
     * @ORM\Column(type="string")
     */
    protected $description;
    
    /**
     * @ORM\ManyToMany(targetEntity="Offer", inversedBy="users", cascade="persist")
     * @ORM\JoinTable(name="semester_offer")
     **/
    protected $offers;

    
    public function __construct()
    {
        $this->offers = new ArrayCollection();
    }
    
    public function addOffer(Offer $offer)
    {
        $this->offers->add($offer);
    }

    public function getOffers()
    {
        return $this->offers;
    }
}