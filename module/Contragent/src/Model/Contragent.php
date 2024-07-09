<?php
namespace Contragent\Model;

use Zend\InputFilter\{
    Factory as InputFactory,
    InputFilter,
    InputFilterAwareInterface,
    InputFilterInterface
};

class Contragent implements InputFilterAwareInterface
{
    public const ADDRESS_DATA_QC_VALUE = [
       -1 => 'Нет',
        0 => 'Адрес распознан уверенно',
        1 => 'Требуется ручная проверка (код 1)',
        3 => 'Требуется ручная проверка (код 3)'
    ];

    public const BRANCH_COUNT_VALUE = [
        -1       => 'Нет',
        'MAIN'   => 'Головная организация',
        'BRANCH' => 'Филиал'
    ];

    public const STATE_STATUS_VALUE = [
        -1             => 'Нет',
        'ACTIVE'       => 'Действующая',
        'LIQUIDATING'  => 'Ликвидируется',
        'LIQUIDATED'   => 'Ликвидирована',
        'REORGANIZING' => 'В процессе присоединения к другому юрлицу, с последующей ликвидацией'
    ];

    public const TYPE_VALUE = [
        -1           => 'Нет',
        'LEGAL'      => 'Юридическое лицо',
        'INDIVIDUAL' => 'Индивидуальный предприниматель'
    ];
    
    public const DEFAULT_INPUT_VALUE = [
        -1 => 'Нет',
    ];

    public const DEFAULT_SEARCH_VALUE = [
        'id'   => -1,
        'text' => 'Нет'
    ];

    public $id;
    public $value;
    public $unrestricted_value;
    public $data_address_value;
    public $data_address_unrestricted_value;
    public $data_address_data_source;
    public $data_address_data_qc;
    public $data_branch_count;
    public $data_branch_type;
    public $data_inn;
    public $data_kpp;
    public $data_ogrn;
    public $data_ogrn_date;
    public $data_hid;
    public $data_management_name;
    public $data_management_post;
    public $data_name_full_with_opf;
    public $data_name_short_with_opf;
    public $data_name_latin;
    public $data_name_full;
    public $data_name_short;
    public $data_okpo;
    public $data_okved;
    public $data_okved_type;
    public $data_opf_code;
    public $data_opf_full;
    public $data_opf_short;
    public $data_opf_type;
    public $data_state_actuality_date;
    public $data_state_registration_date;
    public $data_state_liquidation_date;
    public $data_state_status;
    public $data_type;

    protected $inputFilter;

    public function exchangeArray(array $data)
    {
        $this->id                              = !empty($data['id'])                              ? $data['id']                              : null;
        $this->value                           = !empty($data['value'])                           ? $data['value']                           : '';
        $this->unrestricted_value              = !empty($data['unrestricted_value'])              ? $data['unrestricted_value']              : '';
        $this->data_address_value              = !empty($data['data_address_value'])              ? $data['data_address_value']              : '';
        $this->data_address_unrestricted_value = !empty($data['data_address_unrestricted_value']) ? $data['data_address_unrestricted_value'] : '';
        $this->data_address_data_source        = !empty($data['data_address_data_source'])        ? $data['data_address_data_source']        : '';
        $this->data_address_data_qc            = $data['data_address_data_qc'];
        $this->data_branch_count               = !empty($data['data_branch_count'])               ? $data['data_branch_count']               : 0;
        $this->data_branch_type                = !empty($data['data_branch_type'])                ? $data['data_branch_type']                : '';
        $this->data_inn                        = !empty($data['data_inn'])                        ? $data['data_inn']                        : null;
        $this->data_kpp                        = !empty($data['data_kpp'])                        ? $data['data_kpp']                        : null;
        $this->data_ogrn                       = !empty($data['data_ogrn'])                       ? $data['data_ogrn']                       : null;
        $this->data_ogrn_date                  = !empty($data['data_ogrn_date'])                  ? $data['data_ogrn_date']                  : '';
        $this->data_hid                        = !empty($data['data_hid'])                        ? $data['data_hid']                        : '';
        $this->data_management_name            = !empty($data['data_management_name'])            ? $data['data_management_name']            : '';
        $this->data_management_post            = !empty($data['data_management_post'])            ? $data['data_management_post']            : '';
        $this->data_name_full_with_opf         = !empty($data['data_name_full_with_opf'])         ? $data['data_name_full_with_opf']         : '';
        $this->data_name_short_with_opf        = !empty($data['data_name_short_with_opf'])        ? $data['data_name_short_with_opf']        : '';
        $this->data_name_latin                 = !empty($data['data_name_latin'])                 ? $data['data_name_latin']                 : '';
        $this->data_name_full                  = !empty($data['data_name_full'])                  ? $data['data_name_full']                  : '';
        $this->data_name_short                 = !empty($data['data_name_short'])                 ? $data['data_name_short']                 : '';
        $this->data_okpo                       = !empty($data['data_okpo'])                       ? $data['data_okpo']                       : null;
        $this->data_okved                      = !empty($data['data_okved'])                      ? $data['data_okved']                      : '';
        $this->data_okved_type                 = !empty($data['data_okved_type'])                 ? $data['data_okved_type']                 : null;
        $this->data_opf_code                   = !empty($data['data_opf_code'])                   ? $data['data_opf_code']                   : null;
        $this->data_opf_full                   = !empty($data['data_opf_full'])                   ? $data['data_opf_full']                   : '';
        $this->data_opf_short                  = !empty($data['data_opf_short'])                  ? $data['data_opf_short']                  : '';
        $this->data_opf_type                   = !empty($data['data_opf_type'])                   ? $data['data_opf_type']                   : null;
        $this->data_state_actuality_date       = !empty($data['data_state_actuality_date'])       ? $data['data_state_actuality_date']       : '';
        $this->data_state_registration_date    = !empty($data['data_state_registration_date'])    ? $data['data_state_registration_date']    : '';
        $this->data_state_liquidation_date     = !empty($data['data_state_liquidation_date'])     ? $data['data_state_liquidation_date']     : '';
        $this->data_state_status               = $data['data_state_status'];
        $this->data_type                       = !empty($data['data_type'])                       ? $data['data_type']                       : '';
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();

            $inputFilter->add($factory->createInput([
                'name'     => 'id',
                'filters'  => [
                    ['name' => 'Int']
                ]
            ]));

            $inputFilter->add($factory->createInput([
                'name'     => 'value',
                'required' => true,
                'filters'  => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim']
                ],
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 255,
                        ],
                    ],
                ],
            ]));

            $inputFilter->add($factory->createInput([
                'name'     => 'unrestricted_value',
                'required' => false,
                'filters'  => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim']
                ],
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => 0,
                            'max'      => 255,
                        ],
                    ],
                ],
            ]));

            $inputFilter->add($factory->createInput([
                'name'     => 'data_address_value',
                'required' => false,
                'filters'  => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim']
                ],
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => 0,
                            'max'      => 255,
                        ],
                    ],
                ],
            ]));

            $inputFilter->add($factory->createInput([
                'name'     => 'data_address_unrestricted_value',
                'required' => false,
                'filters'  => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim']
                ],
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => 0,
                            'max'      => 255,
                        ],
                    ],
                ],
            ]));

            $inputFilter->add($factory->createInput([
                'name'     => 'data_address_data_source',
                'required' => false,
                'filters'  => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim']
                ],
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => 0,
                            'max'      => 255,
                        ],
                    ],
                ],
            ]));

            $inputFilter->add($factory->createInput([
                'name'     => 'data_branch_count',
                'required' => false,
                'validators' => [
                    [
                        'name' => 'Digits',
                    ],
                ],
            ]));

            $inputFilter->add($factory->createInput([
                'name'     => 'data_inn',
                'required' => false,
                'validators' => [
                    [
                        'name' => 'Digits',
                    ],
                ],
            ]));

            $inputFilter->add($factory->createInput([
                'name'     => 'data_kpp',
                'required' => false,
                'validators' => [
                    [
                        'name' => 'Digits',
                    ],
                ],
            ]));

            $inputFilter->add($factory->createInput([
                'name'     => 'data_ogrn',
                'required' => false,
                'validators' => [
                    [
                        'name' => 'Digits',
                    ],
                ],
            ]));

            $inputFilter->add($factory->createInput([
                'name'     => 'data_ogrn_date',
                'required' => false,
                'filters'  => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim']
                ],
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => 0,
                            'max'      => 10,
                        ],
                    ],
                ],
            ]));

            $inputFilter->add($factory->createInput([
                'name'     => 'data_hid',
                'required' => false,
                'filters'  => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim']
                ],
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => 0,
                            'max'      => 255,
                        ],
                    ],
                ],
            ]));

            $inputFilter->add($factory->createInput([
                'name'     => 'data_management_name',
                'required' => false,
                'filters'  => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim']
                ],
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => 0,
                            'max'      => 255,
                        ],
                    ],
                ],
            ]));

            $inputFilter->add($factory->createInput([
                'name'     => 'data_management_post',
                'required' => false,
                'filters'  => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim']
                ],
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => 0,
                            'max'      => 255,
                        ],
                    ],
                ],
            ]));

            $inputFilter->add($factory->createInput([
                'name'     => 'data_name_full_with_opf',
                'required' => false,
                'filters'  => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim']
                ],
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => 0,
                            'max'      => 255,
                        ],
                    ],
                ],
            ]));

            $inputFilter->add($factory->createInput([
                'name'     => 'data_name_short_with_opf',
                'required' => false,
                'filters'  => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim']
                ],
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => 0,
                            'max'      => 255,
                        ],
                    ],
                ],
            ]));

            $inputFilter->add($factory->createInput([
                'name'     => 'data_name_latin',
                'required' => false,
                'filters'  => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim']
                ],
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => 0,
                            'max'      => 255,
                        ],
                    ],
                ],
            ]));

            $inputFilter->add($factory->createInput([
                'name'     => 'data_name_full',
                'required' => false,
                'filters'  => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim']
                ],
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => 0,
                            'max'      => 255,
                        ],
                    ],
                ],
            ]));

            $inputFilter->add($factory->createInput([
                'name'     => 'data_name_short',
                'required' => false,
                'filters'  => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim']
                ],
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => 0,
                            'max'      => 255,
                        ],
                    ],
                ],
            ]));

            $inputFilter->add($factory->createInput([
                'name'     => 'data_okpo',
                'required' => false,
                'validators' => [
                    [
                        'name' => 'Digits',
                    ],
                ],
            ]));

            $inputFilter->add($factory->createInput([
                'name'     => 'data_okved',
                'required' => false,
                'filters'  => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim']
                ],
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => 0,
                            'max'      => 12,
                        ],
                    ],
                ],
            ]));

            $inputFilter->add($factory->createInput([
                'name'     => 'data_okved_type',
                'required' => false,
                'validators' => [
                    [
                        'name' => 'Digits',
                    ],
                ],
            ]));

            $inputFilter->add($factory->createInput([
                'name'     => 'data_opf_code',
                'required' => false,
                'validators' => [
                    [
                        'name' => 'Digits',
                    ],
                ],
            ]));

            $inputFilter->add($factory->createInput([
                'name'     => 'data_opf_full',
                'required' => false,
                'filters'  => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim']
                ],
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => 0,
                            'max'      => 255,
                        ],
                    ],
                ],
            ]));

            $inputFilter->add($factory->createInput([
                'name'     => 'data_opf_short',
                'required' => false,
                'filters'  => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim']
                ],
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => 0,
                            'max'      => 255,
                        ],
                    ],
                ],
            ]));

            $inputFilter->add($factory->createInput([
                'name'     => 'data_opf_type',
                'required' => false,
                'validators' => [
                    [
                        'name' => 'Digits',
                    ],
                ],
            ]));

            $inputFilter->add($factory->createInput([
                'name'     => 'data_state_actuality_date',
                'required' => false,
                'filters'  => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim']
                ],
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => 0,
                            'max'      => 10,
                        ],
                    ],
                ],
            ]));

            $inputFilter->add($factory->createInput([
                'name'     => 'data_state_registration_date',
                'required' => false,
                'filters'  => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim']
                ],
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => 0,
                            'max'      => 10,
                        ],
                    ],
                ],
            ]));

            $inputFilter->add($factory->createInput([
                'name'     => 'data_state_liquidation_date',
                'required' => false,
                'filters'  => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim']
                ],
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => 0,
                            'max'      => 10,
                        ],
                    ],
                ],
            ]));

            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }
}