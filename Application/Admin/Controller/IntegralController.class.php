<?php

    namespace Admin\Controller;
    use Admin\Model\IntegralModel;
    use Admin\Model\UserModel;
    use Think\Controller;
    use Think\Page;

    class IntegralController extends Controller
    {
        // 显示每个用户的所有积分
        public function index()
        {
            $inte = new IntegralModel();
            $data = $inte->relation(true)->field(array('sum(integral)'=>'suminte','u_id'))->group('u_id')->select();
//var_dump($data);exit;
            $count = count($data);
            $page = new Page($count,1);
            $show = $page->show();
            $this->assign('list', $data);
            $this->assign('page', $show);
            $this->display();
        }

        // 显示单个用户的积分详情
        public function list($id)
        {
            $inte = new IntegralModel();
            // 根据用户id获取用户的积分详情
            $data = $inte->relation(true)->where(['u_id'=>['eq', $id]])->select();

            $this->assign('list', $data);
            $this->display();
        }
    }