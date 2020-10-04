<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Layouts
{
	// hold CI intance 
	private $CI;
	//hold layout title
	private $layout_title = NULL;
	//hold layout discription
	private $layout_description = NULL;
	
	public function __construct()
	{
		$this->CI = & get_instance();
	}

	public function login_view($view_name, $layouts=array(), $params=array(),$viewtype='')
	{	
		$this->CI->load->library('parser');
		if(is_array($layouts) && count($layouts) >=1):
			foreach($layouts as $layout_key => $layout):
				$params[$layout_key] = $this->CI->parser->parse($layout, $params, true);
			endforeach;
		endif;
		//$base_url_new = $this->CI->config->item('base_url_new'); //jitendra chaudhari

		$params['BASE_URL']				= 	base_url();
		$params['FULL_SITE_URL']		= 	$this->CI->session->userdata('VB_ADMIN_CURRENT_PATH');
		$params['ASSET_URL']			= 	base_url().'assets/';
		$params['ASSET_INCLUDE_URL']	= 	base_url().'assets/';

		$params['CURRENT_CLASS']		= 	$this->CI->router->fetch_class();
		$params['CURRENT_METHOD']		= 	$this->CI->router->fetch_method();
		
		$pagedata['title'] 				= 	$this->layout_title?$this->layout_title:'Wems RSA';
		$pagedata['description']		= 	$this->layout_description;
		$pagedata['keyword'] 			= 	$this->layout_keyword;
		
		
		if($viewtype == 'onlyview'):
			$pagedata['head'] 				= 	$this->CI->parser->parse("layouts/login/head",$params,true);
			$pagedata['header'] 			= 	'';
			$pagedata['content']			= 	$this->CI->parser->parse($view_name,$params,true);
			$pagedata['footer'] 			= 	'';
			$pagedata['footer_js'] 			= 	'';
			$this->CI->parser->parse("layouts/login", $pagedata);
		else:
			$pagedata['head'] 				= 	$this->CI->parser->parse("layouts/login/head",$params,true);
			$pagedata['content']			= 	$this->CI->parser->parse($view_name,$params,true);
			$pagedata['footer'] 			= 	$this->CI->parser->parse("layouts/login/footer",$params,true);
			$pagedata['footer_js'] 			= 	$this->CI->parser->parse("layouts/login/footer_js",$params,true);
			$this->CI->parser->parse("layouts/login", $pagedata);
		endif;
	}
	

	/**
     * Set page title
     *
     * @param $title
     */
    public function set_title($title)
	{
		$this->layout_title = $title;
		return $this;
	}
	
	/**
     * Set page description
     *
     * @param $description
     */
    public function set_description($description)
	{
		$this->layout_description = $description;
		return $this;
	}
	
	/**
     * Set page keyword
     *
     * @param $keyword
     */
    public function set_keyword($keyword)
	{
		$this->layout_keyword = $keyword;
		return $this;
	}
}