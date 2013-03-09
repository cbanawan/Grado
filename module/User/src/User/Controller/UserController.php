<?php
namespace User\Controller;

use User\Controller\EntityActionController;
use Zend\View\Model\ViewModel;
use User\Form\UserForm;
use User\Entity\User;
use User\Entity\UserProfile;

class UserController extends EntityActionController
{
    public function indexAction()
    {
        return new ViewModel(array(
            'users' => $this->getEntityManager()->getRepository('User\Entity\User')->findAll() 
        ));
    }

    public function addAction()
    {
        // Build the form
        $form = new UserForm();
        $form->get('submit')->setAttribute('label', 'Add');

        // Process the request
        $request = $this->getRequest();
        if ($request->isPost()) {
            $user = new User();
            
            // Setup form filter and data
            $form->setInputFilter($user->getInputFilter());
            $form->setData($request->getPost());
            
            // Validate data
            if ($form->isValid()) { 
                $formData = $form->getData();
                
                // Populate the profile data
                $profile = new UserProfile();
                $profile->populate($formData['user_profile']);
                
                // Populate user data and set in profiles
                $user->populate($formData); 
                $profile->setUser($user);
                
                // Save
                $this->getEntityManager()->persist($profile);
                $this->getEntityManager()->flush();
                
                // Redirect to list of albums
                return $this->redirect()->toRoute('user'); 
            }
        }

        return array('form' => $form);
    }

    public function editAction()
    {
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        if (!$id) {
            return $this->redirect()->toRoute('user', array('action'=>'add'));
        } 
        $user = $this->getEntityManager()->find('User\Entity\User', $id);

        $form = new UserForm();
        $form->setBindOnValidate(false);
        $form->bind($album);
        $form->get('submit')->setAttribute('label', 'Edit');
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->post());
            if ($form->isValid()) {
                $form->bindValues();
                $this->getEntityManager()->flush();

                // Redirect to list of albums
                return $this->redirect()->toRoute('user');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    public function deleteAction()
    {
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        if (!$id) {
            return $this->redirect()->toRoute('user');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->post()->get('del', 'No');
            if ($del == 'Yes') {
                $id = (int)$request->post()->get('id');
                $user = $this->getEntityManager()->find('User\Entity\User', $id);
                if ($album) {
                    $this->getEntityManager()->remove($user);
                    $this->getEntityManager()->flush();
                }
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('default', array(
                'controller' => 'user',
                'action'     => 'index',
            ));
        }

        return array(
            'id' => $id,
            'user' => $this->getEntityManager()->find('User\Entity\User', $id)->getArrayCopy()
        );
    }
}