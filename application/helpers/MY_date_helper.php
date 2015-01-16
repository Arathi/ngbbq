<?php
/**
 * Created by PhpStorm.
 * User: Arathi
 * Date: 14-7-21
 * Time: 下午5:46
 */

if ( ! function_exists('mkdate')){
    /**
     * 获取指定的字符串形式的时间
     * @param $date_format : string 日期格式（最好带有%）
     * @param $timestamp : int UNIX时间戳
     * @param $timezone : string 时区（CI中的时区）
     * @return 转换后的时间
     */
    function mkdate($date_format='%Y-%m-%d %H:%i:%s', $timestamp=FALSE, $timezone='UP8'){
        if ($timestamp==FALSE){
            $timestamp = now();
        }
        $timestamp_fixed = gmt_to_local($timestamp, $timezone);
        $time_str = mdate($date_format, $timestamp_fixed);
        return $time_str;
    }
}

/* End of file CB_date_helper.php */ 