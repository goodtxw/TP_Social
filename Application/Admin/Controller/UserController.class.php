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

    //执行添加
    public function doadd()
    {
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize = 3145728 ;// 设置附件上传大小
        $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath = './Public/'; // 设置附件上传根目录
        $upload->savePath = 'admin/'; // 设置附件上传（子）目录
        $upload->saveName = array('uniqid','');//图片名称,采用uniqid函数生成一个唯一的字符串序列
        $upload->autoSub  = true;//自动使用子目录保存上传文件 默认为true
        $upload->subName  = 'images';//子目录创建方式，采用数组或者字符串方式定义

        // 上传文件
        $info = $upload->upload();
        // 上传错误提示错误信息
        if(!$info) {
            $this->error($upload->getError());
            die;
        }

        $data = [];
        $data['name'] = $_POST['name'];
        $data['pwd'] = $_POST['password'];
        $data['sex'] = $_POST['sex'];
        $data['head_image'] = $info['img']['savename'];
        $data['status'] = 0;//状态(默认启用)
        $data['create_time'] = time();
        $data['privacy'] = 1;//用户前台信息状态(默认陌生人不可见)

        //实例化对象
        $user = M('user');
        //过滤数据,数据验证
        if (!$user->create($data)) {
            //如果创建数据失败,表示验证没有通过
            //输出错误信息 并且跳转
            $this->error($user->getError());
        } else {
            //验证通过 执行添加操作
            //执行添加
            if ($user->add($data) > 0) {
//                $this->success('恭喜您,添加成功!', U('index'));
                $this->redirect('add\s\1');
            } else {
//                $this->error('添加失败....');
                $this->redirect('add\s\2');
            }
        }
    }

    //添加页面
    public function add($s = 0)
    {
        if($s == 1){
            $this->assign('success',1);
        }elseif ($s == 2){
            $this->assign('success',2);
        }
        $this->display('User/add');
    }
}