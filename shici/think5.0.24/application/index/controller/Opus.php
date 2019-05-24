<?php
/*
 * =====================================
 * USER NAME: LXJ
 * FILE NAME: OpusController.class.php
 * FILE DESC: 作品
 * DATE TIME: 2017-11-03 16:00:44
 * =====================================
 */
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Config;

class Opus extends Controller {

    public function _initialize() {
        $this->assign('crt_menu', 'opus');
    }

    // 作品列表
    public function index(){

        $model = Db::name('Opus');
        
        $res_data = $model->field('id,title,author_id,author_name,f_year_id,content,f_year')->where(array('is_show'=>1))->order('f_weight DESC')->paginate();

        $this->assign('opus_data', $res_data);

        $title = '诗词';
        $page_basic_info = array(
            'title'         =>  $title.'-'.Config::get('web_site_name'),
        );
        $this->assign('page_basic_info', $page_basic_info);
        return $this->fetch();

    }


    /**
     * 作品详细
     * @return [type] [description]
     */
    public function detail($id) {
        $opus_data = Db::name('opus')->where(array('id'=>$id))->field('id,title,author_id,author_name,f_year_id,content,f_year')->find();

        $this->assign('opus_data', $opus_data);

        // 作品解析
        $info_data = Db::name('OpusOther')->where(array('opus_id'=>$id))->field('opus_other,opus_other_short,cankao')->select();

        $this->assign('info_data', $info_data);

        $this->assign('foot_js', array('index'));
        $page_basic_info = array(
            'title'         =>  $opus_data['title'].'-'.Config::get('web_site_name'),
            'desc'   =>  mb_substr($opus_data['content'], 0, 100, 'utf-8'),
        );
        $this->assign('page_basic_info', $page_basic_info);
        return $this->fetch();
        
    }


}