<?php
/**
 * Created by PhpStorm.
 * User: Arathi
 * Date: 2015/1/17
 * Time: 8:02
 */

define('CONFESSION_TABLE', 'bbq');

class Confession_model extends CI_Model {
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function get_confessions($start, $amount){
        $this->db->select('id conf_id,nick nick_name,name real_name,contact,time post_time,txt content,ip post_ip')
            ->from(CONFESSION_TABLE)
            ->limit($amount, $start);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function add_confession($nick_name, $real_name, $contact, $post_time, $content, $post_ip)
    {
        //获取当前最大的conf_id
        $max_conf_id = 0;
        $this->db->select_max('id', 'max_conf_id')
            ->from(CONFESSION_TABLE);
        $query = $this->db->get();
        $result = $query->row_array();
        if (count($result)>0){
            $max_conf_id = $result['max_user_id'];
        }
        //插入到CONFESSION表
        $confession_data = array(
            'id' => $max_conf_id + 1,
            'nick' => $nick_name,
            'name' => $real_name,
            'contact' => $contact,
            'time' => $post_time,
            'txt' => $content,
            'ip' => $post_ip
        );
        $this->db->insert(CONFESSION_TABLE, $confession_data);
    }
}