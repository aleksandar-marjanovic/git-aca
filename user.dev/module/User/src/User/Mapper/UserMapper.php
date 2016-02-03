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

class UserMapper extends AbstractTableGateway implements AdapterAwareInterface
{

    protected $table = 'users';

    public function setDbAdapter(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->initialize();
    }

    public function getAllUsers($params)
    {
        //select * from users JOIN user_addresses ON users.id = user_id JOIN address ON address.id = address_id
        $allowed = ['name', 'birth_date'];
        $filter  = [];

        $select = $this->getSql()->select()->join('user_addresses', 'users.id = user_id')
            ->join('address', 'address.id = address_id');

        foreach($params as $key => $param){
            if(in_array($key, $allowed) && $param != ''){
                $select->where->AND->like($key, '%' . $param . '%');
            }
        }
        $select = $this->executeSelect($select);

        return $select->toArray();
    }

    public function getUserById($id)
    {
        $select = $this->getSql()->select()
            ->join('user_addresses', 'users.id = user_id')
            ->join('address', 'address.id = address_id')
            ->where([$this->table . '.id' => $id]);
        $select = $this->executeSelect($select);
        $result = $select->toArray();
        if(!empty($result)){
            return reset($result);
        }

        return $result;
    }

    public function addUser(User $user)
    {
        $insert = $this->getSql()->insert()
            ->columns(["name", "email", "birth_date"])
            ->values(["name" => $user->name, "email" => $user->email, "birth_date" => $user->birth_date]);
        $this->executeInsert($insert);

        return $this->getAdapter()->getDriver()->getLastGeneratedValue($this->table . '_id_seq');
    }

    public function updateUser(User $user)
    {
        $update = $this->getSql()->update()->set([
            "name"       => $user->name,
            "email"      => $user->email,
            "birth_date" => $user->birth_date
        ])->where(['id' => $user->user_id]);

        return $this->executeUpdate($update);
    }

    public function deleteUser($user_id)
    {
        $update = $this->getSql()->delete()->where(['id' => $user_id]);

        return $this->executeDelete($update);
    }

}