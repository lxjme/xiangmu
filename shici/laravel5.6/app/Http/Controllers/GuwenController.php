<?php
/*
 * =====================================
 * USER NAME: LXJ
 * FILE NAME: OpusController.class.php
 * FILE DESC: 作品
 * DATE TIME: 2017-11-03 16:00:44
 * =====================================
 */
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class GuwenController extends Controller {


    // 作品列表
    public function index(){
        $res_data = DB::table('books')->where(['f_type'=>1])->paginate(10);

        return view('guwen.list')->with('list_data', $res_data);
    }


    /**
     * 作品详细
     * @return [type] [description]
     */
    public function artList($id) {
        if(empty($id)) {
            redirect('/Guwen');
        }

        DB::enableQueryLog();

        $lanmu_count = DB::table("books_lanmu")->where(array('book_id'=>$id))->count('*');


        $article_res = DB::table("books_article")->where(array('book_id'=>$id))->select('id','title','lanmu_id')->get();

        $article_data = $article_res->toArray();
        $article_list = [];
        if($lanmu_count > 0) {
            $lanmu_res = array_column((DB::table("books_lanmu")->where(array('book_id'=>$id))->select('id','book_id','lanmu_name')->get())->toArray(), null,'id');

            foreach ($article_data as $key => $val) {
                $article_list[$val->lanmu_id]['lanmu_name'] = $lanmu_res[$val->lanmu_id]->lanmu_name;
                $article_list[$val->lanmu_id]['list'][$val->id]['id'] = $val->id;
                $article_list[$val->lanmu_id]['list'][$val->id]['title'] = $val->title;
            }
        } else {
            foreach ($article_data as $key => $val) {
                $article_list[$val->lanmu_id]['list'][$val->id]['id'] = $val->id;
                $article_list[$val->lanmu_id]['list'][$val->id]['title'] = $val->title;
            }
        }


        $book_res = DB::table("books")->where(array('f_id'=>$id))->select('f_book_fm','f_book_desc','f_book_name')->first();


        return view('guwen.art_list')->with([
            'book_res'=>$book_res,
            'article_list'=>$article_list,
        ]);
    }


    // 文章详情
    public function artDetail($id) {
        if(empty($id)) {
            redirect('/Guwen');
        }
        $article_data = DB::table("books_article")->where(array('id'=>$id))->select('title','content','fanyi')->first();

        $book_title =  DB::table("books_article as ba")
                            ->join('books as bb','ba.book_id','=','bb.f_id')->where(array('ba.id'=>$id))->value("f_book_name");

        // $title = $article_data['title'].'-'.$book_title;

        // $page_basic_info = array(
        //     'title'         =>  $title.'-'.C('WEB_SITE_NAME'),
        // );
        // $this->assign('page_basic_info', $page_basic_info);
        // $this->display('art_detail');
        // 
        return view("guwen.art_detail")->with([
            'article_data'=>$article_data,
            'book_title'=>$book_title
        ]);
    }


}