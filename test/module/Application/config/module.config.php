<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            'about' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/about',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'about',
                    ),
                ),
            ),
            'user' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'may_terminate' => true,
                'options' => array(
                    'route'    => '/user/:username',
                    'constraints' => array(
                        'username' => '[a-zA-Z0-9_-]+'
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\User',
                        'action'     => 'index',
                    ),
                )
            ),
            'createUser' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'may_terminate' => true,
                'options' => array(
                    'route'    => '/user/create-user',
                    'defaults' => array(
                        'controller' => 'Application\Controller\User',
                        'action'     => 'createUser',
                    ),
                )
            ),
            'contactUs' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'may_terminate' => true,
                'options' => array(
                    'route'    => '/contactUs[/]',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'contactUs',
                    ),
                )
            ),
            'contactUsThankYou' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'may_terminate' => true,
                'options' => array(
                    'route'    => '/contactUs/thankYou',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'thankYou',
                    ),
                )
            ),
            'upload' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'may_terminate' => true,
                'options' => array(
                    'route'    => '/upload',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'upload',
                    ),
                )
            ),
            'blog' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/blogTests',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Blog',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'wildcard' => array(
                        'type' => 'Zend\Mvc\Router\Http\Wildcard',
                        'options' => array(
                            'key_value_delimiter' => '/',
                            'param_delimiter' => '/',
                            'defaults' => array(
                                'controller' => 'Application\Controller\Blog',
                                'action' => 'index'
                            ),
                        ),
                    ),
                ),
            ),
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'application' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/application',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'factories' => array(
            'translator' => 'Zend\Mvc\Service\TranslatorServiceFactory',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index' => Controller\IndexController::class,
            'Application\Controller\User' => Controller\UserController::class,
            'Application\Controller\Blog' => Controller\BlogController::class
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);
