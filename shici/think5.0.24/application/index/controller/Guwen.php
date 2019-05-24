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

class Guwen extends Controller {

    public function _initialize() {
        $this->assign('crt_menu', 'guwen');
    }

    // 作品列表
    public function index(){

        $model = Db::name('Books');

        $res_data = $model->field('f_id,f_book_name,f_book_desc,f_book_fm')->paginate();



        $this->assign('book_data', $res_data);

        $title = '古文';
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
    public function artList($id) {
        if(empty($id)) {
            redirect('/Guwen');
        }


        $lanmu_count = Db::name('BooksLanmu')->where(array('book_id'=>$id))->count('*');

        $article_res = Db::name('BooksArticle')->where(array('book_id'=>$id))->field('id,title,lanmu_id')->select();
        if($lanmu_count > 0) {
            $lanmu_res = array_column(Db::name('BooksLanmu')->where(array('book_id'=>$id))->field('id,book_id,lanmu_name')->select(), null, 'id') ;

            foreach ($article_res as $key => $val) {
                $article_list[$val['lanmu_id']]['lanmu_name'] = $lanmu_res[$val['lanmu_id']]['lanmu_name'];
                $article_list[$val['lanmu_id']]['list'][$val['id']]['id'] = $val['id'];
                $article_list[$val['lanmu_id']]['list'][$val['id']]['title'] = $val['title'];
            }
        } else {
            foreach ($article_res as $key => $val) {
                $article_list[$val['lanmu_id']]['list'][$val['id']]['id'] = $val['id'];
                $article_list[$val['lanmu_id']]['list'][$val['id']]['title'] = $val['title'];
            }
        }



        $book_res = Db::name('Books')->where(array('f_id'=>$id))->field('f_book_fm,f_book_desc,f_book_name')->find();

        $this->assign('article_data', $book_res);
        $this->assign('article_list', $article_list);


        $book_title = Db::name('Books')->where(array('f_id'=>$id))->value('f_book_name');
        $title = $book_title.'全文';
        $page_basic_info = array(
            'title'         =>  $title.'-'.Config::get('web_site_name'),
        );
        $this->assign('page_basic_info', $page_basic_info);

        return $this->fetch('art_list');
    }


    // 文章详情
    public function artDetail($id) {
        if(empty($id)) {
            redirect('/Guwen');
        }
        $article_data = Db::name('BooksArticle')->where(array('id'=>$id))->field('title,content,fanyi')->find();


        $this->assign('article_data', $article_data);


        $book_title = Db::name('BooksArticle')->alias('ba')->join('__BOOKS__ bb','ba.book_id = bb.f_id')->where(array('ba.id'=>$id))->value('f_book_name');
        $title = $article_data['title'].'-'.$book_title;
        $page_basic_info = array(
            'title'         =>  $title.'-'.Config::get('web_site_name'),
        );
        $this->assign('page_basic_info', $page_basic_info);
        return $this->fetch('art_detail');
    }


}