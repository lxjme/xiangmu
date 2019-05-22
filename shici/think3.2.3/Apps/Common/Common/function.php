<?php
/**
 * 获得登录后的session内容以及状态值
 * @param unknown $str
 * @return multitype:string number NULL unknown
 */
function httpAnaly($str) {
    $return = array(
        'session'   =>  '',
        'is_login'  =>  '0',
    );
    $preg_ses = '/JSESSIONID=([0-9A-Z]{32})/';
    preg_match($preg_ses, $str, $matches);

    if(!empty($matches)) {
        $return['session'] = $matches[1];
    }
    // $status_preg = '/\"status\":1/';
    $status_preg = '/\{\".*?\"\}/';
    preg_match($status_preg, $str, $matches2);

    if(!empty($matches2)) {
        $json_str = $matches2[0];
        $arr = json_decode($json_str , true);                   //修改，添加后缀}
        // if (strpos($json_str, '"status":1')) {
        //  $json_str = $json_str . '}';
        // }
        // $arr = json_decode($json_str , true);                    //修改，添加后缀}

        if($arr['status'] == 1) {
            $return['is_login'] = 1;
            $return['userId'] = $arr['data'];
            // $return['cer'] = $arr['data']['cer'];
        }else{
            $return['is_login'] = 0;
            $return['msg'] = $arr['msg'];
        }
    }

    return $return;
}



function curlRequest($url, $data, $type=1,$return_action=null,$is_cookie=false) {
    // 初始化句柄
    $ch = curl_init();
    // 设置发送目标URL地址
    curl_setopt($ch, CURLOPT_URL, $url);
    // 返回数据以文件流形式输入，不立即输出
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // 超时 3秒
    curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,2);

    // curl_setopt($ch, CURLOPT_ENCODING, "gzip"); 

    switch ($type) {
    	case 1: // GET
    		curl_setopt($ch, CURLOPT_HEADER, 0);
    		break;
    	case 2: // POST
    		// 发送数据格式 post
	        curl_setopt($ch, CURLOPT_POST, 1);
	        // post 参数
	        $data = http_build_query($data);
	        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	        break;
	    case 3: // 模拟表单提交
    		// 发送数据格式 post
    		if (class_exists('\CURLFile')) {
	            $data = array(
	                'img' => new \CURLFile(realpath($data['files']['tmp_name']),$data['files']['type'],$data['files']['name']),
	                'userId'=>$data['userId'],
	                'platform'=>$data['platform']
	            );
	        } else {
	            $data = array(
	                'img'=>'@'.realpath($data['files']['tmp_name']).";type=".$data['files']['type'].";filename=".$data['files']['name'],
	                'userId'=>$data['userId'],
	                'platform'=>$data['platform']
	            );
	        }
	        curl_setopt($ch, CURLOPT_POST, true );
        	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        	curl_setopt($ch, CURLOPT_HEADER, false);
	        break;
	    case 4: // 模拟表单提交
    		// 发送数据格式 post
    		if (class_exists('\CURLFile')) {
	            $data = array(
	                'img' => new \CURLFile(realpath($data['files']['tmp_name']),$data['files']['type'],$data['files']['name']),
	                'flag'=>$data['flag'],
	            );
	        } else {
	            $data = array(
	                'img'=>'@'.realpath($data['files']['tmp_name']).";type=".$data['files']['type'].";filename=".$data['files']['name'],
	                'flag'=>$data['flag'],
	            );
	        }
	        curl_setopt($ch, CURLOPT_POST, true );
        	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        	curl_setopt($ch, CURLOPT_HEADER, false);
	        break;
	    case 5: // 模拟cookie get
	        curl_setopt($ch, CURLOPT_HEADER, 1);
	        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	        $output = curl_exec($ch);

	        // 释放句柄
	        curl_close($ch);
	        return httpAnaly($output);
	        break;
	    case 6: // 模拟cookie post
	        curl_setopt($ch, CURLOPT_POST, true );
	        // 把post的变量加上
	        $cookie = 'JSESSIONID='.$data['cookie'];
	        curl_setopt($ch, CURLOPT_POSTFIELDS, $data['param']);
	        curl_setopt($ch, CURLOPT_COOKIE, $cookie);
	        break;
	    case 7: // 模拟表单提交
    		// 发送数据格式 post
    		$res_data = array();
    		if (class_exists('\CURLFile')) {
    			foreach ($data as $k => $v) {
    				if($k == 'files') {
    					foreach ($v as $k2 => $v2) {
		    				$res_data['file'.$k2] = new \CURLFile(realpath($v2['tmp_name']),$v2['type'],$v2['name']);
		    			}
    				} else {
	    				$res_data[$k] = $v;
    				}

    			}
	        } else {
	        	foreach ($data as $k => $v) {
    				if($k == 'files') {
    					foreach ($v as $k2 => $v2) {
		    				$res_data['files['.$k2.']'] = '@'.realpath($v2['tmp_name']).";type=".$v2['type'].";filename=".$v2['name'];
		    			}
    				} else {
	    				$res_data[$k] = $v;
    				}

    			}
	        }

	        curl_setopt($ch, CURLOPT_POST, true );
        	curl_setopt($ch, CURLOPT_POSTFIELDS, $res_data);
        	curl_setopt($ch, CURLOPT_HEADER, false);
	        break;
        case 8: // 模拟表单提交
        	// 发送数据格式 post
        	$res_data = array();
        	if (class_exists('\CURLFile')) {
        		foreach ($data as $k => $v) {
        			if($k == 'fileupload') {
        				$res_data[$k] = new \CURLFile(realpath($v['tmp_name']),$v['type'],$v['name']);
        			} else {
        				$res_data[$k] = $v;
        			}
        		}
        	} else {
        		foreach ($data as $k => $v) {
        			if($k == 'files') {
        				foreach ($v as $k2 => $v2) {
        					$res_data['files['.$k2.']'] = '@'.realpath($v2['tmp_name']).";type=".$v2['type'].";filename=".$v2['name'];
        				}
        			} else {
        				$res_data[$k] = $v;
        			}
        		}
        	}
        	curl_setopt($ch, CURLOPT_POST, true );
        	curl_setopt($ch, CURLOPT_POSTFIELDS, $res_data);
        	curl_setopt($ch, CURLOPT_HEADER, false);
        	break;
        case 9:	// 获取验证码
        	curl_setopt($ch, CURLOPT_HEADER, true);
        	break;
        case 10:	// 抓取网页
        	curl_setopt($ch, CURLOPT_HEADER, 1);
            $output = curl_exec($ch);
            $get_info = curl_getinfo($ch);
            // 释放句柄
            curl_close($ch);
            return $get_info;
        	break;
    }


    // 是否模拟cookie
    if($is_cookie) {
    	// 把post的变量加上
        $cookie = 'JSESSIONID='.$data['cookie'];
        curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    }
    // 执行会话
    $output = curl_exec($ch);


    // 释放句柄
    curl_close($ch);
    // echo $output;
    // exit;
    // 返回数据的操作方式
    if($return_action == 'echo') {
    	return $output;
    } else {
    	// 返回数据
    	return json_decode($output,true);
    }


}

/**
 * 格式化URL链接
 * @author lxj
 * @param  [type] 分页html代码
 * @return [type] string
 */
function formatLink($pages, $type='excel') {
    $pattern = '/href=\"(.*?)\"/i';

    preg_match_all($pattern, $pages, $matches);

    $tem_arr = array();
    if($type == 's') {
        for($j=0; $j<count($matches[1]); $j++) {
            $arr = explode('/', ltrim(substr($matches[1][$j], 0, -5),'/'));
            unset($arr[0]);

            for($m=1;$m<=count($arr);) {
                $tem_arr[$arr[$m]] = $arr[$m+1];
                $m+=2;
            }

            $url = 'Search?wd='.$tem_arr['wd'].'&p='.$tem_arr['p'];
            $pages = str_replace($matches[1][$j], $url, $pages);
        }
    } else {
       for($j=0; $j<count($matches[1]); $j++) {
            $arr = explode('/', ltrim(substr($matches[1][$j], 0, -5),'/'));
            unset($arr[0]);
            for($m=1;$m<=count($arr);) {
                $tem_arr[$arr[$m]] = $arr[$m+1];
                $m+=2;
            }
            // foreach ($arr as $key => $value) {
            // }
            $url = '/'.$type.'?p='.$tem_arr['p'];
            $pages = str_replace($matches[1][$j], $url, $pages);
        }
    }
    return $pages;
}


/**
 * 生成静态页面的名称
 * @param  [type] $url [description]
 * @return [type]      [description]
 */
function url_format($url) {
    return str_replace(array('.html','/Html/'), array('',''), $url);
}