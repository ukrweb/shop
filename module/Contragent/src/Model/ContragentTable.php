<?php
namespace Contragent\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Db\Sql\Select;

class ContragentTable
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

    public function getContragent(int $id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf('Could not find row with identifier %d', $id));
        }

        return $row;
    }

    public function getContragentByCols(array $cols)
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

    public function isContragent(string $hid)
    {
        $rowset = $this->tableGateway->select(['data_hid' => $hid]);
        $row = $rowset->current();

        return $row ? true : false;
    }

    public function searchContragents(string $search, int $limit)
    {
        $resultSet = $this->tableGateway->select(function(Select $select) use ($search, $limit) {
            $select->where->like('value', '%' . $search . '%')->OR->like('data_inn', '%' . $search . '%');
            $select->limit($limit);
            
        });

        $result = [];
        foreach ($resultSet as $key => $val) {
            $result[] = [
                "id"   => (int) $val->id,
                "text" => $val->value . ', ' . $val->data_inn
            ];
        }

        return $result;
    }

    public function defaultContragentOptions($defaultContragentId)
    {
        $defaultContragent = $this->getContragentByCols(['id' => $defaultContragentId]);
        if ($defaultContragent) {
            $contragent = [$defaultContragent->id => $defaultContragent->value];
        } else {
            $contragent = Contragent::DEFAULT_INPUT_VALUE;
        }

        return $contragent;
    }

    public function saveContragent($contragent)
    {
        $data = [
            'value'                           => $contragent->value                           ? $contragent->value                           : '',
            'unrestricted_value'              => $contragent->unrestricted_value              ? $contragent->unrestricted_value              : '',
            'data_address_value'              => $contragent->data_address_value              ? $contragent->data_address_value              : '',
            'data_address_unrestricted_value' => $contragent->data_address_unrestricted_value ? $contragent->data_address_unrestricted_value : '',
            'data_address_data_source'        => $contragent->data_address_data_source        ? $contragent->data_address_data_source        : '',
            'data_address_data_qc'            => $contragent->data_address_data_qc,
            'data_branch_count'               => $contragent->data_branch_count               ? $contragent->data_branch_count               : 0,
            'data_branch_type'                => $contragent->data_branch_type                ? $contragent->data_branch_type                : '',
            'data_inn'                        => $contragent->data_inn                        ? $contragent->data_inn                        : NULL,
            'data_kpp'                        => $contragent->data_kpp                        ? $contragent->data_kpp                        : NULL,
            'data_ogrn'                       => $contragent->data_ogrn                       ? $contragent->data_ogrn                       : NULL,
            'data_ogrn_date'                  => $contragent->data_ogrn_date                  ? $contragent->data_ogrn_date                  : '',
            'data_hid'                        => $contragent->data_hid                        ? $contragent->data_hid                        : '',
            'data_management_name'            => $contragent->data_management_name            ? $contragent->data_management_name            : '',
            'data_management_post'            => $contragent->data_management_post            ? $contragent->data_management_post            : '',
            'data_name_full_with_opf'         => $contragent->data_name_full_with_opf         ? $contragent->data_name_full_with_opf         : '',
            'data_name_short_with_opf'        => $contragent->data_name_short_with_opf        ? $contragent->data_name_short_with_opf        : '',
            'data_name_latin'                 => $contragent->data_name_latin                 ? $contragent->data_name_latin                 : '',
            'data_name_full'                  => $contragent->data_name_full                  ? $contragent->data_name_full                  : '',
            'data_name_short'                 => $contragent->data_name_short                 ? $contragent->data_name_short                 : '',
            'data_okpo'                       => $contragent->data_okpo                       ? $contragent->data_okpo                       : NULL,
            'data_okved'                      => $contragent->data_okved                      ? $contragent->data_okved                      : '',
            'data_okved_type'                 => $contragent->data_okved_type                 ? $contragent->data_okved_type                 : NULL,
            'data_opf_code'                   => $contragent->data_opf_code                   ? $contragent->data_opf_code                   : NULL,
            'data_opf_full'                   => $contragent->data_opf_full                   ? $contragent->data_opf_full                   : '',
            'data_opf_short'                  => $contragent->data_opf_short                  ? $contragent->data_opf_short                  : '',
            'data_opf_type'                   => $contragent->data_opf_type                   ? $contragent->data_opf_type                   : NULL,
            'data_state_actuality_date'       => $contragent->data_state_actuality_date       ? $contragent->data_state_actuality_date       : '',
            'data_state_registration_date'    => $contragent->data_state_registration_date    ? $contragent->data_state_registration_date    : '',
            'data_state_liquidation_date'     => $contragent->data_state_liquidation_date     ? $contragent->data_state_liquidation_date     : '',
            'data_state_status'               => $contragent->data_state_status               ? $contragent->data_state_status               : '',
            'data_type'                       => $contragent->data_type                       ? $contragent->data_type                       : '',
        ];

        $id = (int) $contragent->id;
        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        if (! $this->getContragent($id)) {
            throw new RuntimeException(sprintf(
                'Cannot update contragent with identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }
}