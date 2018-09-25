<?php

// 加载视图函数  view('index/index')
function view($file,$data=[])
{
    extract($data);
    include ROOT."view/".$file.".html";
}