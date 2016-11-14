<?php

    namespace Admin\Controller;

    use Admin\Model\AlbumModel;

    class AlbumController extends CommonController
    {
        // 相册列表
        public function index()
        {
            $album = new AlbumModel();
            $list = $album->relation(true)->select();
//            echo '<pre>';var_dump($list);exit;
            $this->assign('list', $list);
            $this->display();
        }

        // 查看相册中的图片
        public function albumDetial($id)
        {
            $album = new AlbumModel();
            $list = $album->relation(['imageDetial', 'User'])->where(['id' => ['eq', $id]])->select();
//            echo '<pre>';var_dump($list);exit;
            $this->assign('list', $list);
            $this->display();
        }

        // 违规图片的封禁
        public function ban($imageId)
        {
            // 根据图片的id取得图片的名称
            $image = M('image');
            $date = $image->find($imageId);
            // 拼接图片的完整路径
            $filename = C('LOCAL_PATH').'/admin/images/' . $date['name'];

            // 删除文件
            if (unlink($filename)) {
                // 替换图片
                $img = [];
                $img['name'] = 'passcode.jpg';
                $img['ban'] = 1;
                $image->where(['id'=>['eq', $imageId]])->save($img);

                $re = [];
                $re[] = 0;
                // 返回替换后图片的路径
                $re[] = C('Public').'/admin/images/' . $img['name'];
            }else {
                $re = [];
                $re[] = 1;
                $re[] = '封禁失败';
            }

            echo json_encode($re);
        }
    }