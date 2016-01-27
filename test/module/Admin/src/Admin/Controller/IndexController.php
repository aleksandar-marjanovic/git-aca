<?php

namespace Admin\Controller;

//use Exceptionon;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController{

    public function indexAction()
    {
        $db = $this->getServiceLocator()->get('Admin\Mapper\AdminDataMapper');

        try{
            print_r($db->getUserById(2));
        }catch(\Exception $e){
            print_r($e->getMessage());
        }
    }
}