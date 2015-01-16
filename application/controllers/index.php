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
        $tpl_data = array(
            'css_url_prefix' => $this->css_url_prefix,
            'image_url_prefix' => $this->image_url_prefix,
        );
        $this->smarty->assign($tpl_data);
        $this->smarty->view('index');
    }
}
