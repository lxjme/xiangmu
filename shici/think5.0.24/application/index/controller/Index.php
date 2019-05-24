<?php
namespace app\index\controller;

use think\Controller;

class Index extends Controller
{
    public function index()
    {
        // 古诗列表
        $res_data = db('opus')->field('id,title,author_id,author_name,f_year_id,content,f_year')->where(array('is_show'=>1))->limit('10,10')->order('f_weight DESC')->select();

        $this->assign('opus_data', $res_data);

        $this->assign('crt_menu', 'recom');


        $page_basic_info = array(
            'keys'      => '',
            'title'         =>  '诗词文章网',
            'desc'   =>  '诗词文章网成立于2017年，旨在为对古诗词和文章感兴趣的爱好者提供好的资料。',
        );

        $this->assign('page_basic_info', $page_basic_info);

        return $this->fetch('index');
    }
}
