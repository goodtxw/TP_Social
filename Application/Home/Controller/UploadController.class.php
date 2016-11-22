<?php
    namespace Home\Controller;

    use Think\Upload;

    class UploadController extends BaseController
    {
        // 上传文件
        public function upload()
        {
            $upload = new Upload();
            //使用子目录保存文件 默认true
            $upload->autoSub = false;
            // 设置附件上传根目录
            $upload->rootPath  = C('LOCAL_PATH') .'/upload/';
            // 上传文件
            $info  =  $upload->upload();
            if(!$info) {
                // 上传错误提示错误信息 $upload->getError()
                echo $upload->getError();
            }else{
                // 上传成功
                echo json_encode(['code'=>1,'content'=>$info]);
            }
        }

        // 删除文件
        public function delete($name,$key)
        {
            if (unlink(C('LOCAL_PATH') . '/upload/' . $name)) {
                echo 0;
            }else {
                echo 1;
            }
        }
    }