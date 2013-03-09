<?php
namespace Admin\Controller;

use Admin\Controller\EntityActionController;
use Zend\View\Model\ViewModel;
use Admin\Form\SemesterOfferForm;

class SemesterController extends EntityActionController
{
    /* Protected methods */
    
    protected function getOfferArray()
    {
        $offers = $this->getEntityManager()->getRepository('Admin\Entity\Offer')->findAll();
        $offerArray = array();
        foreach($offers as $offer)
        {
            $offerArray[$offer->id] = $offer->subject->short_name . ' ' . $offer->code . ': ' . $offer->name;
        }
        
        return $offerArray;
    }
    
    protected function getSemesterArray()
    {
        $semesters  = $this->getEntityManager()->getRepository('Admin\Entity\Semester')->findAll();
        $semesterArray = array();
        foreach($semesters as $semester)
        {
            $semesterArray[$semester->id] = $semester->school_year . ' - ' . $semester->semester;
        }
        
        return $semesterArray;
    }
    
    /* Action methods */
    
    public function indexAction()
    {
        return new ViewModel(array(
            'semesters' => $this->getEntityManager()->getRepository('Admin\Entity\Semester')->findAll() 
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
            return $this->redirect()->toRoute('semester', array('action'=>'add'));
        } 
        
        return new ViewModel(array(
            'semester' => $this->getEntityManager()->getRepository('Admin\Entity\Semester')->find($id) 
        ));        
    }
    
    public function addofferAction()
    {
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        if(!$id)
        {
            return $this->redirect()->toRoute('semester', array('action'=>'index'));
        }        

        $form = new SemesterOfferForm();
        
        $semesters = $this->getSemesterArray();
        $form->get('semester_id')->setEmptyOption('(Select One)')
                                 ->setValueOptions($semesters)
                                 ->setValue($id);
        
        $offers = $this->getOfferArray();
        $currentSemester = $this->getEntityManager()->getRepository('Admin\Entity\Semester')->find($id);
        foreach($currentSemester->offers as $offer)
        {
            if(in_array($offer->id, array_keys($offers)))
            {
                unset($offers[$offer->id]);
            }
        }
        
        $form->get('offer_id')->setEmptyOption('(Select One)')
                              ->setValueOptions($offers);
        
        $request = $this->getRequest();
        if ($request->isPost()) 
        {
            // TODO: Create a save procedure
        }
        
        return array(
            'id' => $id,
            'form' => $form
        );        
    }
}