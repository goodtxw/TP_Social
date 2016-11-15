<?php
    namespace Home\Controller;

    class EmailCheckController extends BaseController
    {
        public function config()
        {
            if (send_mail('376522507@qq.com', '点击链接激活', '点击链接激活')) {
                echo '发送成功';
            }else {
                echo '发送失败';
            }
        }
    }