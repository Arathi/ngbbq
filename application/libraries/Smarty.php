<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'third_party/smarty/Smarty.class.php');

class CI_Smarty extends Smarty {

    function __construct()
    {
        parent::__construct();
        $this->setTemplateDir(APPPATH.'views');
        $this->setCompileDir(APPPATH.'views/compiled');
        $this->setConfigDir(APPPATH.'third_party/smarty/configs');
        $this->setCacheDir(APPPATH.'third_party/smarty/cache');

        $this->assign('APPPATH', APPPATH);
        $this->assign('BASEPATH', BASEPATH);
        if ( method_exists($this, 'assignByRef')) {
            $ci =& get_instance();
            $this->assignByRef("ci", $ci);
        }
        $this->force_compile = 1;
        $this->caching = true;
        $this->cache_lifetime = 120;
    }

    function view($template_name) {
        if (strpos($template_name, '.') === FALSE && strpos($template_name, ':') === FALSE) {
            $template_name .= '.tpl';
        }
        parent::display($template_name);
    }
}
