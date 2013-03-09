<?php
namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface; 

abstract class EntityAbstract implements InputFilterAwareInterface 
{
    protected $inputFilter;
    protected $fields;

    /**
     * Magic getter to expose protected properties.
     *
     * @param string $property
     * @return mixed
     */
    public function __get($property) 
    {
        return $this->$property;
    }

    /**
     * Magic setter to save protected properties.
     *
     * @param string $property
     * @param mixed $value
     */
    public function __set($property, $value) 
    {
        $this->$property = $value;
    }

    /**
     * Convert the object to an array.
     *
     * @return array
     */
    public function getArrayCopy() 
    {
        return get_object_vars($this);
    }
    
    public function addInputFilterFactoryItem(InputFactory $inputFactoryItem)
    {
        if (!$this->inputFilter)
        {
            $this->inputFilter = new InputFilter();
        }
        
        $this->inputFilter->add($inputFactoryItem);
    }
    
    public function populate($data = array())
    {
        foreach($data as $name => $value)
        {
            $this->$name = $value;
        }
    }
    
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        return $this->inputFilter = $inputFilter;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}