<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
// error_reporting(E_ERROR | E_WARNING | E_PARSE);
function lib_debug($promot=null, $info='',$type=1, $logfile='lib_log') {
    $log_on = true;
    $output = date("Y-m-d H:i:s");
    $trace_info = debug_backtrace();
    $promot = $_SERVER['REMOTE_ADDR'].'_'.$_SERVER['REMOTE_PORT'].'_'.$trace_info[0]['file'].'::'.$trace_info[0]['line'].'::'.$promot;
    if ($log_on) {
        if (! is_null ( $promot )) {
            $output = $output . " :: " . $promot;
        }
        if (is_array ( $info ) || is_object ( $info )) {
            $output = $output  . " : " .  lib_var_dump_ret( $info,$type, true );
        } else {
            $output = $output  . " : " .  $info;
        }
        $output = $output . "\n";
        lib_writelog($logfile,$output);
    }
}
function lib_writelog($file, $log) {
    $yearmonth = date('Ymd');
    $logdir = $_SERVER['DOCUMENT_ROOT'].'/log/';
    $logfile = $logdir.$yearmonth.'_'.$file.'.log';
    if(@filesize($logfile) > 9048000) {
        $dir = opendir($logdir);
        $length = strlen($file);
        $maxid = $id = 0;
        while($entry = readdir($dir)) {
            if(strexists($entry, $yearmonth.'_'.$file)) {
                $id = intval(substr($entry, $length + 8, -4));
                $id > $maxid && $maxid = $id;
            }
        }
        closedir($dir);

        $logfilebak = $logdir.$yearmonth.'_'.$file.'_'.($maxid + 1).'.log';
        @rename($logfile, $logfilebak);
    }

    if($fp = @fopen($logfile, 'a')) {
        @flock($fp, 2);
        $log = is_array($log) ? $log : array($log);
        foreach($log as $tmp) {
            fwrite($fp,$tmp);
        }
        fclose($fp);
    }
}
function lib_var_dump_ret($mixed = null,$type) {
    ob_start();
    if($type == 1) {
        var_dump($mixed);
    } else {
        print_r($mixed);
    }
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}