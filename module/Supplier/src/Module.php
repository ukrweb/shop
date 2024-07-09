<?php
namespace Supplier;

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
                Model\SupplierTable::class => function($container) {
                    $tableGateway = $container->get('SupplierTableGateway');
                    return new Model\SupplierTable($tableGateway);
                },
                'SupplierTableGateway' => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Supplier());
                    return new TableGateway('supplier', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }
}