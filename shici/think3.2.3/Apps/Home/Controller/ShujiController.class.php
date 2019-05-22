<?php
/*
 * =====================================
 * USER NAME: LXJ
 * FILE NAME: ShujiController.class.php
 * FILE DESC: 现代书籍
 * DATE TIME: 2017-11-03 16:00:44
 * =====================================
 */
namespace Home\Controller;
use Think\Controller;
use Think\Page;

class ShujiController extends Controller {

    public function _initialize() {
        $this->assign('crt_menu', 'shuji');
    }

    // 作品列表
    public function index(){
        $model = M('Books');
        $count = $model->where(array('f_type'=>2))->count('*');
        $Page = new Page($count,10);
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->rollPage = 5;
        $Page->setConfig('header','共%TOTAL_ROW%条');
        $Page->setConfig('first','首页');
        $Page->setConfig('last','末页');
        $Page->lastSuffix = false;

        if($type_pin) {
            $page_type = 'Shuji/'.$type_pin;
        } else {
            $page_type = 'Shuji';
        }
        $show = formatLink($Page->show(),$page_type);


        $res_data = $model->field('f_id,f_book_name,f_book_desc,f_book_fm')->where(array('f_type'=>2))->limit($Page->firstRow.','.$Page->listRows)->select();



        $this->assign('book_data', $res_data);
        $this->assign('page_info',$show);

        $title = '书籍';
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
    public function artList() {
        $id = $_GET['id'];
        if(empty($id)) {
            redirect('/Shuji');
        }


        $lanmu_count = M('BooksLanmu')->where(array('book_id'=>$id))->count('*');

        $article_res = M('BooksArticle')->where(array('book_id'=>$id))->field('id,title,lanmu_id')->select();
        if($lanmu_count > 0) {
            $lanmu_res = M('BooksLanmu')->where(array('book_id'=>$id))->getfield('id,book_id,lanmu_name',true);

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



        $book_res = M('Books')->where(array('f_id'=>$id))->field('f_book_fm,f_book_desc,f_book_name')->find();

        $this->assign('article_data', $book_res);
        $this->assign('article_list', $article_list);


        $title = $book_res['f_book_name'].'全文';
        if($type_id) {
            $title = $filter_param_cache[$_GET['type_pin']]['type_name'];
        }
        $page_basic_info = array(
            'title'         =>  $title.'-'.C('WEB_SITE_NAME'),
        );
        $this->assign('page_basic_info', $page_basic_info);

        $this->display('art_list');
    }


    // 文章详情
    public function artDetail() {
        $id = I('get.id');
        if(empty($id)) {
            redirect('/Shuji');
        }

        $article_data = array();
        $res_info = M('BooksArticle')->where(array('id'=>$id))->field('title,book_id,content')->find();



        $this->assign('article_data', $res_info);

        // 书籍目录连接  上一篇 下一篇
        $this->assign('mulu_href', '/Shuji/artList_'.$res_info['book_id']);
        $pre_id = M('BooksArticle')->where(array('book_id'=>$res_info['book_id'],'id'=>array('LT',$id)))->order('id desc')->getField('id');
        if(!empty($pre_id)) {
            $pre_href = '/Shuji/artDetail_'.$pre_id;
            $this->assign('pre_href', $pre_href);
        }
        $next_id = M('BooksArticle')->where(array('book_id'=>$res_info['book_id'],'id'=>array('GT',$id)))->order('id ASC')->getField('id');
        if(!empty($next_id)) {
            $next_href = '/Shuji/artDetail_'.$next_id;
            $this->assign('next_href', $next_href);
        }

        $book_title = M('BooksArticle')->table('__BOOKS_ARTICLE__ AS ba')->join('__BOOKS__ AS bb ON ba.book_id = bb.f_id')->where(array('ba.id'=>$id))->getField('f_book_name');
        $title = $article_data['title'].'-'.$book_title;
        if($type_id) {
            $title = $filter_param_cache[$_GET['type_pin']]['type_name'];
        }
        $page_basic_info = array(
            'title'         =>  $title.'-'.C('WEB_SITE_NAME'),
        );
        $this->assign('page_basic_info', $page_basic_info);
        $this->display('art_detail');
    }


}