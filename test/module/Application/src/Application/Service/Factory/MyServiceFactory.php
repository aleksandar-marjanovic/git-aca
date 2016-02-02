<?php

namespace Application\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Application\Service\MyService;

class MyServiceFactory implements FactoryInterface{

    public function createService(ServiceLocatorInterface $serviceLocator){
        $dependencyService = $serviceLocator->get('ServiceOne');
        $translator = $serviceLocator->get('Translator');

        return new MyService($dependencyService, $translator);
    }
}