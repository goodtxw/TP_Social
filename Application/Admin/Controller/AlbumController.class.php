<?php

    namespace Admin\Controller;

    use Admin\Model\AlbumModel;

    class AlbumController extends CommonController
    {
        public function index()
        {
            $album = new AlbumModel();
            $list = $album->relation(true)->select();
//            echo '<pre>';var_dump($list);exit;
            $this->assign('list', $list);
            $this->display();
        }
    }