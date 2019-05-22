<?php
return array(
	'DATA_CACHE_SUBDIR'	=> true,
	//'配置项'=>'配置值'
	'DEFAULT_MODULE'	=> 'Home',
	'MODULE_ALLOW_LIST'    	=>  array('Home','Admin'),
	'TMPL_PARSE_STRING'  	=>	array(
	     '__HOME__' 	=> '/Public/Home',
	),
   	'URL_CASE_INSENSITIVE'  =>  false,  // URL区分大小写

	// 错误页面返回首页
	'ERROR_PAGE'		=>	'/Empty',

	// 网站名称
	'WEB_SITE_NAME'	=>	'诗词文章网',

);