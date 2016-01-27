<?php

namespace Album\Mapper;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Zend\Db\Sql\Sql;
use Album\Module\Album;

class AlbumDataMapper extends AbstractTableGateway implements AdapterAwareInterface{

    protected $table = 'album';

    /**
     * Set db adapter
     *
     * @param Adapter $adapter
     * @return AdapterAwareInterface
     */
    public function setDbAdapter(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->initialize();
    }

    public function fetchAll()
    {
        $resultSet = $this->select();
        return $resultSet;
    }

    public function getAlbum($id)
    {
        $id  = (int) $id;
        $select = $this->getSql()->select()->where(array('id' => $id));
        $rowSet = $this->executeSelect($select);
        $row = $rowSet->toArray();
        if(!empty($row)){
            return reset($row);
        }else{
            throw new \Exception("Could not find row $id");
        }
    }

    public function saveAlbum(Album $album)
    {
        $data = array(
            'artist' => $album->artist,
            'title'  => $album->title,
        );

        $id = (int) $album->id;

        if ($id == 0) {
            $insert = $this->getSql()->insert()
                           ->columns(["title", "artist"])
                           ->values(["title"=>$data['title'], "artist"=>$data['artist']]);

            return $this->executeInsert($insert);
        } else {
            if ($this->getAlbum($id)) {
                $update = $this->getSql()->update()->set($data)->where(['id'=>$id]);
                return $this->executeUpdate($update);
            } else {
                throw new \Exception('Album id does not exist');
            }
        }
    }

    public function deleteAlbum($id)
    {
        $delete = $this->getSql()->delete()->where(array('id' => (int) $id));
        return $this->executeDelete($delete);
    }
}