<?php
namespace Home\Controller;

class FriendlistController extends BaseController
{
    public function index()
    {
        $this->display();
    }

    //访客列表
    public function visitor()
    {
        $this->display();
    }
}