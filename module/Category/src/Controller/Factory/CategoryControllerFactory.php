<?php
namespace Category\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Category\Model\{CategoryTable, SupplierCategoryTable, OsCategoryDescriptionTable};

class CategoryControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new $requestedName(
            $container->get(CategoryTable::class),
            $container->get(SupplierCategoryTable::class),
            $container->get(OsCategoryDescriptionTable::class)
        );
    }
}