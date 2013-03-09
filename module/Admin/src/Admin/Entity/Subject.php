<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;

/**
 * A subject entity.
 *
 * @ORM\Entity
 * @ORM\Table(name="subject")
 * @property string $id
 * @property string $name
 * @property string $short_name
 * @property int $description
 */
class Subject extends EntityAbstract 
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="string")
     */
    protected $short_name;

    /**
     * @ORM\Column(type="string")
     */
    protected $description;
    
    /**
     * @ORM\OneToMany(targetEntity="Offer", mappedBy="subject")
     **/
    protected $offer;
}