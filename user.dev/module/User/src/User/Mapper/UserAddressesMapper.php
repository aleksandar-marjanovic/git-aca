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

class UserAddressesMapper extends AbstractTableGateway implements AdapterAwareInterface
{

    protected $table = 'user_addresses';

    public function setDbAdapter(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->initialize();
    }

    public function addRelation($user_id, $address_id)
    {
        $insert = $this->getSql()->insert()
            ->columns(["user_id", "address_id"])
            ->values(["user_id" => $user_id, "address_id" => $address_id]);

        return $this->executeInsert($insert);
    }

}