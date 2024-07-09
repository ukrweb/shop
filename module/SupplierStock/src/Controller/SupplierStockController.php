<?php
namespace SupplierStock\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use SupplierStock\Model\{SupplierStock, SupplierStockTable};
use SupplierStock\Form\SupplierStockForm;
use Supplier\Model\SupplierTable;

class SupplierStockController extends AbstractActionController
{
    private $supplierStockTable;
    private $supplierTable;

    public function __construct(SupplierStockTable $supplierStockTable, SupplierTable $supplierTable)
    {
        $this->supplierStockTable = $supplierStockTable;
        $this->supplierTable      = $supplierTable;
    }

    public function addAction()
    {
        $supplierId = (int) $this->params()->fromRoute('supplier_id', 0);
        if (!$supplierId) {
            return $this->redirect()->toRoute('supplier');
        }
        $supplier = $this->supplierTable->getSupplier($supplierId);

        $form = new SupplierStockForm();
        $form->get('submit')->setValue('Добавить');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $supplierStock = new SupplierStock();
            $form->setInputFilter($supplierStock->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $supplierStock->exchangeArray($form->getData());
                $this->supplierStockTable->saveSupplierStock($supplierStock);

                // Redirect to list of supplier
                return $this->redirect()->toRoute('supplier', ['action' => 'edit', 'id' => $supplierId]);
            }
        }

        return [
            'supplier_id'   => $supplierId,
            'supplier_name' => $supplier->supplier_name,
            'form'          => $form
        ];
    }

    public function editAction()
    {
        $supplierId = (int) $this->params()->fromRoute('supplier_id', 0);
        $id         = (int) $this->params()->fromRoute('id', 0);
        if (!$supplierId || !$id) {
            return $this->redirect()->toRoute('supplier');
        }
        $supplier = $this->supplierTable->getSupplier($supplierId);
        $supplierStock = $this->supplierStockTable->getSupplierStock($id);

        $form  = new SupplierStockForm();
        $form->get('submit')->setValue('Сохранить');
        $form->bind($supplierStock);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($supplierStock->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->supplierStockTable->saveSupplierStock($form->getData());

                // Redirect to list of supplier
                return $this->redirect()->toRoute('supplier', ['action' => 'edit', 'id' => $supplierId]);
            }
        }

        return [
            'supplier_id'   => $supplierId,
            'supplier_name' => $supplier->supplier_name,
            'id'            => $id,
            'form'          => $form,
            'stockName'     => $supplierStock->stock_name,
        ];
    }
}