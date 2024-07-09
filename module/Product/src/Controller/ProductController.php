<?php
namespace Product\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Product\Model\{Product, ProductTable};
use Product\Form\ProductForm;
use ProductStock\Model\{ProductStock, ProductStockTable};
use Contragent\Model\{Contragent, ContragentTable};

class ProductController extends AbstractActionController
{
    private $productTable;

    public function __construct(
        ProductTable $productTable 
    ) {
        $this->productTable = $productTable;
    }

    public function indexAction()
    {
        return new ViewModel([
            'products' => $this->productTable->getProducts(),
        ]);        
    }
}