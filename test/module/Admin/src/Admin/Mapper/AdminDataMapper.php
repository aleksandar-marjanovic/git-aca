<?php

namespace Admin\Mapper;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;

class AdminDataMapper extends AbstractTableGateway{

    protected $table = 'users';

    public function setDbAdapter(Adapter $adapter){
        $this->adapter = $adapter;
        $this->initialize();
    }

    public function getAllUsers(){
        $select = $this->select();
        return $select->toArray();
    }

    public function getUserById($id){
        $select = $this->getSql()->select()->where(['id' => $id]);
        $result = $this->executeSelect($select);
        $result = $result->toArray();
        if(empty($result)){
            throw new \Exception("No user with id $id");
        }
        return $result;
    }

}