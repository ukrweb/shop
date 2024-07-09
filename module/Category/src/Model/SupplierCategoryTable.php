<?php
namespace Category\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Db\Sql\Select;

class SupplierCategoryTable
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

    public function getSupplierCategoriesArray(int $category_id)
    {
        $dbAdapter = $this->tableGateway->getAdapter();
        $query = "SELECT * FROM `supplier_category` AS sc LEFT JOIN `supplier` AS s ON sc.supplier_id = s.supplier_id
            WHERE sc.category_id = " . $category_id . "
            ORDER BY sc.supplier_category_name";
        $rowset = $dbAdapter->query($query)->execute();

        $result = [];
        foreach ($rowset as $key => $val) {
            $result[$val["supplier_category_id"]] = [
                "supplier_category_id"     => $val["supplier_category_id"],
                "parent_id"                => $val["parent_id"],
                "supplier_id"              => $val["supplier_id"],
                "category_id"              => $val["category_id"],
                "supplier_category_name"   => $val["supplier_category_name"],
                "datetime_update"          => $val["datetime_update"],
                "supplier_category_enable" => $val["supplier_category_enable"],
                "supplier_name"            => $val["supplier_name"],
            ];
        }

        foreach ($result as $key => $val) {
            $supplierCategoryInfo = $this->getSupplierCategoryInfo($result, $key);
            $result[$key]["supplier_category_path"]  = $supplierCategoryInfo["supplier_category_path"];
            $result[$key]["supplier_category_level"] = $supplierCategoryInfo["supplier_category_level"];
        }

        return $result;
    }

    public function getSupplierCategoryInfo(array $supplierCategoriesArray, int $supplierCategoryId)
    {
        $supplierCategoriesPath  = '';
        $supplierCategoriesLevel = 0;
        if (!isset($supplierCategoriesArray[$supplierCategoryId]["parent_id"])) {
            $supplierCategoriesLevel++;
            $supplierCategoriesPath = $supplierCategoriesArray[$supplierCategoryId]['supplier_category_name'];
        } else {
            do {
                if (isset($supplierCategoriesArray[$supplierCategoryId]["parent_id"])) {
                    $supplierCategoriesLevel++;
                    $supplierCategoriesPath = $supplierCategoriesArray[$supplierCategoryId]['supplier_category_name'] . 
                        ' / ' . $supplierCategoriesPath;
                    $supplierCategoryId     = $supplierCategoriesArray[$supplierCategoryId]['parent_id'];
                } else {
                    break;
                }
            } while (true);
            $supplierCategoriesPath = rtrim($supplierCategoriesPath, ' / ');
        }

        return [
            "supplier_category_path"  => $supplierCategoriesPath,
            "supplier_category_level" => $supplierCategoriesLevel
        ];
    }

    public function saveSupplierCategories($category)
    {
        $categoryId         = (int) $category->supplier_category;
        $supplierCategories = $category->supplier_categories;

        if ($categoryId > 0 && count($supplierCategories)) {
            $this->tableGateway->update(['category_id' => $categoryId], ['supplier_category_id' => $supplierCategories]);
        }
    }
}