<?php
namespace Home\Controller;
use Home\Model\AlbumModel;

class AlbumController extends BaseController
{
    public function index()
    {
        //个人的基本信息
        $personal_info = M('user')->where(array('id'=>session('id')))->select();
        //用户注册天数 intval((当前时间-注册时间)/一天的秒数) 一天86400秒
        $date = intval((time()-$personal_info[0]['create_time'])/86400);
        //用户的相册信息
        $album = new AlbumModel();
        $image =$album->relation(true)->where(array('u_id'=>session('id')))->select();

        $this->assign('date',$date);
        $this->assign('info',$personal_info[0]);
        $this->assign('image',$image);
        $this->display();
    }

    //相册详情
    public function detail()
    {
        //个人的基本信息
        $personal_info = M('user')->where(array('id'=>session('id')))->select();
        //用户注册天数 intval((当前时间-注册时间)/一天的秒数) 一天86400秒
        $date = intval((time()-$personal_info[0]['create_time'])/86400);
        //照片信息
        $image = M('image')->where(array('album_id'=>$_GET['id']))->select();

        $this->assign('date',$date);
        $this->assign('image',$image);
        $this->assign('info',$personal_info[0]);
        $this->display();
    }
}