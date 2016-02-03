<?php

namespace User\Model;

use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputInterface;

class User implements InputFilterAwareInterface{

    public $user_id;
    public $name;
    public $email;
    public $birth_date;
    public $address_id;
    public $address_1;
    public $address_2;
    public $city;
    public $post_code;
    public $telephone;

    protected $inputFilter;

    public function exchangeArray($data){
        $this->user_id     = (!empty($data['user_id'])) ? $data['user_id'] : null;
        $this->name        = (!empty($data['name'])) ? $data['name'] : null;
        $this->email       = (!empty($data['email'])) ? $data['email'] : null;
        $this->birth_date  = (!empty($data['birth_date'])) ? $data['birth_date'] : null;
        $this->address_id  = (!empty($data['address_id'])) ? $data['address_id'] : null;
        $this->address_1   = (!empty($data['address_1'])) ? $data['address_1'] : null;
        $this->address_2   = (!empty($data['address_2'])) ? $data['address_2'] : null;
        $this->city        = (!empty($data['city'])) ? $data['city'] : null;
        $this->post_code   = (!empty($data['post_code'])) ? $data['post_code'] : null;
        $this->telephone   = (!empty($data['telephone'])) ? $data['telephone'] : null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $inputFilter->add([
                'name'     => 'user_id',
                'required' => true,
                'filters'  => [
                    ['name' => 'Int'],
                ],
                'validators' => [
                    [
                        'name'    => 'Digits',
                    ],
                ],
            ]);

            $inputFilter->add([
                'name'     => 'name',
                'required' => true,
                'filters'  => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 80,
                        ],
                    ],
                ],
            ]);

            $inputFilter->add([
                'name'     => 'email',
                'required' => true,
                'filters'  => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ],
                    ],
                    [
                        'name' => 'EmailAddress',
                        'domain'   => 'true',
                        'hostname' => 'true',
                        'mx'       => 'true',
                        'deep'     => 'true',
                        'options' => [
                            'message'  => [
                                'email' => 'Invalid email address',
                            ],
                        ]
                    ],
                ],
            ]);
            $inputFilter->add([
                'name'     => 'birth_date',
                'required' => true,
                'filters'  => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    [
                        'name' => 'regex',
                        'options' => [
                            'pattern' => '/^\d{2}\-\d{2}\-\d{4}$/',
                            'message' => [
                                'regexNotMatch' => 'Birth data must be in format DD-MM-YYYY'
                            ]
                        ]
                    ],
                ],
            ]);
            $inputFilter->add([
                'name'     => 'address_1',
                'required' => true,
                'filters'  => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
                /*'validators' => [                    [                        'name' => 'regex',
                        'options' => [
                            'pattern' => '/^\d{2}\-\d{2}\-\d{4}$/',
                            'message' => [
                                'regexNotMatch' => 'Birth data must be in format DD-MM-YYYY'
                            ]
                        ]
                    ),
                ),*/
            ]);
            $inputFilter->add([
                'name'     => 'address_2',
                'required' => true,
                'filters'  => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
                /*'validators' => [                    [                        'name' => 'regex',
                        'options' => [
                            'pattern' => '/^\d{2}\-\d{2}\-\d{4}$/',
                            'message' => [
                                'regexNotMatch' => 'Birth data must be in format DD-MM-YYYY'
                            ]
                        ]
                    ),
                ),*/
            ]);
            $inputFilter->add([
                'name'     => 'city',
                'required' => true,
                'filters'  => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
                /*'validators' => [                    [                        'name' => 'regex',
                        'options' => [
                            'pattern' => '/^\d{2}\-\d{2}\-\d{4}$/',
                            'message' => [
                                'regexNotMatch' => 'Birth data must be in format DD-MM-YYYY'
                            ]
                        ]
                    ),
                ),*/
            ]);
            $inputFilter->add([
                'name'     => 'post_code',
                'required' => true,
                'filters'  => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    [
                        'name' => 'regex',
                        'options' => [
                            'pattern' => '/^\d+$/',
                            'message' => [
                                'regexNotMatch' => 'Post code can have only digits.'
                            ]
                        ]
                    ],
                ],
            ]);
            $inputFilter->add([
                'name'     => 'telephone',
                'required' => true,
                'filters'  => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    [
                        'name' => 'regex',
                        'options' => [
                            'pattern' => '/^\d+$/',
                            'message' => [
                                'regexNotMatch' => 'Telephone can have only digits.'
                            ]
                        ]
                    ],
                ],
            ]);
            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }
}