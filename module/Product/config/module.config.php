<?php
namespace Product;

use Zend\Router\Http\Segment;
use Product\Controller\Factory;

return [

    // The following section is new and should be added to your file:
    'router' => [
        'routes' => [
            'product' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/product[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]*',
                    ],
                    'defaults' => [
                        'controller' => Controller\ProductController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            'product' => __DIR__ . '/../view',
            'product-stock' => __DIR__ . '/../view',
        ],
        'strategies' => [
            'ViewJsonStrategy',
        ],
    ],

    'controllers' => [
        'factories' => [
            Controller\ProductController::class => Controller\Factory\ProductControllerFactory::class,
        ],
    ],
];