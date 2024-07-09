<?php
namespace Supplier;

use Zend\Router\Http\Segment;
use Supplier\Controller\Factory;

return [

    // The following section is new and should be added to your file:
    'router' => [
        'routes' => [
            'supplier' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/supplier[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]*',
                    ],
                    'defaults' => [
                        'controller' => Controller\SupplierController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            'supplier' => __DIR__ . '/../view',
            'supplier-stock' => __DIR__ . '/../view',
        ],
        'strategies' => [
            'ViewJsonStrategy',
        ],
    ],

    'controllers' => [
        'factories' => [
            Controller\SupplierController::class => Controller\Factory\SupplierControllerFactory::class,
        ],
    ],
];