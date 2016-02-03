<?php

namespace User\Service\Initializer;

use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\Db\TableGateway\AbstractTableGateway;

class MapperInitializer implements InitializerInterface{

    public function initialize($instance, ServiceLocatorInterface $serviceLocator){
        if ($instance instanceof AbstractTableGateway) {
            $instance->setDbAdapter($serviceLocator->get('db'));
        }
    }
}