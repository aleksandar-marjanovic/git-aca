<?php

namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use \Zend\Captcha\Image;

/**
* This form is used to collect user feedback data like user E-mail,
* message subject and text.
*/
class ContactForm extends Form{

	public function __construct()
	{
		parent::__construct('contact-form');

		$this->setAttribute("method", "post")
			 ->setAttribute("action", "/contactUs");

		$this->addElement();

		$this->addInputFilter();
	}

	private function addElement(){
		// Add "email" field
		$this->add(array(
				'type' => 'text',
				'name' => 'email',
				'attributes' => array(
					'id' => 'body'
				),
				'options' => array(
					'label' => 'Your E-mail',
				),
			)
		);

		// Add "subject" field
		$this->add(array(
			'type' => 'text',
			'name' => 'subject',
			'attributes' => array(
				'id' => 'subject'
			),
			'options' => array(
				'label' => 'Subject',
			),
		));

		// Add "body" field
		$this->add(array(
			'type' => 'text',
			'name' => 'body',
			'attributes' => array(
				'id' => 'body'
			),
			'options' => array(
				'label' => 'Message Body',
			)
		));

		$this->add(array(
			'type' => 'csrf',
			'name' => 'csrf',
			'options' => array(
				'csrf_options' => array(
					'timeout' => 600
				)
			),
		));

		// Add the submit button
		$this->add(array(
			'type' => 'submit',
			'name' => 'submit',
			'attributes' => array(
				'value' => 'Submit',
			),
		));
	}

	private function addInputFilter(){
		$inputFilter = new InputFilter();
		$this->setInputFilter($inputFilter);

		$inputFilter->add(array(
				'name' => 'email',
				'required' => true,
				'filters' => array(
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					array(
						'name' => 'EmailAddress',
						'options' => array(
							'allow' => \Zend\Validator\Hostname::ALLOW_DNS,
							'useMxCheck' => false,
						),
					),
				),
			)
		);

		$inputFilter->add(array(
				'name' => 'subject',
				'required' => true,
				'filters' => array(
					array('name' => 'StringTrim'),
					array('name' => 'StripTags'),
					array('name' => 'StripNewLines'),
				),
				'validators' => array(
					array(
						'name' => 'StringLength',
						'options' => array(
							'min' => 1,
							'max' => 128
						),
					),
				),
			)
		);

		$inputFilter->add(array(
				'name' => 'body',
				'required' => true,
				'filters' => array(
					array('name' => 'StringTrim')
				),
				'validators' => array(
					array(
						'name' => 'StringLength',
						'options' => array(
							'min' => 1,
							'max' => 4096
						),
					),
				),
			)
		);
	}
}