<?php
/*
 * =====================================
 * USER NAME: LXJ
 * FILE NAME: Wechat.class.php
 * FILE DESC: 公众平台接口开发
 * DATE TIME: 2018-07-20 16:45:39
 * =====================================
 */

/**
 * 1、UnionID--多个OpenID
 * 2、部分接口日调用次数有限
 * 3、所有接口调用前需要获取access_token,access_token有效期2个小时，需要存储
 * 4、接口调用仅支持80端口
 * 5.群发消息（订阅号1次/每天，服务好4次/每天）
 *  
 *  
 */
namespace Home\Controller;
use Think\Controller;


class WechatController extends Controller {
	private $_token = 'wechat_test';
	private $_appId = 'wxddd2c6f8587572d1';
	private $_appSecret = 'aa092cff2b105ee66d95b00972238e2a';
	private $_genericHost = 'https://api.weixin.qq.com';		// 使用该域名将访问官方指定就近的接入点；
	private $_accessTokenFilePath = "Data/wechat/access_token.php";	// 用来存储access_token 信息
	private $_accessTokenDurate = 7200;	// access_token 有效期时长 2个小时
	private $_accessToken = '';	// access_token



	/**
	 * 入口方法
	 * @return [type] [description]
	 */
	public function index() {
		$this->assign('menu_cache', $this->_getMenu());
		$this->display();
		// lib_debug('fsdf', file_get_contents('php://input'));
		// lib_debug('get', $_GET);
		// lib_debug('_POST', $_POST);
		// lib_debug('_FILES', $_FILES);

		// $this->_createMenu();
	}


	/**
	 * 接收微信菜单点击事件
	 * @return [type] [description]
	 */
	public function getWechatMsg() {
		// 获取微信用户在公众号的事件消息
		$get_contents = file_get_contents('php://input');
		lib_debug('2', $get_contents);

		$obj = simplexml_load_string($get_contents, 'SimpleXMLElement', LIBXML_NOCDATA);
		$toUser		= $obj->FromUserName;
                $fromUser	= $obj->ToUserName;
                $time      = time();
                $msgType   = 'text';
                $content   = '欢迎光临！';
                $template  = "<xml>
                               <ToUserName><![CDATA[%s]]></ToUserName>
                               <FromUserName><![CDATA[%s]]></FromUserName>
                               <CreateTime>%s</CreateTime>
                               <MsgType><![CDATA[%s]]></MsgType>
                               <Content><![CDATA[%s]]></Content>
                                </xml>";
                $info= sprintf($template,$toUser,$fromUser,$time,$msgType,$content);
                echo $info;
	}


	/**
	 * 获取创建的菜单列表
	 * @return [type] [description]
	 */
	private function _getMenu() {
		$menu_cache = S('menu_cache');
		if(!$menu_cache) {
			$api_url = $this->_genericHost.'/cgi-bin/menu/get';
			$api_res = self::_curlRequest($api_url,array('access_token'=>$this->_accessToken));

			S('menu_cache', $api_res['menu']['button']);
		}

		return $menu_cache;
	}


	/**
	 * 创建菜单
	 	1、自定义菜单最多包括3个一级菜单，每个一级菜单最多包含5个二级菜单。
		2、一级菜单最多4个汉字，二级菜单最多7个汉字，多出来的部分将会以“...”代替。
		3、创建自定义菜单后，菜单的刷新策略是，在用户进入公众号会话页或公众号profile页时，
			如果发现上一次拉取菜单的请求在5分钟以前，就会拉取一下菜单，如果菜单有更新，就会刷新客户端的菜单。
			测试时可以尝试取消关注公众账号后再次关注，则可以看到创建后的效果。
	 * @return [type] [description]
	 */
	private function _createMenu() {
		$api_url = $this->_genericHost.'/cgi-bin/menu/create?access_token='.$this->_accessToken;
		$api_param = array(
			'button'=>array(
				array(
		          	"name"=>"菜单1",
		          	"sub_button"=>array(
		          		array(
		          			"type"=>'click',
		          			'name'=>'点击click',
		          			'key'=>'V1001_MENU'
		          		),
		          		array(
		          			"type"=>'view',
		          			'name'=>'跳转view',
		          			'url'=>'http://www.jiaoxiliang.net'
		          		),
		          		array(
		          			"type"=>'scancode_push',
		          			'name'=>'扫码推事件',
		          			'key'=>'V1002_MENU'
		          		),
		          		array(
		          			"type"=>'scancode_waitmsg',
		          			'name'=>'扫码带提示',
		          			'key'=>'V1003_MENU'
		          		),
		          		array(
		          			"type"=>'pic_photo_or_album',
		          			'name'=>'弹出微信相册',
		          			'key'=>'V1004_MENU'
		          		),
		          	)
				),
				array(
		          	"name"=>"菜单2",
		          	"sub_button"=>array(
		          		array(
		          			"type"=>'pic_sysphoto',
		          			'name'=>'拍照发图',
		          			'key'=>'V2001_MENU'
		          		),
		          		array(
		          			"type"=>'pic_weixin',
		          			'name'=>'微信相册',
		          			'key'=>'V2002_MENU'
		          		),
		          		array(
		          			"type"=>'location_select',
		          			'name'=>'地理位置选择',
		          			'key'=>'V2003_MENU'
		          		),
		          		// array(
		          		// 	"type"=>'media_id',
		          		// 	'name'=>'图片',
		          		// 	'media_id'=>'lR7UNGuNBACcLqvXQtwJNdPkv-Oy4_lsTgGpPiOEmsdzQjqb4R38Eam2nVIavGHO'
		          		// ),
		          		// array(
		          		// 	"type"=>'view_limited',
		          		// 	'name'=>'图文消息',
		          		// 	'media_id'=>'lR7UNGuNBACcLqvXQtwJNdPkv-Oy4_lsTgGpPiOEmsdzQjqb4R38Eam2nVIavGHO'
		          		// ),
		          	)
				),
				array(
					"type"=>"view",
		          	"name"=>"文章网",
		          	"url"=>"http://www.jiaoxiliang.net"
				),
			),
		);

		$api_res = self::_curlRequest($api_url, json_encode($api_param,JSON_UNESCAPED_UNICODE), 2);

		var_dump($api_res);
	}


	/**
	 * 获取access_token
	 * @return [type] [description]
	 */
	private function _getAccessToken() {
		$api_url = $this->_genericHost.'/cgi-bin/token';
		$api_param = array(
			'grant_type'=>'client_credential',
			'appid'=>$this->_appId,
			'secret'=>$this->_appSecret,
		);

		$api_res = self::_curlRequest($api_url, $api_param);
		$access_token = null;
		if($api_res['access_token']) {
			$access_token_expire = time()+$api_res['expires_in'];
			$access_token = $api_res['access_token'];

			session('access_token_expire', $access_token_expire);
			session('access_token', $access_token);

			$this->_setInfoToFile($this->_accessTokenFilePath, json_encode(array('access_token_expire'=>$access_token_expire,'access_token'=>$access_token)));

		} 

		return $access_token;

	}

	/**
	 * 校验
	 * 用于验证消息的确来自微信服务器
	 * @return [type] [description]
	 */
	private function _checkSignature($params) {
		$tem_arr['token'] = $this->_token;
		$tem_arr['timestamp'] = $params['timestamp'];
		$tem_arr['nonce'] = $params['nonce'];

		sort($tem_arr,SORT_STRING);

		$tem_str = sha1(implode($tem_arr));

		$msg = 'error';
		if($tem_str == $params['signature']) {
			$msg = $params['echostr'];
		}
		return $msg;
	}


	/**
	 * 调用接口
	 * @param  [type]  $url   [description]
	 * @param  array   $data  [description]
	 * @param  integer $type  [description]
	 * @param  array   $other [description]
	 * @return [type]         [description]
	 */
	public static function _curlRequest($url, $data=array(),$type=1) {

		$ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 500);
        // 为保证第三方服务器与微信服务器之间数据传输的安全性，所有微信接口采用https方式调用，必须使用下面2行代码打开ssl安全校验。
        // 如果在部署过程中代码在此处验证失败，请到 http://curl.haxx.se/ca/cacert.pem 下载新的证书判别文件。
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);


        switch ($type) {
        	case 1:	// get
				$data = http_build_query($data);
        		$url = $url.'?'.$data;
        		break;
        	case 2:	// post
        		// 发送数据格式 post
		        curl_setopt($ch, CURLOPT_POST, 1);

                $data = is_array($data) ? http_build_query($data) : $data;
		        // post 参数
		        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		        break;
        }

        curl_setopt($ch, CURLOPT_URL, $url);

        $output = curl_exec($ch);
        curl_close($ch);// 释放句柄






        return json_decode($output,true, 512, JSON_BIGINT_AS_STRING);
    }

    /**
     * 从文件中获取信息
     * @param  [type] $filename [description]
     * @return [type]           [description]
     */
    private function _getInfoFromFile($filename) {
        return trim(substr(file_get_contents($filename), 15));
    }

    /**
     * 存储信息到文件中
     * @param [type] $filename [description]
     * @param [type] $content  [description]
     */
    private function _setInfoToFile($filename, $content) {
    	$dir_name = dirname($this->_accessTokenFilePath);
    	is_dir($dir_name) OR mkdir($dir_name, 0777, true);
        $fp = fopen($filename, "w");
        fwrite($fp, "<?php exit();?>" . $content);
        fclose($fp);
    }

    /**
	 * 初始化
	 * @return [type] [description]
	 */
	public function _initialize() {
		if(!$this->_accessToken) {
			if(session('?access_token') && (time() < (session('access_token_expire')))) {
				$access_token = session('access_token');
			} else {
				$file_res = json_decode($this->_getInfoFromFile($this->_accessTokenFilePath), true);
				if(time() > $file_res['access_token_expire']) {
					$access_token = $this->_getAccessToken();
				} else {
					$access_token = $file_res['access_token'];
				}

				session('access_token_expire', $file_res['access_token_expire']);
				session('access_token', $file_res['access_token']);
			}

			$this->_accessToken = $access_token;
		}
	}

}