<?php
namespace Admin\Controller;

use Admin\Controller\EntityActionController;
use Zend\View\Model\ViewModel;
use Admin\Form\ProvinceForm; 
use Admin\Entity\Province;
use Admin\Entity\Country;

class ProvinceController extends EntityActionController
{
    protected $countries = array();

    /* Protected methods */
    
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
            'provinces' => $this->getEntityManager()->getRepository('Admin\Entity\Province')->findAll() 
        ));           
    }
    
    public function addAction()
    {
        // Build the form
        $form = new ProvinceForm();
        $form->get('submit')->setAttribute('label', 'Add'); 
        
        $form->get('country_id')->setValueOptions($this->getCountryArray());
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        if($id)
        {
            $form->get('country_id')->setValue($id);
        }
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $province = new Province();
            
            // Setup form filter and data
            $form->setInputFilter($province->getInputFilter());
            $form->setData($request->getPost());
            
            // Validate data
            if ($form->isValid()) { 
                $formData = $form->getData();
                $province->populate($formData);
                
                $country = $this->getEntityManager()->getRepository('Admin\Entity\Country')->find($request->getPost('country_id'));
                $province->setCountry($country);
                
                // Save
                $this->getEntityManager()->persist($province);
                $this->getEntityManager()->flush();
                
                // Redirect to list of albums
                return $this->redirect()->toRoute('province'); 
            }
        }        
        
        return array(
            'id' => $id,
            'form' => $form
        );
    }
    
    public function editAction()
    {
        // Process id parameter
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        if (!$id) {
            return $this->redirect()->toRoute('country', array('action'=>'add'));
        } 
        
        // Get the country object
        $province = $this->getEntityManager()->find('Admin\Entity\Province', $id);
        
        // Bind to form to set default values
        $form = new ProvinceForm();
        $form->setBindOnValidate(false);
        $form->bind($province);

        $form->get('country_id')->setValueOptions($this->getCountryArray());
        $form->get('country_id')->setValue($province->country->id);
        
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
                return $this->redirect()->toRoute('province');
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
            return $this->redirect()->toRoute('province', array('action'=>'add'));
        } 
        
        return new ViewModel(array(
            'province' => $this->getEntityManager()->getRepository('Admin\Entity\Province')->find($id) 
        ));          
    }
}