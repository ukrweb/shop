<?php
namespace Contragent\Form;

use Zend\Form\Form;
use Contragent\Model\Contragent;

class ContragentForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('contragent');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-horizontal');
        $this->setAttribute('role', 'form');
        $this->add([
            'name' => 'id',
            'attributes' => [
                'type'   => 'hidden'
            ]
        ]);
        $this->add([
            'name' => 'value',
            'attributes' => [
                'id'       => 'value',
                'type'     => 'text',
                'class'    => 'form-control',
                'required' => true,
            ],
            'options' => [
                'label' => 'Наименование компании * :',
            ]
        ]);
        $this->add([
            'name' => 'unrestricted_value',
            'attributes' => [
                'id'    => 'unrestricted_value',
                'type'  => 'text',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Наименование компании:',
            ]
        ]);
        $this->add([
            'name' => 'data_address_value',
            'attributes' => [
                'id'    => 'data_address_value',
                'type'  => 'text',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Адрес одной строкой:',
            ]
        ]);
        $this->add([
            'name' => 'data_address_unrestricted_value',
            'attributes' => [
                'id'    => 'data_address_unrestricted_value',
                'type'  => 'text',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Адрес одной строкой (полный, от региона):',
            ]
        ]);
        $this->add([
            'name' => 'data_address_data_source',
            'attributes' => [
                'id'    => 'data_address_data_source',
                'type'  => 'text',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Адрес одной строкой как в ЕГРЮЛ:',
            ]
        ]);
        $this->add([
            'name'  => 'data_address_data_qc',
            'type'  => 'select',
            'options' => [
                'label' => 'Код проверки адреса:',
                'value_options' => Contragent::ADDRESS_DATA_QC_VALUE,
            ],
            'attributes' => [
                'id'    => 'data_address_data_qc',
                'class' => 'form-control',
            ]
        ]);
        $this->add([
            'name' => 'data_branch_count',
            'attributes' => [
                'id'    => 'data_branch_count',
                'type'  => 'text',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Количество филиалов:',
            ]
        ]);
        $this->add([
            'name'  => 'data_branch_type',
            'type'  => 'select',
            'options' => [
                'label' => 'Тип подразделения:',
                'value_options' => Contragent::BRANCH_COUNT_VALUE,
            ],
            'attributes' => [
                'id'    => 'data_branch_type',
                'class' => 'form-control',
            ]
        ]);
        $this->add([
            'name' => 'data_inn',
            'attributes' => [
                'id'       => 'data_inn',
                'type'     => 'text',
                'class'    => 'form-control',
            ],
            'options' => [
                'label' => 'ИНН:',
            ]
        ]);
        $this->add([
            'name' => 'data_kpp',
            'attributes' => [
                'id'       => 'data_kpp',
                'type'     => 'text',
                'class'    => 'form-control',
            ],
            'options' => [
                'label' => 'КПП:',
            ]
        ]);
        $this->add([
            'name' => 'data_ogrn',
            'attributes' => [
                'id'    => 'data_ogrn',
                'type'  => 'text',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'ОГРН:',
            ]
        ]);
        $this->add([
            'name' => 'data_ogrn_date',
            'attributes' => [
                'id'    => 'data_ogrn_date',
                'type'  => 'text',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Дата выдачи ОГРН:',
            ]
        ]);
        $this->add([
            'name' => 'data_hid',
            'attributes' => [
                'id'       => 'data_hid',
                'type'     => 'text',
                'class'    => 'form-control',
            ],
            'options' => [
                'label' => 'Уникальный идентификатор в Дадате:',
            ]
        ]);
        $this->add([
            'name' => 'data_management_name',
            'attributes' => [
                'id'    => 'data_management_name',
                'type'  => 'text',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'ФИО руководителя:',
            ]
        ]);
        $this->add([
            'name' => 'data_management_post',
            'attributes' => [
                'id'    => 'data_management_post',
                'type'  => 'text',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Должность руководителя:',
            ]
        ]);
        $this->add([
            'name' => 'data_name_full_with_opf',
            'attributes' => [
                'id'    => 'data_name_full_with_opf',
                'type'  => 'text',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Полное наименование с ОПФ:',
            ]
        ]);
        $this->add([
            'name' => 'data_name_short_with_opf',
            'attributes' => [
                'id'    => 'data_name_short_with_opf',
                'type'  => 'text',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Краткое наименование с ОПФ:',
            ]
        ]);
        $this->add([
            'name' => 'data_name_latin',
            'attributes' => [
                'id'    => 'data_name_latin',
                'type'  => 'text',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Наименование на латинице:',
            ]
        ]);
        $this->add([
            'name' => 'data_name_full',
            'attributes' => [
                'id'    => 'data_name_full',
                'type'  => 'text',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Полное наименование:',
            ]
        ]);
        $this->add([
            'name' => 'data_name_short',
            'attributes' => [
                'id'    => 'data_name_short',
                'type'  => 'text',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Краткое наименование:',
            ]
        ]);
        $this->add([
            'name' => 'data_okpo',
            'attributes' => [
                'id'    => 'data_okpo',
                'type'  => 'text',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Код ОКПО:',
            ]
        ]);
        $this->add([
            'name' => 'data_okved',
            'attributes' => [
                'id'    => 'data_okved',
                'type'  => 'text',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Код ОКВЭД:',
            ]
        ]);
        $this->add([
            'name' => 'data_okved_type',
            'attributes' => [
                'id'    => 'data_okved_type',
                'type'  => 'text',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Версия справочника ОКВЭД (2001 или 2014):',
            ]
        ]);
        $this->add([
            'name' => 'data_opf_code',
            'attributes' => [
                'id'    => 'data_opf_code',
                'type'  => 'text',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Код ОКОПФ:',
            ]
        ]);
        $this->add([
            'name' => 'data_opf_full',
            'attributes' => [
                'id'    => 'data_opf_full',
                'type'  => 'text',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Полное название ОПФ:',
            ]
        ]);
        $this->add([
            'name' => 'data_opf_short',
            'attributes' => [
                'id'    => 'data_opf_short',
                'type'  => 'text',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Краткое название ОПФ:',
            ]
        ]);
        $this->add([
            'name' => 'data_opf_type',
            'attributes' => [
                'id'    => 'data_opf_type',
                'type'  => 'text',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Версия справочника ОКОПФ (99, 2012 или 2014):',
            ]
        ]);
        $this->add([
            'name' => 'data_state_actuality_date',
            'attributes' => [
                'id'    => 'data_state_actuality_date',
                'type'  => 'text',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Дата актуальности сведений:',
            ]
        ]);
        $this->add([
            'name' => 'data_state_registration_date',
            'attributes' => [
                'id'    => 'data_state_registration_date',
                'type'  => 'text',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Дата регистрации:',
            ]
        ]);
        $this->add([
            'name' => 'data_state_liquidation_date',
            'attributes' => [
                'id'    => 'data_state_liquidation_date',
                'type'  => 'text',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Дата ликвидации:',
            ]
        ]);
        $this->add([
            'name'  => 'data_state_status',
            'type'  => 'select',
            'options' => [
                'label' => 'Статус организации:',
                'value_options' => Contragent::STATE_STATUS_VALUE,
            ],
            'attributes' => [
                'id'    => 'data_state_status',
                'class' => 'form-control',
            ]
        ]);
        $this->add([
            'name'  => 'data_type',
            'type'  => 'select',
            'options' => [
                'label' => 'Тип организации:',
                'value_options' => Contragent::TYPE_VALUE,
            ],
            'attributes' => [
                'id'    => 'data_type',
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
