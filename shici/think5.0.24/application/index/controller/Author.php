<?php
/*
 * =====================================
 * USER NAME: LXJ
 * FILE NAME: AuthorController.class.php
 * FILE DESC: 作者信息
 * DATE TIME: 2017-10-28 08:51:20
 * =====================================
 */
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Config;

class Author extends Controller {

    public function _initialize() {
        $this->assign('crt_menu', 'author');
    }

    // 作者列表
    public function index(){
        $model = Db::name('author');
        $where = array();
        $where['is_show'] = 1;

        $res_data = $model->field('id,author_name,f_year,author_desc,img_url')->where($where)->order('f_weight desc')->paginate(5);

        $this->assign('author_data', $res_data);


        $title = '诗人大全';
        $page_basic_info = array(
            'title'         =>  $title.'-'.Config::get('web_site_name'),
        );
        $this->assign('page_basic_info', $page_basic_info);

        return $this->fetch('index');
    }

    /**
     * 作者详细
     * @return [type] [description]
     */
    public function detail($id) {
        $author_data = Db::name('author')->where(array('id'=>$id))->field('id,author_name,f_year,f_year_id,img_url,author_desc,author_name')->find();
        $this->assign('author_data', $author_data);

        $info_data = Db::name('AuthorDetail')->where(array('author_id'=>$id))->field('id,author_other,author_other_short')->select();

        $this->assign('info_data', $info_data);

        $this->assign('foot_js', array('index'));
        $page_basic_info = array(
            'title'         =>  Config::get('web_site_name'),
            'desc'   => '',
        );
        $this->assign('page_basic_info', $page_basic_info);
        return $this->fetch('author_detail');
    }

    public function authorDetail() {
        $this->detail();
    }


}