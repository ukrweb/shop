<?php
namespace Category\Model;

class OsCategoryDescription
{
    public const DEFAULT_INPUT_VALUE = [
        -1 => 'Нет',
    ];

    public $category_id;
    public $language_id;
    public $name;
    public $description;
    public $meta_description;
    public $meta_keyword;

    public function exchangeArray(array $data)
    {
        $this->category_id      = !empty($data['category_id'])      ? $data['category_id']      : null;
        $this->language_id      = !empty($data['language_id'])      ? $data['language_id']      : null;
        $this->name             = !empty($data['name'])             ? $data['name']             : 0;
        $this->description      = !empty($data['description'])      ? $data['description']      : null;
        $this->meta_description = !empty($data['meta_description']) ? $data['meta_description'] : null;
        $this->meta_keyword     = !empty($data['meta_keyword'])     ? $data['meta_keyword']     : null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}