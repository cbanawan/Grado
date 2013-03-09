<?php
namespace Admin\Controller;

use Admin\Controller\EntityActionController;
use Zend\View\Model\ViewModel;
use Admin\Form\CountryForm; 
use Admin\Entity\Country;

class CountryController extends EntityActionController
{
    public function indexAction()
    {
        return new ViewModel(array(
            'countries' => $this->getEntityManager()->getRepository('Admin\Entity\Country')->findAll() 
        ));           
    }
    
    public function addAction()
    {
        // Build the form
        $form = new CountryForm();
        $form->get('submit')->setAttribute('label', 'Add');      
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $country = new Country();
            
            // Setup form filter and data
            $form->setInputFilter($country->getInputFilter());
            $form->setData($request->getPost());
            
            // Validate data
            if ($form->isValid()) { 
                $formData = $form->getData();
                $country->populate($formData);
                
                // Save
                $this->getEntityManager()->persist($country);
                $this->getEntityManager()->flush();
                
                // Redirect to list of albums
                return $this->redirect()->toRoute('country'); 
            }
        }        
        
        return array('form' => $form);
    }
    
    public function editAction()
    {
        // Process id parameter
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        if (!$id) {
            return $this->redirect()->toRoute('country', array('action'=>'add'));
        } 
        
        // Get the country object
        $country = $this->getEntityManager()->find('Admin\Entity\Country', $id);

        // Bind to form to set default values
        $form = new CountryForm();
        $form->setBindOnValidate(false);
        $form->bind($country);
        
        // Set the label for the submit button
        $form->get('submit')->setAttribute('label', 'Edit');
        
        // Process request
        $request = $this->getRequest();
        if ($request->isPost()) 
        {
            // Validate data
            $form->setData($request->getPost());
            if ($form->isValid()) {
                // Bind values and save
                $form->bindValues();
                $this->getEntityManager()->flush();

                // Redirect to list of albums
                return $this->redirect()->toRoute('country');
            }
        }

        // Send to view
        return array(
            'id' => $id,
            'form' => $form,
        );        
    }
    
    public function viewAction()
    {
        // Process id parameter
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        if (!$id) {
            return $this->redirect()->toRoute('country', array('action'=>'add'));
        } 
        
        return new ViewModel(array(
            'country' => $this->getEntityManager()->getRepository('Admin\Entity\Country')->find($id) 
        ));          
    }
}