<?php
namespace Admin\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class SemesterOfferForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('semester_offer');
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
            'name' => 'semester_id',
            'type' => 'select',
            'options' => array(
                'label' => 'Semester',
                'value_options' => array(
                    '0' => 'Select One',
                ),
            ),
            'attributes' => array(
                'id' => 'semester_id'
            )
        ));
        $this->add(array(
            'name' => 'offer_id',
            'type' => 'select',
            'options' => array(
                'label' => 'Offer',
                'value_options' => array(
                    '0' => 'Select One',
                ),
            ),
            'attributes' => array(
                'id' => 'offer_id'
            )
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