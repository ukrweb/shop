<?php
namespace Category\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Db\Sql\Select;

class OsCategoryDescriptionTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function getOsCategoriesArray()
    {
        $dbAdapter = $this->tableGateway->getAdapter();
        $query = "SELECT * FROM `oc_category` AS oc LEFT JOIN `oc_category_description` AS ocd
            ON oc.category_id = ocd.category_id
            ORDER BY ocd.name";
        $rowset = $dbAdapter->query($query)->execute();
        
        $result = [];
        foreach ($rowset as $key => $val) {
            $result[$val["category_id"]] = [
                "category_id" => (int) $val["category_id"],
                "parent_id"   => (int) $val["parent_id"],
                "name"        => $val["name"],
            ];
        }
        
        return $result;
    }

    public function getOsCategoryDescriptionArray($osCategoryId)
    {
        $dbAdapter = $this->tableGateway->getAdapter();
        $query = 'SELECT * FROM `oc_category` AS oc LEFT JOIN `oc_category_description` AS ocd
            ON oc.category_id = ocd.category_id
            WHERE oc.category_id = ' . $osCategoryId . '
            ORDER BY ocd.name';
        $rowset = $dbAdapter->query($query)->execute();

        $result = [];
        foreach ($rowset as $key => $val) {
            $result[$val["category_id"]] = [
                "category_id" => (int) $val["category_id"],
                "parent_id"   => (int) $val["parent_id"],
                "name"        => $val["name"],
            ];
        }

        return $result;
    }

    public function getOsCategoryDescriptionPath(array $osCategoriesArray, $osCategoryId)
    {
        $osCategoriesPath   = '';
        $osCategoryParentId = (int) $osCategoriesArray[$osCategoryId]['parent_id'];
        do {
            if (isset($osCategoriesArray[$osCategoryParentId])) {
                $osCategoriesPath   = $osCategoriesArray[$osCategoryParentId]['name'] . ' / ' . $osCategoriesPath;
                $osCategoryParentId = $osCategoriesArray[$osCategoryParentId]['parent_id'];
            } else {
                break;
            }
        } while (true);

        return rtrim($osCategoriesPath, ' / ');
    }

    public function getOsCategoryDescriptionByCols(array $cols)
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

    public function defaultOcCategoryOptions($defaultOcCategoryId)
    {
        if ($defaultOcCategoryId > 0) {
            $osCategoryDescriptionArray = $this->getOsCategoryDescriptionArray($defaultOcCategoryId);
            $osCategoriesArray = $this->getOsCategoriesArray();
            $osCategoryPath    = $this->getOsCategoryDescriptionPath($osCategoriesArray, $defaultOcCategoryId);

            $osCategory = [
                $defaultOcCategoryId => ($osCategoryPath ? $osCategoryPath . ' / ' : '') . 
                    $osCategoriesArray[$defaultOcCategoryId]['name']
            ];
        } else {
            $osCategory = OsCategoryDescription::DEFAULT_INPUT_VALUE;
        }

        return $osCategory;
    }

    public function searchOsCategoriesDescription(string $search, int $limit)
    {
        $resultSet = $this->tableGateway->select(function(Select $select) use ($search, $limit) {
            $select->where->like('name', '%' . $search . '%');
            $select->limit($limit);
            
        });

        $resultTmp = [];
        foreach ($resultSet as $key => $val) {
            $osCategoryPath  = $this->getOsCategoryDescriptionPath($this->getOsCategoriesArray(), $val->category_id);
            $resultTmp[(int) $val->category_id] = ($osCategoryPath ? $osCategoryPath . ' / ' : '') . $val->name;
        }
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
}