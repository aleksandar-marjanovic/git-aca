<?php

return [
    'controllers' => [
        'invokables' => [
            'Admin\Controller\Index' => 'Admin\Controller\IndexController'
        ]
    ],
    'service_manager' => [
        'invokables' => [
            'Admin\Mapper\AdminDataMapper' => 'Admin\Mapper\AdminDataMapper',
        ],
        'initializers' => [
            'Admin\Service\Initializer\EventManagerInitializer' => 'Admin\Service\Initializer\EventManagerInitializer'
        ]
    ],
    'router' => [
        'routes' => [
            'admin' => [
                'type' => 'literal',
                'options' => [
                    'route' => '/admin',
                    'defaults' => [
                        'controller' => 'Admin\Controller\Index',
                        'action'     => 'index'
                    ]
                ]
            ]
        ]
    ],
    'view_manager' => array(
        'template_path_stack' => array(
            'album' => __DIR__ . '/../view',
        ),
    ),
];