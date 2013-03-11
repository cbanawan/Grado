<?php
namespace Admin\Controller;

use Admin\Controller\EntityActionController;
use Zend\View\Model\ViewModel;

class SubjectController extends EntityActionController
{
    /* Action methods */
    
    public function indexAction()
    {
        return new ViewModel(array(
            'subjects' => $this->getEntityManager()->getRepository('Admin\Entity\Subject')->findAll() 
        ));
    }
    
    public function addAction()
    {
    }
    
    public function editAction()
    {
    }
    
    public function viewAction()
    {
        // Process id parameter
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        if (!$id) {
            return $this->redirect()->toRoute('subject', array('action'=>'add'));
        } 
        
        return new ViewModel(array(
            'subject' => $this->getEntityManager()->getRepository('Admin\Entity\Subject')->find($id) 
        ));        
    }
}