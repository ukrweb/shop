<?php
namespace Category\Model;

class SupplierCategory
{
    public const SUPPPLIER_CATEGORY_ENABLE_VALUE = [
        0 => 'Нет',
        1 => 'Да'
    ];

    public const DEFAULT_INPUT_VALUE = [
        -1 => 'Нет',
    ];

    public $supplier_category_id;
    public $parent_id;
    public $supplier_id;
    public $category_id;
    public $supplier_category_name;
    public $datetime_update;
    public $supplier_category_enable;

    protected $inputFilter;

    public function exchangeArray(array $data)
    {
        $this->supplier_category_id     = !empty($data['supplier_category_id'])     ? $data['supplier_category_id']     : null;
        $this->parent_id                = !empty($data['parent_id'])                ? $data['parent_id']                : null;
        $this->supplier_id              = !empty($data['supplier_id'])              ? $data['supplier_id']              : null;
        $this->category_id              = !empty($data['category_id'])              ? $data['category_id']              : null;
        $this->supplier_category_name   = !empty($data['supplier_category_name'])   ? $data['supplier_category_name']   : null;
        $this->datetime_update          = !empty($data['datetime_update'])          ? $data['datetime_update']          : null;
        $this->supplier_category_enable = !empty($data['supplier_category_enable']) ? $data['supplier_category_enable'] : null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}