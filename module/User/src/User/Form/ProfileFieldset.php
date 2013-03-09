<?php
namespace User\Form;

use User\Entity\Profile;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class ProfileFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct('profile');
        $this->setHydrator(new ClassMethodsHydrator(false))
            ->setObject(new Profile());

        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
        $this->add(array(
            'name' => 'last_name',
            'attributes' => array(
                'type'  => 'text',
                'id' => 'last_name'
            ),
            'options' => array(
                'label' => 'Lastname',
            ),
        ));
        $this->add(array(
            'name' => 'first_name',
            'attributes' => array(
                'type'  => 'text',
                'id' => 'first_name'
            ),
            'options' => array(
                'label' => 'Firstname',
            ),
        ));
        $this->add(array(
            'name' => 'middle_name',
            'attributes' => array(
                'type'  => 'text',
                'id' => 'middle_name'
            ),
            'options' => array(
                'label' => 'Middlename',
            ),
        ));
        $this->add(array(
            'name' => 'email_address',
            'attributes' => array(
                'type'  => 'text',
                'id' => 'email_address'
            ),
            'options' => array(
                'label' => 'Email',
            ),
        ));
        $this->add(array(
            'name' => 'address_1',
            'attributes' => array(
                'type'  => 'text',
                'id' => 'address_1'
            ),
            'options' => array(
                'label' => 'Address 1',
            ),
        ));
        $this->add(array(
            'name' => 'address_2',
            'attributes' => array(
                'type'  => 'text',
                'id' => 'address_2'
            ),
            'options' => array(
                'label' => 'Address 2',
            ),
        ));
        $this->add(array(
            'name' => 'city',
            'attributes' => array(
                'type'  => 'text',
                'id' => 'city'
            ),
            'options' => array(
                'label' => 'City',
            ),
        ));
        $this->add(array(
            'name' => 'country_id',
            'type'  => 'select',
            'attributes' => array(
                'id' => 'country_id'
            ),
            'options' => array(
                'label' => 'Country',
            ),
        ));
        $this->add(array(
            'name' => 'province_id',
            'type'  => 'select',
            'attributes' => array(
                'id' => 'province_id'
            ),
            'options' => array(
                'label' => 'Province',
            ),
        ));
        $this->add(array(
            'name' => 'home_phone',
            'type' => 'text',
            'attributes' => array(
                'id' => 'home_phone'
            ),
            'options' => array(
                'label' => 'Home Phone',
            ),
        ));
        $this->add(array(
            'name' => 'mobile_phone',
            'type' => 'text',
            'attributes' => array(
                'id' => 'mobile_phone'
            ),
            'options' => array(
                'label' => 'Mobile Phone',
            ),
        ));
        
    }

    /**
     * @return array
     */
    public function getInputFilterSpecification()
    {
        return array(
            'first_name' => array(
                'required' => true,
            ),
            'last_name' => array(
                'required' => true,
            )
            
        );
    }
}