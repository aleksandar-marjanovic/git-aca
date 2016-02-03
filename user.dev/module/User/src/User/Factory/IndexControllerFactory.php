<?php

namespace User\Factory;

use User\Controller\IndexController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class IndexControllerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $realServiceLocator  = $serviceLocator->getServiceLocator();
        $userMapper          = $realServiceLocator->get('User\Mapper\UserMapper');
        $addressMapper       = $realServiceLocator->get('User\Mapper\AddressMapper');
        $userAddressesMapper = $realServiceLocator->get('User\Mapper\UserAddressesMapper');

        return new IndexController($userMapper, $addressMapper, $userAddressesMapper);
    }

}