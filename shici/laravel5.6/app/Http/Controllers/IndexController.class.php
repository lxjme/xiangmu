<?php
/*
 * =====================================
 * USER NAME: LXJ
 * FILE NAME: IndexController.class.php
 * FILE DESC: 古籍
 * DATE TIME: 2017-06-14 16:58:35
 * =====================================
 */
namespace Home\Controller;
use Think\Controller;
use Think\Page;

class IndexController extends Controller {
    public function index(){

        // 古诗列表
        $res_data = M('Opus')->field('id,title,author_id,author_name,f_year_id,content,f_year')->where(array('status'=>1))->limit('20,10')->order('f_weight DESC')->select();


        $this->assign('opus_data', $res_data);

        $page_basic_info = array(
            'title'         =>  '诗词文章网',
            'desc'   =>  '诗词文章网成立于2017年，旨在为对古诗词和文章感兴趣的爱好者提供好的资料。',
        );
        $this->assign('page_basic_info', $page_basic_info);

        $this->assign('crt_menu', 'recom');
        $this->display($template_name);
    }
}