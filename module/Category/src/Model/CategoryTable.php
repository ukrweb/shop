<?php
namespace Category\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Db\Sql\Select;

class CategoryTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    public function getCategoriesArray()
    {
        $resultSet = $this->tableGateway->select(function(Select $select) {
            $select->order('category_name');
        });
  
        $result = [];
        foreach ($resultSet as $key => $val) {
            $result[$val->category_id] = [
                "category_id"        => (int) $val->category_id,
                "category_parent_id" => (int) $val->category_parent_id,
                "category_name"      => $val->category_name,
                "category_enable"    => $val->category_enable,
            ];
        }

        return $result;
    }

    public function getCategory(int $category_id)
    {
        $category_id = (int) $category_id;
        $rowset = $this->tableGateway->select(['category_id' => $category_id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf('Could not find row with identifier %d', $category_id));
        }

        return $row;
    }

    public function getCategoryByCols(array $cols)
    {
        if (count($cols)) {
            $rowset = $this->tableGateway->select($cols);
            $row = $rowset->current();
            if (! $row) {
                $row = false;
            }

            return $row;
        } else {
            return false;
        }
    }

    public function getCategoryPath(array $categoriesArray, $categoryParentId)
    {
        $categoriesPath = '';
        do {
            if (isset($categoriesArray[$categoryParentId])) {
                $categoriesPath   = $categoriesArray[$categoryParentId]['category_name'] . ' / ' . $categoriesPath;
                $categoryParentId = $categoriesArray[$categoryParentId]['category_parent_id'];
            } else {
                break;
            }
        } while (true);

        return rtrim($categoriesPath, ' / ');
    }

    public function searchCategories(string $search, int $excludeCategoryId, int $limit)
    {
        $resultSet = $this->tableGateway->select(function(Select $select) use ($search, $excludeCategoryId, $limit) {
            $select->where
                ->like('category_name', '%' . $search . '%')
                ->and
                ->notEqualTo('category_id', $excludeCategoryId);
            $select->limit($limit);
            
        });

        $resultTmp = [];
        $categoriesArray = $this->getCategoriesArray();
        foreach ($resultSet as $key => $val) {
            $categoryParentId = (int) $val->category_parent_id;
            $categoryPath     = $this->getCategoryPath($categoriesArray, $categoryParentId);
            $resultTmp[(int) $val->category_id] = ($categoryPath ? $categoryPath . ' / ' : '') . $val->category_name;
        };
        asort($resultTmp);

        $result = [];
        foreach ($resultTmp as $key => $val) {
            $result[] = [
                'id'   => $key,
                'text' => $val
            ];
        }

        return $result;
    }

    public function updateChildCategory(int $category_id)
    {
        $currentCategory = $this->getCategory($category_id);
        $this->tableGateway->update(
            ['category_parent_id' => $currentCategory->category_parent_id],
            ['category_parent_id' => $category_id]
        );
    }

    public function defaultCategoryParentOptions($defaultCategoryParentId)
    {
        $defaultParentСategory = $this->getCategoryByCols(['category_id' => $defaultCategoryParentId]);
        if ($defaultParentСategory) {
            $categoriesArray = $this->getCategoriesArray();
            $categoryPath    = $this->getCategoryPath($categoriesArray, $defaultParentСategory->category_parent_id);
            $parentCategory  = [
                $defaultCategoryParentId => ($categoryPath ? $categoryPath . ' / ' : '') . $defaultParentСategory->category_name
            ];
        } else {
            $parentCategory = Category::DEFAULT_INPUT_VALUE;
        }

        return $parentCategory;
    }

    public function saveCategory($category)
    {
        $data = [
            'oc_category_id'     => $category->oc_category_id > -1     ? $category->oc_category_id     : null,
            'category_name'      => $category->category_name           ? $category->category_name      : '',
            'margin_percent'     => $category->margin_percent          ? $category->margin_percent     : 0.0,
            'margin_fix'         => $category->margin_fix              ? $category->margin_fix         : 0.0,
            'category_parent_id' => $category->category_parent_id > -1 ? $category->category_parent_id : null,
            'category_enable'    => $category->category_enable         ? $category->category_enable    : null,
            'status'             => $category->status                  ? $category->status             : null,
        ];

        $category_id = (int) $category->category_id;
        if ($category_id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        if (! $this->getCategory($category_id)) {
            throw new RuntimeException(sprintf(
                'Cannot update category with identifier %d; does not exist',
                $category_id
            ));
        }

        $this->tableGateway->update($data, ['category_id' => $category_id]);
    }
}