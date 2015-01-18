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

    public function __construct() {
        parent::__construct();
        $this->load->helper('email');
        $this->load->helper('url');
        $this->load->library('email');
        $this->load->library('smarty');
        $this->load->model('confession_model');
        $this->load->model('option_model');
    }

    public function index($page = 1) {
        $this->css_url_prefix = base_url(APPPATH.'CSS');
        $this->image_url_prefix = base_url(APPPATH.'image');
        date_default_timezone_set("Asia/Shanghai");
        //检查记录总数，计算总页数
        $confessions_amount = $this->confession_model->get_confessions_amount();
        $page_max = $confessions_amount / CONFESSIONS_PER_PAGE;
        $prep_page = $page - 1;
        $next_page = $page + 1;
        $start_at = ($page - 1) * CONFESSIONS_PER_PAGE;
        $confessions = $this->confession_model->get_confessions($start_at, CONFESSIONS_PER_PAGE);
        $confessions_prepared = array();
        foreach ($confessions as $confession){
            $confession['post_time_str'] = date('Y年m月d日 H:i:s', $confession['post_time']);
            $confessions_prepared[] = $confession;
        }
        //如果上一页或者下一页不存在，将无法点击
        $disable_prep_page = $prep_page<=0;
        $disable_next_page = $next_page>$page_max;
        $tpl_data = array(
            'confessions' => $confessions_prepared,
            'page' => $page,
            'css_url_prefix' => $this->css_url_prefix,
            'image_url_prefix' => $this->image_url_prefix,
            'prep_page_url' => site_url('wall/'.$prep_page),
            'next_page_url' => site_url('wall/'.$next_page),
            'prep_page_disabled' => $disable_prep_page,
            'next_page_disabled' => $disable_next_page,
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
        //获取IP地址
        $post_ip = $this->input->ip_address();
        $post_time = time();
        if ($this->input->post('submit')!=NULL && $nick_name!='' && $content!='') {
            //提交数据
            $this->confession_model->add_confession($nick_name, $real_name, $contact, $post_time, $content, $post_ip);
            //Plan A. 在此立即发送邮件
            if (isset($email) && valid_email($email)) {
                $mail_conf = array();
                $options = array();
                //TODO 从配置文件加载$options
                include_once(APPPATH.'config/option.php');
                //TODO 从数据库加载$options
                $options = $this->option_model->get_options($options);

                $mail_conf['protocol'] = 'smtp';
                $mail_conf['charset'] = 'UTF-8';
                //以下是可配置项
                $mail_conf['smtp_host'] = $options['smtp_host'];
                $mail_conf['smtp_user'] = $options['smtp_user'];
                $mail_conf['smtp_pass'] = $options['smtp_pass'];
                $mail_conf['smtp_port'] = $options['smtp_port'];
                $mail_conf['smtp_timeout'] = $options['smtp_timeout'];

                $this->email->initialize($mail_conf);
                $this->email->from($options['mail_from'], $options['mail_from_name']);
                $this->email->to($email);
                //$this->email->bcc($options['bccEmail']); //设置暗送
                $this->email->subject($options['mail_title']);

                $message_content = $content;
                $this->email->message($message_content);
                $send_success = $this->email->send();

                //TODO Plan B. 添加到邮件发送队列
                //if ($send_success != TRUE){
                //    //insert到mail_queue表中
                //}
                //else{
                //    show_error('邮件发送失败！', 500, $this->email->print_debugger());
                //}
            }
            else{
                show_error("提交成功！但邮件地址错误，未邮件发送。<a href='".site_url()."'>点击返回首页</a>");
            }
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
