<?php

namespace Blog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Blog\Service\PostServiceInterface;


class ListController extends AbstractActionController{
    /**
     * @var \Blog\Service\PostServiceInterface
     */
    protected $postService;

    public function __construct(PostServiceInterface $postService)
    {
        $this->postService = $postService;
    }

    public function indexAction()
    {
        //$this->getTaskMapper();
        return [
            "posts" => $this->postService->findAllPosts()
        ];
    }
}