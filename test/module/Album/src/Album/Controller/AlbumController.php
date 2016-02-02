<?php

namespace Album\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Album\Module\Album;
use Album\Form\AlbumForm;

class AlbumController extends AbstractActionController{

    protected $db;

    public function indexAction(){
        $this->db = $this->getServiceLocator()->get('Album\Mapper\AlbumDataMapper');
        return [
            'albums' => $this->db->fetchAll()
        ];
    }

    public function addAction(){
        $form = new AlbumForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $album = new Album();
            $this->db = $this->getServiceLocator()->get('Album\Mapper\AlbumDataMapper');
            $form->setInputFilter($album->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $album->exchangeArray($form->getData());
                $this->db->saveAlbum($album);

                // Redirect to list of albums
                return $this->redirect()->toRoute('album');
            }
        }
        return array('form' => $form);
    }

    public function editAction(){
        $this->db = $this->getServiceLocator()->get('Album\Mapper\AlbumDataMapper');

        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('album', array(
                'action' => 'add'
            ));
        }
        // Get the Album with the specified id.  An exception is thrown
        // if it cannot be found, in which case go to the index page.
        try {
            $albumData = $this->db->getAlbum($id);
        }
        catch (\Exception $ex) {
            return $this->redirect()->toRoute('album', array(
                'action' => 'index'
            ));
        }

        $form  = new AlbumForm();
        $album = new Album();
        $album->exchangeArray($albumData);
        $form->bind($album);

        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($album->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->db->saveAlbum($album);

                // Redirect to list of albums
                return $this->redirect()->toRoute('album');
            }
        }

        return array(
            'id'     => $id,
            'form'   => $form,
        );
    }

    public function deleteAction(){
        $this->db = $this->getServiceLocator()->get('Album\Mapper\AlbumDataMapper');

        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('album', array(
                'action' => 'add'
            ));
        }
        // Get the Album with the specified id.  An exception is thrown
        // if it cannot be found, in which case go to the index page.
        try {
            $albumData = $this->db->getAlbum($id);
        }
        catch (\Exception $ex) {
            return $this->redirect()->toRoute('album', array(
                'action' => 'index'
            ));
        }

        if($this->db->deleteAlbum($id)){
            return $this->redirect()->toRoute('album', array(
                'action' => 'index'
            ));
        }else{
            return $this->redirect()->toRoute('album', array(
                'action' => 'index'
            ));
        }
    }

}