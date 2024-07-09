<?php
namespace SupplierStock\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class SupplierStockTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function getAllSupplierStocks($supplierId)
    {
        return $this->tableGateway->select(['supplier_id' => $supplierId]);
    }

    public function getSupplierStock(int $id)
    {
        $rowset = $this->tableGateway->select(['supplier_stock_id' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf('Could not find row with identifier %d', $id));
        }

        return $row;
    }

    public function saveSupplierStock(SupplierStock $supplierStock)
    {
        $data = [
            'supplier_id'    => $supplierStock->supplier_id,
            'stock_name'     => $supplierStock->stock_name     ? $supplierStock->stock_name     : '',
            'delivery_time'  => $supplierStock->delivery_time  ? $supplierStock->delivery_time  : 0,
            'margin_fix'     => $supplierStock->margin_fix     ? $supplierStock->margin_fix     : 0,
            'margin_percent' => $supplierStock->margin_percent ? $supplierStock->margin_percent : 0,
            'status'         => $supplierStock->status > -1    ? $supplierStock->status         : NULL,
        ];

        $id = (int) $supplierStock->supplier_stock_id;
        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        if (! $this->getSupplierStock($id)) {
            throw new RuntimeException(sprintf(
                'Cannot update supplier-stock with identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['supplier_stock_id' => $id]);
    }
}