<?php

namespace Admin\Controller;
use Think\Controller;

class PasswordController extends CommonController
{
    public function index($s = 0)
    {
        if($s == 1){
            $this->assign('success',1);
        }elseif ($s == 2){
            $this->assign('success',2);
        }
        $data = M('admin')->where(array('id'=>session('id')))->select();
        $this->assign('data',$data[0]);
        $this->display();
    }

    //修改密码
    public function pass()
    {
        $data = M('admin')->where(array('id'=>session('id')))->select();
        if($data[0]['pwd'] == $_POST['oldpass']){
            M('admin')->pwd = $_POST['newpass'];
            M('admin')->where(array('id'=>session('id')))->save();
            $this->redirect('index\s\1');
        }else{
            $this->redirect('index\s\2');
        }
    }
}