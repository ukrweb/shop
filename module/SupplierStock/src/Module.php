<?php
namespace SupplierStock;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                Model\SupplierStockTable::class => function($container) {
                    $tableGateway = $container->get('SupplierStockTableGateway');
                    return new Model\SupplierStockTable($tableGateway);
                },
                'SupplierStockTableGateway' => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\SupplierStock());
                    return new TableGateway('supplier_stock', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }
}