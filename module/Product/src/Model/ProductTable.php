<?php
namespace Product\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class ProductTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        return $this->tableGateway->select();
    }
    
    public function getProducts()
    {
        $dbAdapter = $this->tableGateway->getAdapter();
        $query = "SELECT * FROM `product` AS p LEFT JOIN `category` AS c
            ON p.category_id = c.category_id
            LIMIT 1000";
        
        return iterator_to_array($dbAdapter->query($query)->execute());
    }

    public function getProduct(int $id)
    {
        $rowset = $this->tableGateway->select(['product_id' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf('Could not find row with identifier %d', $id));
        }

        return $row;
    }
}