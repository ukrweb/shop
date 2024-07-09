<?php
namespace Supplier\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Supplier\Model\{Supplier, SupplierTable};
use Supplier\Form\SupplierForm;
use SupplierStock\Model\{SupplierStock, SupplierStockTable};
use Contragent\Model\{Contragent, ContragentTable};

class SupplierController extends AbstractActionController
{
    private $supplierTable;
    private $supplierStockTable;
    private $contragentTable;

    public function __construct(
        SupplierTable $supplierTable, 
        SupplierStockTable $supplierStockTable,
        ContragentTable $contragentTable
    ) {
        $this->supplierTable      = $supplierTable;
        $this->supplierStockTable = $supplierStockTable;
        $this->contragentTable    = $contragentTable;
    }

    public function indexAction()
    {
        return new ViewModel([
            'statusValue' => Supplier::STATUS_VALUE,
            'suppliers'   => $this->supplierTable->fetchAll(),
        ]);        
    }

    public function addAction()
    {
        $form = new SupplierForm();
        $form->get('default_contragent_id')->setValueOptions($this->contragentTable->defaultContragentOptions(false));
        $form->get('submit')->setValue('Добавить');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $supplier = new Supplier();
            $form->get('default_contragent_id')->setValueOptions(
                $this->contragentTable->defaultContragentOptions($request->getPost('default_contragent_id'))
            );
            $form->setInputFilter($supplier->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $supplier->exchangeArray($form->getData());
                $this->supplierTable->saveSupplier($supplier);

                // Redirect to list of suppliers
                return $this->redirect()->toRoute('supplier');
            }
        }
        return ['form' => $form];
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('supplier');
        }
        $supplier = $this->supplierTable->getSupplier($id);

        $form  = new SupplierForm();
        $form->get('default_contragent_id')->setValueOptions(
            $this->contragentTable->defaultContragentOptions($supplier->default_contragent_id)
        );
        $form->get('submit')->setValue('Сохранить');
        $form->bind($supplier);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->get('default_contragent_id')->setValueOptions(
                $this->contragentTable->defaultContragentOptions($request->getPost('default_contragent_id'))
            );
            $form->setInputFilter($supplier->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->supplierTable->saveSupplier($form->getData());

                // Redirect to list of suppliers
                return $this->redirect()->toRoute('supplier');
            }
        }

        return [
            'id'             => $id,
            'supplierName'   => $supplier->supplier_name,
            'form'           => $form,
            'statusValue'    => SupplierStock::STATUS_VALUE,
            'supplierStocks' => $this->supplierStockTable->getAllSupplierStocks($id),
        ];
    }
}