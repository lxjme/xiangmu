<?php
/*
 * =====================================
 * USER NAME: LXJ
 * FILE NAME: OpusController.class.php
 * FILE DESC: 作品
 * DATE TIME: 2017-11-03 16:00:44
 * =====================================
 */
namespace Home\Controller;
use Think\Controller;
use Think\Page;

class OpusController extends Controller {

    public function _initialize() {
        $this->assign('crt_menu', 'opus');
    }

    // 作品列表
    public function index(){

        $model = M('Opus');

        if($filter_id_arr) {
            $join_arr = array();
            foreach ($filter_id_arr as $fi_k => $fi_v) {
                $alias_name = 'tto'.$fi_k;
                $join_arr[$fi_k] = "__TYPE_OPUS__ AS {$alias_name} ON {$alias_name}.opus_id = o.id AND {$alias_name}.type_id = {$fi_v['id']}";
            }
            $count = $model->table('__OPUS__ AS o')->join($join_arr)->count('*');
        } else {
            $count = $model->count('*');
        }



        $Page = new Page($count,10);
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->rollPage = 5;
        $Page->setConfig('header','共%TOTAL_ROW%条');
        $Page->setConfig('first','首页');
        $Page->setConfig('last','末页');
        $Page->lastSuffix = false;

        if($type_pin) {
            $page_type = 'Opus/'.$type_pin;
        } else {
            $page_type = 'Opus';
        }
        $show = formatLink($Page->show(),$page_type);

        if($type_pin) {
            $res_data = $model->table('__OPUS__ AS o')->join($join_arr)->field('o.id,o.title,o.author_id,o.author_name,o.f_year_id')->limit($Page->firstRow.','.$Page->listRows)->order('o.f_weight DESC')->select();
        } else {
            $res_data = $model->field('id,title,author_id,author_name,f_year_id,content,f_year')->where(array('status'=>1))->limit($Page->firstRow.','.$Page->listRows)->order('f_weight DESC')->select();
        }

        $this->assign('opus_data', $res_data);
        $this->assign('page_info',$show);

        $title = '诗词';
        if($type_id) {
            $title = $filter_param_cache[$_GET['type_pin']]['type_name'];
        }
        $page_basic_info = array(
            'title'         =>  $title.'-'.C('WEB_SITE_NAME'),
        );
        $this->assign('page_basic_info', $page_basic_info);
        $this->display();
    }


    /**
     * 作品详细
     * @return [type] [description]
     */
    public function detail() {
        $id = $_GET['id'];
        $opus_data = M('Opus')->where(array('id'=>$id))->field('id,title,author_id,author_name,f_year_id,content,f_year')->find();

        $this->assign('opus_data', $opus_data);

        // 作品解析
        $info_data = M('OpusOther')->where(array('opus_id'=>$id))->field('opus_other,opus_other_short,cankao')->select();

        $this->assign('info_data', $info_data);

        $this->assign('foot_js', array('index'));
        $page_basic_info = array(
            'title'         =>  $opus_data['title'].'-'.C('WEB_SITE_NAME'),
            'desc'   =>  mb_substr($opus_data['content'], 0, 100, 'utf-8'),
        );
        $this->assign('page_basic_info', $page_basic_info);
        $this->display();
    }


}