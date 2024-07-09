<?php
namespace SupplierStock\Form;

use Zend\Form\Form;
use SupplierStock\Model\SupplierStock;

class SupplierStockForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('supplier_stock');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-horizontal');
        $this->setAttribute('role', 'form');
        $this->add([
            'name' => 'supplier_stock_id',
            'attributes' => [
                'type'   => 'hidden'
            ]
        ]);
        $this->add([
            'name' => 'supplier_id',
            'attributes' => [
                'type'   => 'hidden'
            ]
        ]);
        $this->add([
            'name' => 'stock_name',
            'attributes' => [
                'id'          => 'stock_name',
                'type'        => 'text',
                'class'       => 'form-control',
                'required'    => true,
                'placeholder' => 'Введите название склада'
            ],
            'options' => [
                'label' => 'Название склада * :',
            ]
        ]);
        $this->add([
            'name' => 'delivery_time',
            'attributes' => [
                'id'          => 'delivery_time',
                'type'        => 'text',
                'class'       => 'form-control',
                'placeholder' => 'Введите срок доставки товаров от поставщика'
            ],
            'options' => [
                'label' => 'Срок доставки товаров от поставщика:',
            ]
        ]);
        $this->add([
            'name' => 'margin_fix',
            'attributes' => [
                'id'          => 'margin_fix',
                'type'        => 'text',
                'class'       => 'form-control',
                'placeholder' => 'Введите наценку (фиксированная часть)'
            ],
            'options' => [
                'label' => 'Наценка (фиксированная часть):',
            ]
        ]);
        $this->add([
            'name' => 'margin_percent',
            'attributes' => [
                'id'          => 'margin_percent',
                'type'        => 'text',
                'class'       => 'form-control',
                'placeholder' => 'Введите наценку (процентная часть)'
            ],
            'options' => [
                'label' => 'Наценка (процентная часть):',
            ]
        ]);
        $this->add([
            'name'  => 'status',
            'type'  => 'select',
            'options' => [
                'label' => 'Статус склада:',
                'value_options' => SupplierStock::STATUS_VALUE,
            ],
            'attributes' => [
                'id'    => 'type',
                'class' => 'form-control',
            ]
        ]);
        $this->add([
            'name' => 'submit',
            'attributes' => [
                'id'    => 'submit',
                'type'  => 'submit',
                'class' => 'btn btn-primary',
                'value' => 'Сохранить',
            ]
        ]);
    }
}
