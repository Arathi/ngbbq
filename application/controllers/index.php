<?php
/**
 * Created by PhpStorm.
 * User: Arathi
 * Date: 2015/1/16
 * Time: 19:17
 */

define('CONFESSIONS_PER_PAGE', 15);

class Index extends CI_Controller {
    protected $css_url_prefix;
    protected $image_url_prefix;

    public function __construct(){
        parent::__construct();
        $this->load->library('smarty');
        $this->load->helper('url');
        $this->load->model('confession_model');
    }

    public function index($page = 1) {
        $this->css_url_prefix = base_url(APPPATH.'CSS');
        $this->image_url_prefix = base_url(APPPATH.'image');
        $prep_page = $page - 1;
        $next_page = $page + 1;
        $start_at = ($page - 1) * CONFESSIONS_PER_PAGE;
        $confessions = $this->confession_model->get_confessions($start_at, CONFESSIONS_PER_PAGE);
        $confessions_prepared = array();
        foreach ($confessions as $confession){
            $confession['post_time_str'] = date('Y-m-d h:i:s a', $confession['post_time']);
            $confessions_prepared[] = $confession;
        }
        //TODO 如果上一页或者下一页不存在，将无法点击
        $tpl_data = array(
            'confessions' => $confessions_prepared,
            'page' => $page,
            'css_url_prefix' => $this->css_url_prefix,
            'image_url_prefix' => $this->image_url_prefix,
            'prep_page_url' => site_url('wall/'.$prep_page),
            'next_page_url' => site_url('wall/'.$next_page),
            'commit_url' => site_url('commit'),
        );
        $this->smarty->assign($tpl_data);
        $this->smarty->view('index');
    }

    public function commit() {
        $this->css_url_prefix = base_url(APPPATH.'CSS');
        $this->image_url_prefix = base_url(APPPATH.'image');
        //TODO 检查是否有数据提交
        $nick_name = $this->input->post('n_name');
        $real_name = $this->input->post('name');
        $contact = $this->input->post('contact');
        $email = $this->input->post('email');
        $content = $this->input->post('txt');
        //TODO 获取IP地址
        $post_ip = $this->input->ip_address();
        $post_time = time();
        if ($this->input->post('submit')!=NULL && $nick_name!='' && $content!=''){
            //TODO 提交数据
            $this->confession_model->add_confession($nick_name, $real_name, $contact, $post_time, $content, $post_ip);
            //重定向到首页去
            redirect(site_url('wall'));
        }
        $tpl_data = array(
            'css_url_prefix' => $this->css_url_prefix,
            'image_url_prefix' => $this->image_url_prefix,
        );
        $this->smarty->assign($tpl_data);
        $this->smarty->view('write');
    }
}
