<?php
namespace Category\Form;

use Zend\Form\Form;
use Category\Model\Category;

class CategoryForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('category');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-horizontal');
        $this->setAttribute('role', 'form');
        $this->add([
            'name' => 'category_id',
            'attributes' => [
                'id'   => 'category_id',
                'type' => 'hidden'
            ]
        ]);
        $this->add([
            'name' => 'category_name',
            'attributes' => [
                'id'       => 'category_name',
                'type'     => 'text',
                'required' => true,
                'class'    => 'form-control',
            ],
            'options' => [
                'label' => 'Название категории * :',
            ]
        ]);
        $this->add([
            'name'  => 'category_parent_id',
            'type'  => 'select',
            'options' => [
                'label'                     => 'Родительская категория:',
                'disable_inarray_validator' => true,
            ],
            'attributes' => [
                'required' => false,
                'id'    => 'category_parent_id',
                'class' => 'form-control',
            ]
        ]);
        $this->add([
            'name'  => 'oc_category_id',
            'type'  => 'select',
            'options' => [
                'label'                     => 'Привязанная категория OC2:',
                'disable_inarray_validator' => true,
            ],
            'attributes' => [
                'id'    => 'oc_category_id',
                'class' => 'form-control',
            ]
        ]);
        $this->add([
            'name'  => 'category_enable',
            'type'  => 'select',
            'options' => [
                'label' => 'Отображение на сайте:',
                'value_options' => Category::CATEGORY_ENABLE_VALUE,
            ],
            'attributes' => [
                'id'    => 'category_enable',
                'class' => 'form-control',
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
                'label' => 'Статус категории:',
                'value_options' => Category::STATUS_VALUE,
            ],
            'attributes' => [
                'id'    => 'status',
                'class' => 'form-control',
            ]
        ]);
        $this->add([
            'name'  => 'supplier_category',
            'type'  => 'select',
            'options' => [
                'label'                     => 'Привязать к категории:',
                'disable_inarray_validator' => true,
            ],
            'attributes' => [
                'id'    => 'supplier_category',
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
