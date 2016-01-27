<?php

namespace Admin\Service\Initializer;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class EventManagerInitializer implements InitializerInterface{
    /**
     * Initialize
     *
     * @param $instance
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function initialize($instance, ServiceLocatorInterface $serviceLocator)
    {
        if($instance instanceof AbstractTableGateway){
            $instance->setDbAdapter($serviceLocator->get('db'));
        }
    }
}