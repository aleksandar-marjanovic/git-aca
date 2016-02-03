<?php

namespace User\Model;

use User\Mapper\UserMapper;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class FilterVal implements InputFilterAwareInterface
{

    protected $inputFilter;
    protected $userMapper;

    public function __construct(UserMapper $userMapper)
    {
        $this->userMapper = $userMapper;
    }

    /**
     * Set input filter
     *
     * @param  InputFilterInterface $inputFilter
     * @return InputFilterAwareInterface
     */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    /**
     * Retrieve input filter
     *
     * @return InputFilterInterface
     */
    public function getInputFilter()
    {
        if(!$this->inputFilter){
            $inputFilter = new InputFilter();

            $inputFilter->add([
                'name'       => 'username',
                'required'   => true,
                'filters'    => [
                    ['name' => 'StringTrim'],
                    ['name' => 'StripNewLines'],
                ],
                'validators' => [
                    [
                        'name'    => 'regex',
                        'options' => [
                            'pattern' => '/^\w+$/',
                            'message' => 'Alphanumeric characters only.'
                        ],
                    ],
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => 5,
                            'max'      => 100,
                            'message'  => 'Username must be between 5 and 100 characters.'
                        ],
                    ],
                    [
                        'name'    => 'DBNoRecordExists',
                        'options' => [
                            'adapter' => $this->userMapper->getAdapter(),
                            'table'   => 'users',
                            'field'   => 'name',
                            'message' => 'Username already taken.'
                        ],
                    ],
                ],
            ]);
            $inputFilter->add([
                'name'       => 'email',
                'required'   => true,
                'filters'    => [
                    ['name' => 'StringTrim'],
                    ['name' => 'StripNewLines'],
                ],
                'validators' => [
                    [
                        'name'    => 'EmailAddress',
                        'options' => [
                            'message' => 'Invalid email address.'
                        ]
                    ],
                ],
            ]);

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}