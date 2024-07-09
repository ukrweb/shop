<?php
namespace Category\Model;

use Zend\InputFilter\{
    Factory as InputFactory,
    InputFilter,
    InputFilterAwareInterface,
    InputFilterInterface
};

class Category implements InputFilterAwareInterface
{
    public const STATUS_VALUE = [
        0 => 'Нет',
        1 => 'Да'
    ];

    public const CATEGORY_ENABLE_VALUE = [
        0 => 'Нет',
        1 => 'Да'
    ];

    public const DEFAULT_INPUT_VALUE = [
        -1 => 'Нет',
    ];

    public const DEFAULT_SEARCH_VALUE = [
        'id'   => -1,
        'text' => 'Нет'
    ];

    public $category_id;
    public $oc_category_id;
    public $category_name;
    public $margin_percent;
    public $margin_fix;
    public $category_parent_id;
    public $category_enable;
    public $status;

    protected $inputFilter;

    public function exchangeArray(array $data)
    {
        $this->category_id        = !empty($data['category_id'])        ? $data['category_id']        : null;
        $this->oc_category_id     = !empty($data['oc_category_id'])     ? $data['oc_category_id']     : null;
        $this->category_name      = !empty($data['category_name'])      ? $data['category_name']      : '';
        $this->margin_percent     = !empty($data['margin_percent'])     ? $data['margin_percent']     : 0.0;
        $this->margin_fix         = !empty($data['margin_fix'])         ? $data['margin_fix']         : 0.0;
        $this->category_parent_id = !empty($data['category_parent_id']) ? $data['category_parent_id'] : null;
        $this->category_enable    = !empty($data['category_enable'])    ? $data['category_enable']    : null;
        $this->status             = !empty($data['status'])             ? $data['status']             : null;
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
                'name'     => 'category_id',
                'filters'  => [
                    ['name' => 'Int']
                ]
            ]));

            $inputFilter->add($factory->createInput([
                'name'     => 'category_name',
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
                            'max'      => 155,
                        ],
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