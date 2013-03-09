<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Admin\Entity\Country;

/**
 * A country entity.
 *
 * @ORM\Entity
 * @ORM\Table(name="province")
 * @property string name
 * @property string $abbreviation
 * @property int $id
 */
class Province extends EntityAbstract 
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
    protected $abbreviation;
    
    /**
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="province")
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id")
     **/
    protected $country;
    
    public function getId()
    {
        return $this->id;
    }
    
    public function setId($id)
    {
        $this->id = $id;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function getAbbreviation()
    {
        return $this->abbreviation;
    }

    public function setAbbreviation($abbreviation)
    {
        $this->abbreviation = $abbreviation;
    } 
    
    public function setCountry(Country $country)
    {
        $this->country = $country;
    }
    
    public function getCountry()
    {
        return $this->country;
    }
    
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $factory = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                'name'       => 'id',
                'required'   => true,
                'filters' => array(
                    array('name'    => 'Int'),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'country_id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int')
                ),
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'name',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),

            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'abbreviation',
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 0,
                            'max'      => 15,
                        ),
                    ),
                ),                

            )));
            
            $this->inputFilter = $inputFilter;        
        }

        return $this->inputFilter;
    }         
}