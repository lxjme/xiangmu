<?php
/*
 * =====================================
 * USER NAME: LXJ
 * FILE NAME: EmptyController.class.php
 * FILE DESC: 空控制器404
 * DATE TIME: 2017-07-25 09:43:29
 * =====================================
 */
namespace Home\Controller;
use Think\Controller;
class EmptyController extends Controller{
    public function index(){
        $page_basic_info = array(
			'page_title'		=>	"404页面",
			'title'		=>	"404页面-".C('WEB_SITE_NAME'),
		);
		$this->assign('page_basic_info', $page_basic_info);

		$this->display('Public/error');
    }
}
