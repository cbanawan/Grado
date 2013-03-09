<?php
namespace User\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class StudentForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('student');
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
            'type' => 'User\Form\ProfileFieldset',
            'name' => 'profile',
            'options' => array(
                'label' => 'Profile'
            )
        ));  
        $this->add(array(
            'type' => 'User\Form\UserFieldset',
            'name' => 'user',
            'options' => array(
                'label' => 'User'
            )
        ));         
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Register',
                'id' => 'registerButton',
            ),
        ));
    }
}