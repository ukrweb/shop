<?php

namespace SupplierStock\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use SupplierStock\Model\SupplierStockTable;
use Supplier\Model\SupplierTable;

class SupplierStockControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new $requestedName(
            $container->get(SupplierStockTable::class),
            $container->get(SupplierTable::class)
        );
    }
}