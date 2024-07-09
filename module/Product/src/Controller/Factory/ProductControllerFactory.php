<?php

namespace Product\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Product\Model\ProductTable;
use ProductStock\Model\ProductStockTable;
use Contragent\Model\ContragentTable;

class ProductControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new $requestedName(
            $container->get(ProductTable::class)
        );
    }
}