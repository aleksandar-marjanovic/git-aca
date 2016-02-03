<?php

namespace User\Controller;

use User\Model\User;
use Zend\InputFilter\InputFilterInterface;
use Zend\Mvc\Controller\AbstractActionController;
use User\Mapper\UserMapper;
use User\Mapper\AddressMapper;
use User\Mapper\UserAddressesMapper;
use Zend\Mvc\Router\Http\Hostname;

class IndexController extends AbstractActionController
{

    private $userMapper;
    private $addressMapper;
    private $userAddressMapper;

    public function __construct(UserMapper $userMapper,
                                AddressMapper $addressMapper,
                                UserAddressesMapper $userAddressMapper)
    {
        $this->userMapper        = $userMapper;
        $this->addressMapper     = $addressMapper;
        $this->userAddressMapper = $userAddressMapper;
    }

    public function indexAction()
    {

        $filter = new \User\Model\FilterVal($this->userMapper);

        $data = [
            'username' => 'flkgfdgl',
            'email'    => 'asdasd'
        ];
        $res = $filter->getInputFilter()->setData($data)->isValid();

        var_dump($res);
        print_r($filter->getInputFilter()->getMessages());
        print_r($filter->getInputFilter()->getValues());
        die();
        $params = $this->params()->fromQuery();

        return [
            'users'  => $this->userMapper->getAllUsers($params),
            'params' => $params
        ];
    }

    public function addAction()
    {

    }

    public function doAddAction()
    {
        if(!$this->getRequest()->isPost()){
            return $this->redirect()->toRoute('user', ['action' => 'add']);
        }

        $data = $this->getRequest()->getPost();
        $user = new User();

        if($user->getInputFilter()->setData($data)->isValid()){
            $user->exchangeArray($data);
            $userID    = $this->userMapper->addUser($user);
            $addressID = $this->addressMapper->addAddress($user);

            $this->userAddressMapper->addRelation($userID, $addressID);
            $this->flashMessenger()->addMessage('User is successfully created.');

            return $this->redirect()->toRoute('user');
        }
        else{
            $this->flashMessenger()->addMessage('Some data are invalid, try again.');

            return $this->redirect()->toRoute('user', ['action' => 'add']);
        }

    }

    public function editAction()
    {
        $params = $this->params()->fromRoute();
        if(!isset($params['id'])){
            return $this->redirect()->toRoute('user', ['action' => 'add']);
        }
        $user = $this->getUser($params['id']);
        if(!$user){
            return $this->redirect()->toRoute('user');
        }

        return [
            'user' => $user
        ];
    }

    private function getUser($id)
    {
        $userData = $this->userMapper->getUserById($id);
        if(!$userData){
            return null;
        }
        $user = new User();
        $user->exchangeArray($userData);

        return $user;
    }

    public function doEditAction()
    {
        if(!$this->getRequest()->isPost()){
            return $this->redirect()->toRoute('user');
        }

        $params = $this->params()->fromRoute();
        $id     = $params['id'];
        $user   = $this->getUser($id);
        $data   = $this->params()->fromPost();

        if(!$user){
            return $this->redirect()->toRoute('user');
        }

        if($user->getInputFilter()->setData($data)->isValid()){
            $user->exchangeArray($data);
            $this->userMapper->updateUser($user);
            $this->addressMapper->updateAddress($user);
            $this->flashMessenger()->addMessage("User's are successfully changed.");

            return $this->redirect()->toRoute('user');
        }

        return $this->redirect()->toRoute('user', ['action' => 'edit', 'id' => $id]);
    }

    public function deleteAction()
    {
        $params = $this->params()->fromRoute();

        if(!isset($params['id'])){
            return $this->redirect()->toRoute('user');
        }
        $user = $this->getUser($params['id']);

        if(!$user){
            return $this->redirect()->toRoute('user');
        }

        return [
            'user' => $user
        ];
    }

    public function doDeleteAction()
    {
        $params   = $this->params()->fromRoute();
        $userData = $this->userMapper->getUserById($params['id']);

        if(!$userData){
            return $this->redirect()->toRoute('user');
        }

        if($this->getRequest()->isPost()){
            $data = $this->params()->fromPost();

            if($data['submit'] == 'Yes'){
                if($this->userMapper->deleteUser($params['id'])){
                    $this->flashMessenger()->addMessage('Users is successfully deleted.');
                }
                else{
                    $this->flashMessenger()->addMessage('Users is not deleted.');
                }
            }
        }

        return $this->redirect()->toRoute('user');
    }
}