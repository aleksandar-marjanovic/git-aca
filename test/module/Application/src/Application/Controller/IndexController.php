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

use Application\Form\ContactForm;
use Application\Service\PhoneFilter;

use Zend\Filter\StringTrim;
use Zend\Filter\FilterChain;
use Zend\Filter\StaticFilter;

use Zend\Validator\EmailAddress;
use Zend\Validator\Hostname;
use Zend\Validator\ValidatorChain;
use Zend\Validator\CreditCard;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
    	// $request = $this->getRequest();
    	// print_r($getVar = $this->params());
        return new ViewModel();
    }

    public function aboutAction()
    {
    	$vm = new ViewModel();
    	$vm->setVariable("name", "aca");
    	return $vm;
    }

    public function contactUsAction()
    {
    	
    	$form = new ContactForm();

    	if($this->getRequest()->isPost()){
    		$data = $this->params()->fromPost();

    		$form->setData($data);

			if($form->isValid()) {
    			$data = $form->getData();
				return $this->redirect()->toRoute(
											'contactUsThankYou',
											array('controller'=>'index', 'action'=>'thankYou')
										);
			}else{
				/*print_r($form->getMessages());
				die("INVALID !!!");*/
			}

    		// print_r($data);die();
    	}

    	return [
    		'form' => $form
    	];

    }

    public function uploadAction(){
    	// var_dump(get_class_methods($this->getRequest()));
    	if($this->getRequest()->isPost()){
	    	$files = $this->params()->fromFiles();

	    	print_r($_FILES['myfile']);

    	}


    }

    public function thankYouAction(){

    }
}
