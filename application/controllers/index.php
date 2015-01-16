<?php
/**
 * Created by PhpStorm.
 * User: Arathi
 * Date: 2015/1/16
 * Time: 19:17
 */

class Index extends CI_Controller {
    protected $css_url_prefix;
    protected $image_url_prefix;

    public function __construct(){
        parent::__construct();
        $this->load->library('smarty');
        $this->load->helper('url');
    }

    public function index($page = 1) {
        $this->css_url_prefix = base_url(APPPATH.'CSS');
        $this->image_url_prefix = base_url(APPPATH.'image');
        $prep_page = $page - 1;
        $next_page = $page + 1;
        $tpl_data = array(
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
        $text = $this->input->post('txt');
        if ($this->input->post('submit')!=NULL && $nick_name!='' && $text!=''){
            //TODO 提交数据
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
