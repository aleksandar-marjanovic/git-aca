<?php

namespace Application\Mapper;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Zend\Db\Sql\Sql;


class UserDataMapper extends AbstractTableGateway implements AdapterAwareInterface{

	protected $table = 'persons';

	public function setDbAdapter(Adapter $adapter) {
		$this->adapter = $adapter;
		//$this->resultSetPrototype = new ResultSet(ResultSet::TYPE_ARRAY);
		$this->initialize();
	}

	public function getUserById($id){
		$select = $this->getSql()->select()->where(['personid' => $id]);
		$result2 = $this->executeSelect($select);
		return $result2->toArray();
	}

	public function createUser(){
		$insert = $this->getSql()
					->insert()
					->columns(["personid", "lastname", "firstname", "address", "city"])
					->values(["personid"=>3,
						"lastname"=>"lakic",
						"firstname"=>"laki",
						"address"=>"Banovo brdo",
						"city"=>"Beograd"]);
		return $this->executeInsert($insert);
	}
}