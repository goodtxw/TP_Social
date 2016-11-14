<?php

namespace Admin\Controller;
use Think\Controller;
use Think\Page;

class UserController extends Controller
{
    //用户列表
    public function index()
    {
        // 分页
        $count = M('user')->count();
        // 设置分页  总页数/每页数量
        $page = new Page($count,4);
        // 设置上一页下一页
        $page->setConfig('prev', '上一页');
        $page->setConfig('next', '下一页');
        // 显示分页
        $show = $page->show();
        // 按照分页查询数据
        $list = M('user')->limit($page->firstRow.','.$page->listRows)->order('id desc')->select();
        $this->assign('list', $list);
        $this->assign('page', $show);
        $this->assign('title','用户列表');
        $this->display('User/index');
    }

    //封禁、解封
    public function ban($id)
    {
        //接收ID
        $id = I('get.id/d');
        $data = M('user')->where(array('id'=>$id))->select();
        //启用状态
        if($data[0]['status'] == 0){
            $data[0]['status'] = 1;
            M('user')->where(array('id'=>$id))->save($data[0]);
            $this->redirect('User/index');
            die;
        }
        //禁用状态
        if($data[0]['status'] == 1){
            $data[0]['status'] = 0;
            M('user')->where(array('id'=>$id))->save($data[0]);
            $this->redirect('User/index');
            die;
        }
    }

    //用户详情
    public function detail()
    {
        //接收ID
        $id = I('get.id/d');
        //查询数据
        $data = M('user')->where(array('id'=>$id))->select();
//        var_dump($data[0]);die;
        $this->assign('data',$data[0]);
        $this->display('User/info');
    }

    //搜索
    public function search()
    {
        if($_POST['sex'] == '' && $_POST['status'] == '' && $_POST['name'] == ''){
            $data = M('user')->order('id desc')->select();
            $this->assign('title','用户列表');
            $this->assign('list',$data);
            $this->redirect('User/index');
            die;
        }
        //模糊查询
        $map = [];
//        $map['sex'] = $_POST['sex']==''?'':$_POST['sex'];
//        $map['status'] = $_POST['status'];
        $map['name'] = ['like',"%{$_POST['name']}%"];

        $list = M('user')->where($map)->select();
        $this->assign('title','用户列表');
        $this->assign('list',$list);
        $this->assign('page','搜索分页会刷新');
        $this->display('User/index');
    }
}