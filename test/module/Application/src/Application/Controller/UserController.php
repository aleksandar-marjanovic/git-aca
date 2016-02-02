<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Barcode\Barcode;

class UserController extends AbstractActionController
{
    public function indexAction()
    {
        $username = $this->params()->fromRoute("username");


        $um = $this->getServiceLocator()->get('Application\Mapper\UserDataMapper');
        $user = $um->getUserById($username);
        if(empty($user)){

        }
        $user = reset($user);
        return [
            "name" => $user['firstname']
        ];

    }

    public function createUserAction(){
        $um = $this->getServiceLocator()->get('Application\Mapper\UserDataMapper');
        $um->createUser();
    }

    public function aboutAction()
    {
    	$vm = new ViewModel();
        $vm;
    	$vm->setVariable("name", "aca");
    	return $vm;
    }
}
