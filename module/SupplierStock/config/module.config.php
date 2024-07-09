<?php
namespace SupplierStock;

use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'supplier-stock' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/supplier-stock/[:action[/:supplier_id][/:id]]',
                    'constraints' => [
                        'action'      => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'supplier_id' => '[0-9]*',
                        'id'          => '[0-9]*',
                    ],
                    'defaults' => [
                        'controller' => Controller\SupplierStockController::class,
                        'action'     => 'add',
                    ],
                ],
            ],
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            'supplier-stock' => __DIR__ . '/../view',
        ],
    ],

    'controllers' => [
        'factories' => [
            Controller\SupplierStockController::class => Controller\Factory\SupplierStockControllerFactory::class,
        ],
    ],
];