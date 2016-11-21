<?php
    namespace Home\Controller;

    class EmailCheckController extends BaseController
    {
        public function config()
        {
            if (send_mail('1411064812@qq.com', '点击链接激活', '点击链接激活')) {
                echo '发送成功';
            }else {
                echo '发送失败';
            }
        }
    }