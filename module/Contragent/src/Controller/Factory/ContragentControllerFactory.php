<?php

namespace Contragent\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Contragent\Model\ContragentTable;

class ContragentControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new $requestedName(
            $container->get(ContragentTable::class)
        );
    }
}