<?php

namespace Admin\Controller;
use Think\Controller;

class IndexController extends Controller
{
    public function index()
    {
        if(!empty(session('id'))){
            $data = M('admin')->where(array('id'=>session('id')))->select();
            $data1 = $data[0]['name'];
            if($data[0]['level'] == 0){
                $this->assign('data1','欢迎管理员'.$data1);
            }else{
                $this->assign('data1','欢迎超级管理员'.$data1);
            }
            $this->display('Index/index');
        }else{
            $this->redirect('Login/login');
        }
    }
}