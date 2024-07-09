<?php
namespace Category;

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
                Model\CategoryTable::class => function($container) {
                    $tableGateway = $container->get('CategoryTableGateway');
                    return new Model\CategoryTable($tableGateway);
                },
                'CategoryTableGateway' => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Category());
                    return new TableGateway('category', $dbAdapter, null, $resultSetPrototype);
                },
                Model\SupplierCategoryTable::class => function($container) {
                    $tableGateway = $container->get('SupplierCategoryTableGateway');
                    return new Model\SupplierCategoryTable($tableGateway);
                },
                'SupplierCategoryTableGateway' => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\SupplierCategory());
                    return new TableGateway('supplier_category', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }
}