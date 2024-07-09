<?php
namespace Category\Model\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Category\Model\OsCategoryDescription;

class OsCategoryDescriptionTableFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $dbAdapter = $container->get('db2');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new OsCategoryDescription());
        $tableGateway = new TableGateway('oc_category_description', $dbAdapter, null, $resultSetPrototype);

        return new $requestedName($tableGateway);
    }
}