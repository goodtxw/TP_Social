<?php

    namespace Home\Controller;

    use Home\Model\ArticleModel;
    use Home\Model\FriendGroupModel;
    use Home\Model\FriendModel;

    class IndexController extends BaseController
    {
        public function index()
        {
            // 当前登录的用户id
            $u_id = 1;
            // 查找当前用户的信息
            $user = M('user')->where(['id' => ['eq', $u_id]])->find();
            // 好友id字符串
            $friend = '';
            // 查询好友id
            $friendGroup = new FriendGroupModel();
            $fg = $friendGroup->relation(true)->where(['u_id' => ['eq', $u_id]])->find();
            // 遍历
            foreach ($fg['Friend'] as $k => $v) {
                $friend .= $v['friend_id'] . ',';
            }
            // 将自己加入
            if ($friend != '') {
                $friend .= $u_id;
            } else {
                $friend = $u_id;
            }

            // 根据用户的id查询文章 已时间倒叙排序
            $article = new ArticleModel();
            $ar = $article->relation(true)->where(['u_id' => ['in', $friend]])->order('time desc')->select();

            // 查找评论用户的name与image
            $comment_user = [];
            foreach ($ar as $k=>$v){
                foreach ($v['Comment'] as $key=>$value){
                    $comment_user[$v['id']][$value['id']] = M('user')->where(['id'=>['eq',$value['u_id']]])->select();
                }
            }

//            echo '<pre>';var_dump($ar);exit;
//            echo '<pre>';var_dump($comment_user);exit;
            $this->assign('article', $ar);
            $this->assign('cuser', $comment_user);
            $this->assign('user', $user);
            $this->display();
        }

        public function subArt()
        {
            $data = Array();
            // 用户id
            // $data['u_id'] = $_SESSION[''];
            $data['u_id'] = 1;
            // 内容
            $data['content'] = $_POST['content'];
            // 是否公开
            $data['privacy'] = $_POST['privacy'];
            $data['time'] = time();
            $art = M('article');
            if ($insertId = $art->add($data)) {
                // 图片名
                $img = explode(',', $_POST['img']);
                array_pop($img);
                if (count($img) > 0) {
                    $album = M('album');
                    // 查找新上传图片相册的id 不存在则创建
                    if (!($album_id = $album->where(['name' => ['eq', '新上传图片']])->getField('id'))) {
                        $data = Array();
                        // $data['u_id'] = $_SESSION[''];
                        $data['u_id'] = 1;
                        $data['name'] = '新上传图片';
                        $data['time'] = time();
                        if ($album_id = $album->add($data)) {
                            $image = M('image');
                            $data = Array();
                            foreach ($img as $k=>$v) {
                                $data[$k]['name'] = $v;
                                // 相册id
                                $data[$k]['album_id'] = $album_id;
                                // 文章id
                                $data[$k]['article_id'] = $insertId;
                                if ($k == 0) {
                                    $data[$k]['cover'] = 1;
                                }else {
                                    $data[$k]['cover'] = 0;
                                }

                                $data[$k]['time'] = time();
                                // 用户id
                                // $data['u_id'] = $_SESSION[''];
                                $data[$k]['u_id'] = 1;
                            }
                            if ($image->addAll($data)){
                                echo 'suc';
                            }else {
                                echo 'err';
                            }
//                            var_dump($data);
                        }
                    } else {
                        $image = M('image');
                        $data = Array();
                        foreach ($img as $k=>$v) {
                            // 文章id
                            $data[$k]['article_id'] = $insertId;
                            // 相册id
                            $data[$k]['album_id'] = $album_id;
                            // 用户id
                            // $data['u_id'] = $_SESSION[''];
                            $data[$k]['u_id'] = 1;
                            $data[$k]['name'] = $v;
                            $data[$k]['time'] = time();
                        }
                        if ($image->addAll($data)){
                            echo 'suc';
                        }else {
                            echo 'err3';
                        }
                    }
                }else {
                    echo 'err2';
                }
            }else {
                echo 'err1';
            }
        }
    }