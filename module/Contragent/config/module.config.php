<?php
namespace Contragent;

use Zend\Router\Http\Segment;

return [

    // The following section is new and should be added to your file:
    'router' => [
        'routes' => [
            'contragent' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/contragent[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]*',
                    ],
                    'defaults' => [
                        'controller' => Controller\ContragentController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'is-contragent' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/is-contragent[/:action[/:hid]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'hid'    => '[a-zA-Z0-9]*',
                    ],
                    'defaults' => [
                        'controller' => Controller\ContragentController::class,
                        'action'     => 'check',
                    ],
                ],
            ],
            'contragents' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/contragents[/:action[/:limit][/:search]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'limit'  => '[0-9]*',
                    ],
                    'defaults' => [
                        'controller' => Controller\ContragentController::class,
                        'action'     => 'search',
                    ],
                ],
            ],
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            'contragent' => __DIR__ . '/../view',
        ],
        'strategies' => [
            'ViewJsonStrategy',
        ],
    ],

    'controllers' => [
        'factories' => [
            Controller\ContragentController::class => Controller\Factory\ContragentControllerFactory::class,
        ],
    ],
];