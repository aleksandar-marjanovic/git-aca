<?php

return array(
    'service_manager' => array(
        'invokables' => array(
            'Blog\Service\PostServiceInterface' => 'Blog\Service\PostService'
        )
    ),
    'controllers'  => array(
        'factories' => array(
            'Blog\Controller\List' => 'Blog\Factory\ListControllerFactory'
        )
    ),
    // This lines opens the configuration for the RouteManager
    'router' => array(
        // Open configuration for all possible routes
        'routes' => array(
            'post' => array(
                'type' => 'literal',
                'options' => array(
                    'route'    => '/blog',
                    'defaults' => array(
                        'controller' => 'Blog\Controller\List',
                        'action'     => 'index',
                    )
                )
            )
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'blog' => __DIR__ . '/../view',
        ),
    ),
);