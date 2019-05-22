<?php
/*
 * =====================================
 * USER NAME: LXJ
 * FILE NAME: AuthorController.class.php
 * FILE DESC: 作者信息
 * DATE TIME: 2017-10-28 08:51:20
 * =====================================
 */
namespace Home\Controller;
use Think\Controller;
use Think\Page;

class AuthorController extends Controller {

    public function _initialize() {
        $this->assign('crt_menu', 'author');
    }

    // 作者列表
    public function index(){

        $model = M('Author');

        $where = array();
        $where['is_show'] = 1;
        if($type_id) {
            $where['f_year_id'] = $type_id;
        }

        $count = $model->where($where)->count('*');
        $Page = new Page($count,10);
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->rollPage = 5;
        $Page->setConfig('header','共%TOTAL_ROW%条');
        $Page->setConfig('first','首页');
        $Page->setConfig('last','末页');
        $Page->lastSuffix = false;

        if($type_id) {
            $page_type = 'Author/'.$_GET['type_pin'];
        } else {
            $page_type = 'Author';
        }

        $show = formatLink($Page->show(),$page_type);

        $res_data = $model->field('id,author_name,f_year,author_desc,img_url')->where($where)->order('f_weight desc')->limit($Page->firstRow.','.$Page->listRows)->select();


        $this->assign('author_data', $res_data);
        $this->assign('page_info',$show);

        $title = '诗人大全';
        if($type_id) {
            $title = $filter_param_cache[$_GET['type_pin']]['type_name'].'诗人';
        }
        $page_basic_info = array(
            'title'         =>  $title.'-'.C('WEB_SITE_NAME'),
        );
        $this->assign('page_basic_info', $page_basic_info);
        $this->display();
    }


    /**
     * 作者详细
     * @return [type] [description]
     */
    public function detail() {
        $id = $_GET['id'];
        $author_data = M('Author')->where(array('id'=>$id))->field('id,author_name,f_year,f_year_id,img_url,author_desc,author_name')->find();
        $this->assign('author_data', $author_data);

        $info_data = M('AuthorDetail')->where(array('author_id'=>$id))->field('id,author_other,author_other_short')->select();

        $this->assign('info_data', $info_data);

        $this->assign('foot_js', array('index'));
        $page_basic_info = array(
            'title'         =>  $author_data['author_name'].'-'.C('WEB_SITE_NAME'),
            'desc'   =>  mb_substr($author_data['author_desc'], 0, 100, 'utf-8'),
        );
        $this->assign('page_basic_info', $page_basic_info);
        $this->display('author_detail');
    }

    public function authorDetail() {
        $this->detail();
    }


}