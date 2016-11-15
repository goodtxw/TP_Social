<?php

namespace Admin\Controller;
use Think\Controller;

class ArticleController extends Controller
{
    public function index()
    {
        $this->display('Article/index');
    }

    public function info()
    {
        $this->display('Article/info');
    }
}