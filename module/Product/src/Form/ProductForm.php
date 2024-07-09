<?php
namespace Supplier\Form;

use Zend\Form\Form;
use Supplier\Model\Supplier;

class SupplierForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('product');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-horizontal');
        $this->setAttribute('role', 'form');
        $this->add([
            'name' => 'product_id',
            'attributes' => [
                'type'   => 'hidden'
            ]
        ]);
        $this->add([
            'name' => 'product_name',
            'attributes' => [
                'id'          => 'product_name',
                'type'        => 'text',
                'class'       => 'form-control',
                'required'    => true,
                'placeholder' => 'Введите название поставщика'
            ],
            'options' => [
                'label' => 'Название поставщика * :',
            ]
        ]);
        $this->add([
            'name' => 'comment',
            'attributes' => [
                'id'          => 'comment',
                'type'        => 'textarea',
                'class'       => 'form-control',
                'rows'        => 3,
                'placeholder' => 'Введите комментарий'
            ],
            'options' => [
                'label' => 'Комментарий:',
            ]
        ]);
        $this->add([
            'name' => 'product_delivery_time',
            'attributes' => [
                'id'          => 'product_delivery_time',
                'type'        => 'text',
                'class'       => 'form-control',
                'placeholder' => 'Введите срок доставки товаров от поставщика'
            ],
            'options' => [
                'label' => 'Срок доставки товаров от поставщика:',
            ]
        ]);
        $this->add([
            'name' => 'email',
            'attributes' => [
                'id'          => 'email',
                'type'        => 'email',
                'class'       => 'form-control',
                'placeholder' => 'Введите адрес электронной почты'
            ],
            'options' => [
                'label' => 'Адрес электронной почты:',
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
            'name'  => 'default_contragent_id',
            'type'  => 'select',
            'options' => [
                'label' => 'Контрагент по умолчанию:',
                'disable_inarray_validator' => true,
            ],
            'attributes' => [
                'id'    => 'default_contragent_id',
                'class' => 'form-control',
            ]
        ]);
        $this->add([
            'name'  => 'status',
            'type'  => 'select',
            'options' => [
                'label' => 'Статус поставщика:',
                'value_options' => Supplier::STATUS_VALUE,
            ],
            'attributes' => [
                'id'    => 'status',
                'class' => 'form-control',
            ]
        ]);
        $this->add([
            'name' => 'product_update_interval',
            'attributes' => [
                'id'          => 'product_update_interval',
                'type'        => 'text',
                'class'       => 'form-control',
                'placeholder' => 'Введите интервал обновления'
            ],
            'options' => [
                'label' => 'Интервал обновления:',
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
