<?php

    namespace Home\Controller;

    class LoginController extends BaseController
    {
        public function login($e = 0)
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
            }
            $this->assign('title','人人网-登录');
            $this->display('Login/login');
        }

        //生成验证码
        public function yzm()
        {
            $Verify = new \Think\Verify();
            $Verify->fontSize = 40;
            $Verify->length = 4;
            $Verify->codeSet = '0123456789';
            $Verify->entry();
        }

        //执行登录
        public function dologin()
        {
            //登录信息不能为空
            if($_POST['email'] == '' || $_POST['password'] == '' || $_POST['code'] ==''){
                $this->redirect('login\e\1');
                die;
            }

            //判断验证码
            $verify = new \Think\Verify();
            if(!$verify->check($_POST['code'])){
                $this->redirect('login\e\5');
                exit;
            }

            //检查用户
            $user = M('user');
            $data = $user->where(array('email'=>"{$_POST['email']}"))->select();
            if(empty($data)){
                $this->redirect('login\e\2');
                die;
            }else{
                //判断用户状态(是否被封禁)
                if($data[0]['status'] == 1){
                    $this->redirect('login\e\3');
                    die;
                }else{
                    //检测密码
                    if($data[0]['pwd'] == $_POST['password']){
                        session('id',$data[0]['id']);
                        $this->redirect('Index/index');
                        die;
                    }else{
                        $this->redirect('login\e\4');
                    }
                }
            }
        }

        //退出登录
        public function logout()
        {
            session(null); // 清空所有的session
            $this->redirect('Login/login');
        }
    }