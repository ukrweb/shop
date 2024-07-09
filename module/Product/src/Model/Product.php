<?php
namespace Product\Model;

use Zend\InputFilter\{
    Factory as InputFactory,
    InputFilter,
    InputFilterAwareInterface,
    InputFilterInterface
};

class Product implements InputFilterAwareInterface
{
    public $product_sku_id;
    public $product_id;
    public $category_id;
    public $product_option_id;
    public $article;
    public $name;
    public $price_recommend;
    public $options;
    public $price_min_sell;
    public $price_counted;
    public $price_fix;
    public $price_fix_expire;
    public $status;
    public $sell_price_loseless;
    public $sell_price_adv;
    public $sell_price_market;
    public $sell_price_base;
    public $sell_price_discount;

    protected $inputFilter;

    public function exchangeArray(array $data)
    {
        $this->product_sku_id      = !empty($data['product_sku_id'])      ? $data['product_sku_id']      : null;
        $this->product_id          = !empty($data['product_id'])          ? $data['product_id']          : 0;
        $this->category_id         = !empty($data['category_id'])         ? $data['category_id']         : 0;
        $this->product_option_id   = !empty($data['product_option_id'])   ? $data['product_option_id']   : null;
        $this->article             = !empty($data['article'])             ? $data['article']             : null;
        $this->name                = !empty($data['name'])                ? $data['name']                : null;
        $this->price_recommend     = !empty($data['price_recommend'])     ? $data['price_recommend']     : null;
        $this->options             = !empty($data['options'])             ? $data['options']             : 0;
        $this->price_min_sell      = !empty($data['price_min_sell'])      ? $data['price_min_sell']      : null;
        $this->price_counted       = !empty($data['price_counted'])       ? $data['price_counted']       : null;
        $this->price_fix           = !empty($data['price_fix'])           ? $data['price_fix']           : null;
        $this->price_fix_expire    = !empty($data['price_fix_expire'])    ? $data['price_fix_expire']    : null;
        $this->status              = !empty($data['status'])              ? $data['status']              : null;
        $this->sell_price_loseless = !empty($data['sell_price_loseless']) ? $data['sell_price_loseless'] : null;
        $this->sell_price_adv      = !empty($data['sell_price_adv'])      ? $data['sell_price_adv']      : null;
        $this->sell_price_market   = !empty($data['sell_price_market'])   ? $data['sell_price_market']   : null;
        $this->sell_price_base     = !empty($data['sell_price_base'])     ? $data['sell_price_base']     : null;
        $this->sell_price_discount = !empty($data['sell_price_discount']) ? $data['sell_price_discount'] : null;
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
                'name'     => 'product_id',
                'filters'  => [
                    ['name' => 'Int']
                ]
            ]));

            $inputFilter->add($factory->createInput([
                'name'     => 'product_name',
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
                'name'     => 'product_delivery_time',
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
                'name'     => 'product_update_interval',
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