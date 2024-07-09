<?php
namespace Supplier\Model;

use Zend\InputFilter\{
    Factory as InputFactory,
    InputFilter,
    InputFilterAwareInterface,
    InputFilterInterface
};

class Supplier implements InputFilterAwareInterface
{
    public const STATUS_VALUE = [
       -1 => 'Нет',
        0 => 'Выключен',
        1 => 'Включен',
        2 => 'Инфо'
    ];

    public $supplier_id;
    public $supplier_name;
    public $supplier_delivery_time;
    public $margin_percent;
    public $margin_fix;
    public $supplier_update_id;
    public $supplier_update_interval;
    public $enable;
    public $status;
    public $default_contragent_id;
    public $comment;
    public $email;

    protected $inputFilter;

    public function exchangeArray(array $data)
    {
        $this->supplier_id              = !empty($data['supplier_id'])              ? $data['supplier_id']              : null;
        $this->supplier_name            = !empty($data['supplier_name'])            ? $data['supplier_name']            : '';
        $this->supplier_delivery_time   = !empty($data['supplier_delivery_time'])   ? $data['supplier_delivery_time']   : 0;
        $this->margin_percent           = !empty($data['margin_percent'])           ? $data['margin_percent']           : 0.0;
        $this->margin_fix               = !empty($data['margin_fix'])               ? $data['margin_fix']               : 0.0;
        $this->supplier_update_id       = !empty($data['supplier_update_id'])       ? $data['supplier_update_id']       : null;
        $this->supplier_update_interval = !empty($data['supplier_update_interval']) ? $data['supplier_update_interval'] : 0;
        $this->enable                   = !empty($data['sipplier_enable'])          ? $data['sipplier_enable']          : null;
        $this->status                   = $data['status'];
        $this->default_contragent_id    = !empty($data['default_contragent_id'])    ? $data['default_contragent_id']    : null;
        $this->comment                  = !empty($data['comment'])                  ? $data['comment']                  : '';
        $this->email                    = !empty($data['email'])                    ? $data['email']                    : '';
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
                'name'     => 'supplier_id',
                'filters'  => [
                    ['name' => 'Int']
                ]
            ]));

            $inputFilter->add($factory->createInput([
                'name'     => 'supplier_name',
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
                            'max'      => 50,
                        ],
                    ],
                ],
            ]));

            $inputFilter->add($factory->createInput([
                'name'     => 'supplier_delivery_time',
                'required' => false,
                'validators' => [
                    [
                        'name' => 'Digits',
                    ],
                ],
            ]));

            $inputFilter->add($factory->createInput([
                'name'     => 'margin_fix',
                'required' => false,
                'validators' => [
                    [
                        'name' => '\Zend\I18n\Validator\IsFloat',
                        'options' =>  [
                            'locale' => 'en'
                        ],
                    ],
                ],
            ]));

            $inputFilter->add($factory->createInput([
                'name'     => 'margin_percent',
                'required' => false,
                'validators' => [
                    [
                        'name' => '\Zend\I18n\Validator\IsFloat',
                        'options' =>  [
                            'locale' => 'en'
                        ],
                    ],
                ],
            ]));

            $inputFilter->add($factory->createInput([
                'name'     => 'supplier_update_interval',
                'required' => false,
                'validators' => [
                    [
                        'name' => 'Digits',
                    ],
                ],
            ]));

            $inputFilter->add($factory->createInput([
                'name'     => 'comment',
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
                            'max'      => 65535,
                        ],
                    ],
                ],
            ]));

            $inputFilter->add($factory->createInput([
                'name'     => 'email',
                'required' => false,
                'filters'  => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim']
                ],
                'validators' => [
                    [
                        'name' => 'EmailAddress'
                    ],
                ],
            ]));

            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }
}