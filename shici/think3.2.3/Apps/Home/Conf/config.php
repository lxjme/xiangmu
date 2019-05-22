<?php
return array(

	'HTML_CACHE_TIME'=>0,
		//'配置项'=>'配置值'
	'HTML_CACHE_RULES'  =>  array(
	    'Index:'=>array('Index_{:action}'),
	    'Author:index'=>array('Author/{:action}/list_{$_GET.p}{$_GET.type_pin}'),	// 作者列表
	    'Author:detail'=>array('Author/{:action}/{$_GET.id}'),	// 作者详情
	    'Opus:index'=>array('Opus/{:action}/list_{$_GET.p}{$_GET.type_pin}'),	// 作品列表
	    'Opus:detail'=>array('Opus/{:action}/{$_GET.id}'),	// 作品详情
	    'Guwen:index'=>array('Guwen/{:action}/list_{$_GET.p}{$_GET.type_pin}'),	// 古籍列表
	    'Guwen:artList'=>array('Guwen/{:action}/{$_GET.id}'),	// 古籍篇章列表
	    'Guwen:artDetail'=>array('Guwen/{:action}/{$_GET.id}'),	// 古籍篇章详情
	    'Shuji:index'=>array('Shuji/{:action}/list_{$_GET.p}{$_GET.type_pin}'),	// 古籍列表
	    'Shuji:artList'=>array('Shuji/{:action}/{$_GET.id}'),	// 古籍篇章列表
	    'Shuji:artDetail'=>array('Shuji/{:action}/{$_GET.id}'),	// 古籍篇章详情
	    // 'Index'=>'index',
	),

	// 开启路由
	'URL_ROUTER_ON'				 =>	true,
	// 'URL_MAP_RULES'=>array(
	//     // 企业
	//     'Company/mingqi'		=> 'Company/index?recommend=1',	// 名企招聘
	//     'Company/rezhao'		=> 'Company/index?hot=1',			// 热招企业
	// 	'Company/keyword/小时工' 	=> 'Company/index?hour_work=1',		// 小时工
	//     'Company/zuixin'		=> 'Company/index?is_new=1',	// 最新招聘
	//     'guess_age'				=> 'News/subject?type=zt_1003',	// 专题 照片猜年龄
	//     'qipa'				=> 'News/subject?type=zt_1004',	// 这些逗B事儿，99%的人都知道
	//     'zhuxue'       			=> 'Dynamic/subject?type=zt_1004',		// 助学扶贫，放飞梦想
	//     'active/active_baozi2'  => 'Static/subject?type=zt_1005',		// 助学扶贫，放飞梦想

	//    	// 首页搜索页面
	//     'search'				=> 'Index/search',	// 搜索
	// ),
	'URL_ROUTE_RULES' => array( //定义路由规则
		// 'News/:type_id\d'     => 'News/index',
		// 'News/detail_n/:id\d' => 'News/detail',
		// 'Company/:id\d'       => 'Company/info',
		// 'Store/:sid\d'        => 'Store/info',
		'/^Opus\/(?!detail)(\w*)$/' => 'Opus/index?type_pin=:1',	// 作品分类
		'/^Opus\/detail_(\d*)$/' => 'Opus/detail?id=:1',	// 作品详情
		'/^Guwen\/(?!(artList|artDetail))(\w*)$/' => 'Guwen/index?type_pin=:1',	// 书籍分类
		'/^Guwen\/artList_(\d*)$/' => 'Guwen/artList?id=:1',	// 书籍篇章列表
		'/^Guwen\/artDetail_(\d*)$/' => 'Guwen/artDetail?id=:1',	// 书籍篇章详情
		'/^Shuji\/(?!(artList|artDetail))(\w*)$/' => 'Shuji/index?type_pin=:1',	// 书籍分类
		'/^Shuji\/artList_(\d*)$/' => 'Shuji/artList?id=:1',	// 书籍篇章列表
		'/^Shuji\/artDetail_(\d*)$/' => 'Shuji/artDetail?id=:1',	// 书籍篇章详情
		'/^Author\/(?!detail|authorDetail)(\w*)$/' => 'Author/index?type_pin=:1',	// 作者分类
		'/^Author\/detail_(\d*)$/' => 'Author/detail?id=:1',	// 作者详情
		// '/^Store\/province-(\d{1,8})$/'                => 'Store/index?province=:1',	// 通过市区ID查询门店
		// '/^Company\/c(\d{1,8})-s([\d-]+)$/'            => 'Company/index?city=:1&salary=:2',	// 市区-薪资
		// '/^Company\/s([\d-]+)-c(\d{1,8})$/'            => 'Company/index?city=:2&salary=:1',	// 市区-薪资
		// '/^Company\/c(\d{1,8})$/'                      => 'Company/index?city=:1',	// 市区
		// '/^Company\/s([\d-]+)$/'                       => 'Company/index?salary=:1',	// 薪资
	 //    'GyqTopic/:id\d'    => 'GyqTopic/detail',
	),
);