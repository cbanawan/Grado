<?php
namespace User\Form;

use User\Entity\User;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class UserFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct('user');
        $this->setHydrator(new ClassMethodsHydrator(false))
            ->setObject(new User());

        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
        $this->add(array(
            'name' => 'username',
            'attributes' => array(
                'type'  => 'text',
                'id' => 'username'
            ),
            'options' => array(
                'label' => 'Username',
            ),
        ));
        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type'  => 'password',
                'id' => 'password'
            ),
            'options' => array(
                'label' => 'Password',
            ),
        ));
        $this->add(array(
            'name' => 'retype_password',
            'attributes' => array(
                'type'  => 'password',
                'id' => 'retype_password'
            ),
            'options' => array(
                'label' => 'Re-type Password',
            ),
        ));
    }

    /**
     * @return array
     */
    public function getInputFilterSpecification()
    {
        return array(
            'username' => array(
                'required' => true,
            ),
            'password' => array(
                'required' => true,
            ),
            'retype_password' => array(
                'required' => true,
            )
            
        );
    }
}