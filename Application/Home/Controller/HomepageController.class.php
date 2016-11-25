<?php

namespace Home\Controller;

class HomepageController extends BaseController
{
    public function index()
    {
        $user = M('user');
        //个人的基本信息
        $personal_info = $user->where(array('id'=>session('id')))->select();
        //用户注册天数 intval((当前时间-注册时间)/一天的秒数) 一天86400秒
        $date = intval((time()-$personal_info[0]['create_time'])/86400);

        //他人信息
        $other_info = $user->where(array('id'=>$_GET['u_id']))->select();
        if($other_info[0]['status'] == 1){//用户被禁用
            $this->error('该用户已被封禁');
        }
        //判断是否为本人，本人直接遍历所有信息，否则要判断权限(privacy 0所有人可见 1好友可见 2仅自己可见)
//        if($_GET['u_id'] == session('id')){
//
//        }else{
//            if($other_info[0]['privacy'] == 0){//所有人可见，直接遍历所有信息
//
//            }elseif ($other_info[0]['privacy'] == 1){//好友可见，再判断是否为好友
//                if(){
//
//                }else{
//
//                }
//            }else{//仅自己可见，跳转404页面
//                $this->error('该用户已设置权限仅自己可见');
//            }
//        }

        //说说数量
        $link = M('flink')->where(array('show'=>1))->select();
        $this->assign('link',$link);
        $this->assign('date',$date);
        $this->assign('info',$personal_info[0]);
        $this->assign('title','个人主页');
        $this->display();
    }
}