<?php

namespace Home\Controller;

class HomepageController extends BaseController
{
    public function index()
    {
        //实例化对象
        $user = M('user');
        //个人的基本信息
        $personal_info = $user->where(array('id'=>session('id')))->select();
        //用户注册天数 intval((当前时间-注册时间)/一天的秒数) 一天86400秒
        $date = intval((time()-$personal_info[0]['create_time'])/86400);

        $this->assign('date',$date);
        $this->assign('info',$personal_info[0]);
        $this->assign('title','个人主页');
        $this->display();
    }
}