<?php
namespace Category;

use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'category' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/category[/:action[/:category_id]]',
                    'constraints' => [
                        'action'      => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'category_id' => '[0-9]*',
                    ],
                    'defaults' => [
                        'controller' => Controller\CategoryController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'categories' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/categories[/:action[/:category_id][/:limit][/:search]]',
                    'constraints' => [
                        'action'      => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'category_id' => '[0-9]*',
                        'limit'       => '[0-9]*',
                    ],
                    'defaults' => [
                        'controller' => Controller\CategoryController::class,
                        'action'     => 'search',
                    ],
                ],
            ],
            'os-categories' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/os-categories[/:action[/:limit][/:search]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'limit'  => '[0-9]*',
                    ],
                    'defaults' => [
                        'controller' => Controller\CategoryController::class,
                        'action'     => 'os-categories-search',
                    ],
                ],
            ],
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            'category' => __DIR__ . '/../view',
        ],
        'strategies' => [
            'ViewJsonStrategy',
        ],
    ],

    'controllers' => [
        'factories' => [
            Controller\CategoryController::class => Controller\Factory\CategoryControllerFactory::class,
        ],
    ],

    'service_manager' => [
        'factories' => [
            Model\OsCategoryDescriptionTable::class => Model\Factory\OsCategoryDescriptionTableFactory::class,
        ],
    ],
];