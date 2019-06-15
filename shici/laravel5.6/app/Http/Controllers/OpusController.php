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


class OpusController extends Controller {


    // 作品列表
    public function index(){
        $res_data = DB::table('opus')->paginate(10);
        return view('opus.list')->with('list_data', $res_data);

    }


    /**
     * 作品详细
     * @return [type] [description]
     */
    public function detail($id) {
        $opus_data = DB::table("opus")->select('id','title','author_id','author_name','f_year_id','content','f_year','img_url')->where(array('id'=>$id))->first();

        $opus_data->img_url = substr($opus_data->img_url, 1); 

        // 作品解析
        $info_data = DB::table("opus_other")->where(array('opus_id'=>$id))->select('opus_other','opus_other_short','cankao')->get();

        return view('opus.detail')->with(['opus_data'=>$opus_data,'info_data'=>$info_data]);

    }


}