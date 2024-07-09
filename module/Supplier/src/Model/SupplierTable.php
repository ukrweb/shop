<?php
namespace Supplier\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class SupplierTable
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

    public function getSupplier(int $id)
    {
        $rowset = $this->tableGateway->select(['supplier_id' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf('Could not find row with identifier %d', $id));
        }

        return $row;
    }

    public function saveSupplier($supplier)
    {
        $data = [
            'supplier_name'            => $supplier->supplier_name,
            'comment'                  => $supplier->comment                    ? $supplier->comment                  : '',
            'supplier_delivery_time'   => $supplier->supplier_delivery_time     ? $supplier->supplier_delivery_time   : 0,
            'email'                    => $supplier->email                      ? $supplier->email                    : '',
            'margin_fix'               => $supplier->margin_fix                 ? $supplier->margin_fix               : 0.0,
            'margin_percent'           => $supplier->margin_percent             ? $supplier->margin_percent           : 0.0,
            'default_contragent_id'    => $supplier->default_contragent_id > -1 ? $supplier->default_contragent_id    : NULL,
            'status'                   => $supplier->status > -1                ? $supplier->status                   : NULL,
            'supplier_update_interval' => $supplier->supplier_update_interval   ? $supplier->supplier_update_interval : 0,
        ];

        $id = (int) $supplier->supplier_id;
        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        if (! $this->getSupplier($id)) {
            throw new RuntimeException(sprintf(
                'Cannot update supplier with identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['supplier_id' => $id]);
    }
}