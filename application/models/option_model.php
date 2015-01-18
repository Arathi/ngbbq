<?php
/**
 * Created by PhpStorm.
 * User: Arathi
 * Date: 2015/1/18
 * Time: 9:54
 */

define('OPTION_TABLE', 'option');

class Option_model extends CI_Model {
    public function __construct(){
        parent::__construct();
    }

    public function get_options($options){
        $this->db->select('key,value')
            ->from(OPTION_TABLE);
        $query = $this->db->get();
        $options_result = $query->result_array();
        //使用数据库中的option覆盖$options中的配置
        foreach ($options_result as $option) {
            $options[$option['key']] = $option['value'];
        }
        if ($options['mail_from'] == ''){
            $options['mail_from'] = $options['smtp_user'];
        }
        return $options;
    }

    public function put_option($key, $value){
        //TODO 设置单组option
    }

    public function put_options($option_group){
        //TODO 设置多组option
    }
} 