<?php
/**
 * 诗人
 */

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class AuthorController extends Controller
{
    /**
     * 诗人列表
     * @return [type] [description]
     */
    public function index() {

        // DB::enableQueryLog();
        $res_data = DB::table('author')->select('id','author_name','img_url','author_desc')->paginate(10);
        
        // lib_debug('fdsf',DB::getQueryLog());
        return view('author.list')->with('list_data', $res_data);
    }

    /**
     * 诗人详情
     * @return [type] [description]
     */
    public function detail($id) {
        $author_data = DB::table('author')->where(array('id'=>$id))->first();
        $info_data = DB::table('author_detail')->where(array('author_id'=>$id))->select('id','author_other','author_other_short')->get();
        return view('author.detail')->with(['author_data'=>$author_data,'info_data'=>$info_data]);
    }
}
