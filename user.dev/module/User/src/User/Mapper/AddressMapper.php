<?php

namespace User\Mapper;

use User\Model\User;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Zend\Db\Sql\Sql;

class AddressMapper extends AbstractTableGateway implements AdapterAwareInterface
{

    protected $table = 'address';

    public function setDbAdapter(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->initialize();
    }

    public function addAddress(User $user)
    {
        $insert2 = $this->getSql()->insert()
            ->columns(["address_1", "address_2", "city", "post_code", "telephone"])
            ->values([
                "address_1" => $user->address_1,
                "address_2" => $user->address_2,
                "city"      => $user->city,
                "post_code" => $user->post_code,
                "telephone" => $user->telephone
            ]);
        $this->executeInsert($insert2);

        return $this->getAdapter()->getDriver()->getLastGeneratedValue($this->table . '_id_seq');
    }

    public function updateAddress(User $user)
    {
        $update = $this->getSql()->update()->set([
            "address_1" => $user->address_1,
            "address_2" => $user->address_2,
            "city"      => $user->city,
            "post_code" => $user->post_code,
            "telephone" => $user->telephone
        ])->where(['id' => $user->address_id]);

        return $this->executeUpdate($update);
    }
}