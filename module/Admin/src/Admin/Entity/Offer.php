<?php
namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;

/**
 * A offer entity.
 *
 * @ORM\Entity
 * @ORM\Table(name="offer")
 * @property string $id
 * @property string $code
 * @property string $name
 * @property int $description
 */
class Offer extends EntityAbstract 
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
    protected $code;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="string")
     */
    protected $description;
    
    /**
     * @ORM\ManyToOne(targetEntity="Subject", inversedBy="offers")
     * @ORM\JoinColumn(name="subject_id", referencedColumnName="id")
     **/
    protected $subject;
    
    /**
     * @ORM\ManyToMany(targetEntity="Semester", mappedBy="offers")
     **/
    protected $semester;  
    
    public function __construct()
    {
        $this->semester = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    public function setSemester(Semester $semester)
    {
        $this->semester->add($semester);
    }
}