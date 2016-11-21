<?php

namespace Home\Controller;

class PasswordController extends BaseController
{
    public function index($e = 0)
    {
        if($e == 1){
            $this->assign('error',1);
        }elseif ($e == 2){
            $this->assign('error',2);
        }elseif ($e == 3){
            $this->assign('error',3);
        }elseif ($e == 4){
            $this->assign('error',4);
        }elseif ($e == 5){
            $this->assign('error',5);
        }elseif ($e == 6){
            $this->assign('error',6);
        }elseif ($e == 7){
            $this->assign('error',7);
        }

        $personal_info = M('user')->where(array('id'=>session('id')))->select();
        $date = intval((time()-$personal_info[0]['create_time'])/86400);

        $this->assign('date',$date);
        $this->assign('info',$personal_info[0]);
        $this->display();
    }

    //修改密码
    public function password()
    {
        //原密码
        if($_POST['oldpwd'] == ''){
            $this->redirect('Password/index?e=1');
            die;
        }
        //新密码
        if($_POST['newpwd'] == ''){
            $this->redirect('Password/index?e=2');
            die;
        }
        //确认新密码
        if($_POST['newpwd2'] == ''){
            $this->redirect('Password/index?e=3');
            die;
        }
        //检查原密码
        $data = M('user')->where(array('id'=>session('id')))->select();
        if($data[0]['pwd'] != $_POST['oldpwd']){
            $this->redirect('Password/index?e=4');
            die;
        }
        //判断两次密码是否相同
        if($_POST['newpwd'] != $_POST['newpwd2']){
            $this->redirect('Password/index?e=5');
            die;
        }
        //正则匹配密码
        if(!preg_match('/^[a-zA-Z0-9]{6,10}$/',$_POST['newpwd'])){
            $this->redirect('Password/index?e=6');
            die;
        }

        //执行修改
        M('user')->pwd = $_POST['newpwd'];
        M('user')->where(array('id'=>session('id')))->save();
        $this->redirect('Password/index?e=7');
    }
}