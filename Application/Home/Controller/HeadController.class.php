<?php
namespace Home\Controller;

class HeadController extends BaseController
{
    public function index()
    {
        //个人的基本信息
        $personal_info = M('user')->where(array('id'=>session('id')))->select();
        //用户注册天数 intval((当前时间-注册时间)/一天的秒数) 一天86400秒
        $date = intval((time()-$personal_info[0]['create_time'])/86400);
        $link = M('flink')->where(array('show'=>1))->select();
        $this->assign('link',$link);
        $this->assign('date',$date);
        $this->assign('info',$personal_info[0]);
        $this->display();
    }
}