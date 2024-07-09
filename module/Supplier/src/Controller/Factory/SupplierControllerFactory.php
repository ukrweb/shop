<?php

namespace Supplier\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Supplier\Model\SupplierTable;
use SupplierStock\Model\SupplierStockTable;
use Contragent\Model\ContragentTable;

class SupplierControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new $requestedName(
            $container->get(SupplierTable::class),
            $container->get(SupplierStockTable::class),
            $container->get(ContragentTable::class)
        );
    }
}