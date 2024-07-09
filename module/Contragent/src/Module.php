<?php
namespace Contragent;

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
                Model\ContragentTable::class => function($container) {
                    $tableGateway = $container->get('ContragentTableGateway');
                    return new Model\ContragentTable($tableGateway);
                },
                'ContragentTableGateway' => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Contragent());
                    return new TableGateway('contragent', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }
}