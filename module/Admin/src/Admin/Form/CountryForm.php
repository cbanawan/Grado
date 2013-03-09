<?php
namespace Admin\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class CountryForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('country');
        $this->setAttribute('method', 'post')
             ->setHydrator(new ClassMethodsHydrator(false))
             ->setInputFilter(new InputFilter());
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
        $this->add(array(
            'name' => 'name',
            'attributes' => array(
                'type'  => 'text',
                'id' => 'name',
            ),
            'options' => array(
                'label' => 'Name'
            ),
        ));
        $this->add(array(
            'name' => 'abbreviation',
            'attributes' => array(
                'type'  => 'text',
                'id' => 'abbreviation',
            ),
            'options' => array(
                'label' => 'Abbreviation',
            ),
        ));
        
        $this->add(array(
            'name' => 'spacer',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));        
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Save',
                'id' => 'registerButton',
            ),
        ));
    }
}