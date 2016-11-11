<?php

namespace Admin\Controller;
use Think\Controller;

class IndexController extends Controller
{
    public function index()
    {
        if(session('?id')){
            $data = M('admin')->where(array('id'=>session('id')))->select();
            $data1 = $data[0]['name'];
            $this->assign('data1',$data1);
            $this->redirect('Index/index');
        }else{
            $this->redirect('Login/login');
        }
    }
}