<?php
/*
 * =====================================
 * USER NAME: LXJ
 * FILE NAME: ShujiController.class.php
 * FILE DESC: 现代书籍
 * DATE TIME: 2017-11-03 16:00:44
 * =====================================
 */
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Config;

class Shuji extends Controller {

    public function _initialize() {
        $this->assign('crt_menu', 'shuji');
    }

    // 作品列表
    public function index(){
        $model = Db::name('Books');


        $res_data = $model->field('f_id,f_book_name,f_book_desc,f_book_fm')->where(array('f_type'=>2))->paginate();

        $this->assign('book_data', $res_data);

        $title = '书籍';
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
            redirect('/Shuji');
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


        $title = $book_res['f_book_name'].'全文';

        $page_basic_info = array(
            'title'         =>  $title.'-'.Config::get('web_site_name'),
        );
        $this->assign('page_basic_info', $page_basic_info);

        return $this->fetch('art_list');
    }


    // 文章详情
    public function artDetail($id) {
        if(empty($id)) {
            redirect('/Shuji');
        }

        $article_data = array();
        $res_info = Db::name('BooksArticle')->where(array('id'=>$id))->field('title,book_id,content')->find();



        $this->assign('article_data', $res_info);

        // 书籍目录连接  上一篇 下一篇
        $this->assign('mulu_href', '/Shuji/artList_'.$res_info['book_id']);
        $pre_id = Db::name('BooksArticle')->where(array('book_id'=>$res_info['book_id'],'id'=>array('LT',$id)))->order('id desc')->value('id');
        if(!empty($pre_id)) {
            $pre_href = '/Shuji/artDetail_'.$pre_id;
            $this->assign('pre_href', $pre_href);
        }
        $next_id = Db::name('BooksArticle')->where(array('book_id'=>$res_info['book_id'],'id'=>array('GT',$id)))->order('id ASC')->value('id');
        if(!empty($next_id)) {
            $next_href = '/Shuji/artDetail_'.$next_id;
            $this->assign('next_href', $next_href);
        }

        $book_title = Db::name('BooksArticle')->alias('ba')->join('__BOOKS__ bb','ba.book_id = bb.f_id')->where(array('ba.id'=>$id))->value('f_book_name');
        $title = $res_info['title'].'-'.$book_title;

        $page_basic_info = array(
            'title'         =>  $title.'-'.Config::get('web_site_name'),
        );
        $this->assign('page_basic_info', $page_basic_info);
        return $this->fetch('art_detail');
    }


}