<?php

namespace Admin\Controller;
use Think\Controller;

class UserController extends Controller
{
    //用户列表
    public function index()
    {

        $data = M('user')->order('id desc')->select();
        $this->assign('title','用户列表');
        $this->assign('list',$data);
        $this->display('User/index');
    }
}