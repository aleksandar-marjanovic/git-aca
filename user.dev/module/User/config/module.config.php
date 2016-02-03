<?php

namespace User;

return [
    'router' => [
        'routes' => [
            'user' => [
                'type' => 'segment',
                'options' => [
                    'route'    => '/[:action][/:id]',
                    'defaults' => [
                        'controller' => 'User\Controller\Index',
                        'action'     => 'index',
                    ],
                ],
            ]
        ]
    ],
    'service_manager' => [
        'invokables' => [
            'User\Mapper\UserMapper'    => 'User\Mapper\UserMapper',
            'User\Mapper\AddressMapper' => 'User\Mapper\AddressMapper',
            'User\Mapper\UserAddressesMapper' => 'User\Mapper\UserAddressesMapper',
        ]
    ],
    'controllers' => [
        'factories' => [
            'User\Controller\Index' => 'User\Factory\IndexControllerFactory'
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];