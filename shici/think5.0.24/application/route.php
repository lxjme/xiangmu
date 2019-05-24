<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Route;

Route::get([
    'Author$'    =>  'index/Author/index',   // 诗人列表
    'Author/detail_<id>$' => ['index/Author/detail',['id'=>'\d+']], // 诗人详情

    'Opus$'    =>  'index/Opus/index',   // 作品列表
    'Opus/detail_<id>$' => ['index/Opus/detail',['id'=>'\d+']], // 作品详情

    'Guwen$'    =>  'index/Guwen/index',   // 古文列表
    'Guwen/artList_<id>$' => ['index/Guwen/artList',['id'=>'\d+']], // 古文栏目列表
    'Guwen/artDetail_<id>$' => ['index/Guwen/artDetail',['id'=>'\d+']], // 古文栏目列表

    'Shuji$'    =>  'index/Shuji/index',   // 书籍列表
    'Shuji/artList_<id>$' => ['index/Shuji/artList',['id'=>'\d+']], // 书籍栏目列表
    'Shuji/artDetail_<id>$' => ['index/Shuji/artDetail',['id'=>'\d+']], // 书籍栏目列表
]);
