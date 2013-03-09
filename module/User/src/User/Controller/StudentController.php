<?php
namespace User\Controller;

use User\Controller\EntityActionController;
use Zend\View\Model\ViewModel;
use User\Form\StudentForm;
use User\Entity\Student;

class StudentController extends EntityActionController
{
    
    protected function getCountryArray()
    {
        $countries = $this->getEntityManager()->getRepository('Admin\Entity\Country')->findAll();
        $options = array('' => '(Select One)');
        foreach($countries as $country)
        {
            $options[$country->id] = $country->name . ' (' . $country->abbreviation . ')';
        }
        return $options;        
    }
    
    public function indexAction()
    {
        return new ViewModel(array(
            'students' => $this->getEntityManager()->getRepository('User\Entity\Student')->findAll() 
        ));        
    }

    public function registerAction()
    {
        // Build the form
        $form = new StudentForm();
        $form->get('submit')->setAttribute('label', 'Add');    
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $student = new Student();
            
            // Setup form filter and data
            $form->setInputFilter($student->getInputFilter());
            $form->setData($request->getPost());
            
            if($form->isValid())
            {
                var_dump('Yo!');
                $formData = $form->getData();
                $student->populate($formData);
                
                // Save
                $this->getEntityManager()->persist($student);
                $this->getEntityManager()->flush();
                
                // Redirect to list of albums
                return $this->redirect()->toRoute('student');                 
            }
        }        
        
        return array('form' => $form);
    }

    public function editAction()
    {
    }

    public function deleteAction()
    {
    }
    
    public function viewAction()
    {
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        return new ViewModel(array(
            'student' => $this->getEntityManager()->getRepository('User\Entity\Student')->find(array(
                'id' => $id
            )) 
        ));         
    }
}