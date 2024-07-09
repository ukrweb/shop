<?php
namespace SupplierStock\Model;

use Zend\InputFilter\{
    Factory as InputFactory,
    InputFilter,
    InputFilterAwareInterface,
    InputFilterInterface
};

class SupplierStock implements InputFilterAwareInterface
{
    public const STATUS_VALUE = [
       -1 => 'Нет',
        0 => 'Выключен',
        1 => 'Включен',
        2 => 'Инфо'
    ];

    public $supplier_stock_id;
    public $supplier_id;
    public $stock_name;
    public $delivery_time;
    public $margin_fix;
    public $margin_percent;
    public $status;

    protected $inputFilter;

    public function exchangeArray(array $data)
    {
        $this->supplier_stock_id = !empty($data['supplier_stock_id']) ? $data['supplier_stock_id'] : null;
        $this->supplier_id       = !empty($data['supplier_id'])       ? $data['supplier_id']       : null;
        $this->stock_name        = !empty($data['stock_name'])        ? $data['stock_name']        : '';
        $this->delivery_time     = !empty($data['delivery_time'])     ? $data['delivery_time']     : null;
        $this->margin_fix        = !empty($data['margin_fix'])        ? $data['margin_fix']        : 0.0;
        $this->margin_percent    = !empty($data['margin_percent'])    ? $data['margin_percent']    : 0.0;
        $this->status            = $data['status'];
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
                'name'     => 'stock_name',
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
                'name'     => 'delivery_time',
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

            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }
}