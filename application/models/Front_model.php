<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Front_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct(); 
		$this->load->database(); 
	}
	
	/***********************************************************************
	** Function name: GetSEODetailByPageUrl
	** Developed By: Tejaswi
	** Purpose: This function used for select seo data
	** Date: 20 SEPTEMBER 2018
	************************************************************************/
	function GetSEODetailByPageUrl()
	{  
		if(uri_string()):	$cururl	=	uri_string();	else:	$cururl	=	base_url();	endif;	
		/*if(($this->router->fetch_class() == 'deal' || $this->router->fetch_class() == 'error') && ($this->router->fetch_method() == 'index' || $this->router->fetch_method() == 'merchant')):
			$cururl	=	base_url().'error';
		endif;		
		$cururl		=	str_replace('http://localhost/savior/','http://algosoftech.in/demo/saviorci/',$cururl);*/
		$this->db->select('*');
		$this->db->from('seo');
		$this->db->like('URI', $cururl, 'before');
		$this->db->where("status  = 'Y'");
		$query = $this->db->get();
		//echo $this->db->last_query(); die;
		if($query->num_rows() > 0):
			return $query->row();
		else:
			return false;
		endif;
	}
	
	/***********************************************************************
	** Function name : get_cms_data
	** Developed By : Tejaswi
	** Purpose  : This function used for CMS Data
	** Date : 18 JULY 2019
	************************************************************************/
	public function get_cms_data($table="",$type="",$limit='')
	{
		$this->db->select('*');
		$this->db->from($table);
		if($limit <> ""):
		$this->db->limit($limit);
	    endif;
		$this->db->where('status','A');
		$query = $this->db->get();
        if($query->num_rows() > 0):
			if($type == 'single'):
               return $query->row_array();
           elseif($type == 'multiple'):
           	   return $query->result_array();
			endif;
		endif;
	}	// END OF FUNCTION

	/***********************************************************************
	** Function name : get_content_cms
	** Developed By : Tejaswi
	** Purpose  : This function used for CMS Data
	** Date : 18 JULY 2019
	************************************************************************/
	public function get_content_cms($table="",$type="")
	{
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('page_type',$type);
		$query = $this->db->get();
        if($query->num_rows() > 0):
           	return $query->result_array();
		endif;
	}	// END OF FUNCTION
	
	/***********************************************************************
	** Function name : get_services_for_homes
	** Developed By : Ravi Kumar
	** Purpose  : This function get services for homes
	** Date : 20 AUGUST 2019
	************************************************************************/
	public function get_services_for_homes()
	{
		$this->db->select('id,service_id, service_name, service_slug, service_image, shortdesc, service_audio, image_alt,mobile_icon');
		$this->db->from('services');
		$this->db->where("status = 'A'");
		$query = $this->db->get();
        if($query->num_rows() > 0):
           	return $query->result_array();
		endif;
	}	// END OF FUNCTION

	/***********************************************************************
	** Function name : get_service_id
	** Developed By : Ravi Kumar
	** Purpose  : This function get service id
	** Date : 20 AUGUST 2019
	************************************************************************/
	public function get_service_id($table='',$field_name='',$field_value='')
	{
		$this->db->select('id,service_id');
		$this->db->from($table);
		$this->db->where($field_name,$field_value);
		$this->db->where("status = 'A'");
		$query = $this->db->get();
        if($query->num_rows() > 0):
           $data = $query->row_array();
           	return $data['service_id'];

		endif;
	}	// END OF FUNCTION

	/***********************************************************************
	** Function name : get_merchnat_user_id
	** Developed By : Ravi Kumar
	** Purpose  : This function get_merchnat_user_id
	** Date : 20 AUGUST 2019
	************************************************************************/
	public function get_merchnat_user_id($table='',$field_name='',$field_value='')
	{
		$this->db->select('user_id');
		$this->db->from($table);
		$this->db->where($field_name,$field_value);
		$this->db->where("status = 'A'");
		$query = $this->db->get();
        if($query->num_rows() > 0):
           $data = $query->row_array();
           	return $data['user_id'];

		endif;
	}	// END OF FUNCTION


	
	/***********************************************************************
	** Function name : get_city_for_homes
	** Developed By : Ravi Kumar
	** Purpose  : This function get city for homes
	** Date : 21 AUGUST 2019
	************************************************************************/
	public function get_city_for_homes($state='',$type='')
	{
		$this->db->select('c.id,c.city_id, c.city_name, c.city_alias,s.state_id');
		$this->db->from('city as c');
		$this->db->join('state as s','s.state_id = c.state_id','LEFT');
		if($type == 'front'):
			$this->db->where('s.state_alias',$state);
		elseif($type == 'frontbuy'):
			$this->db->where('s.state_id',$state);
		elseif($type == 'filter'):
			$this->db->where('c.status','A');
		else:
			$this->db->where('s.state_name',$state);
		endif;
		$this->db->order_by('city_name','ASC');
		$this->db->where("c.status = 'A'");
		$query = $this->db->get();
		//echo $this->db->last_query(); die;
        if($query->num_rows() > 0):
           	return $query->result_array();
		endif;
	}	// END OF FUNCTION
	
	/***********************************************************************
	** Function name : get_state_for_homes
	** Developed By : Ravi Kumar
	** Purpose  : This function get state for homes
	** Date : 21 AUGUST 2019
	************************************************************************/
	public function get_state_for_homes($country='')
	{
		$this->db->select('s.id,s.state_id,s.state_name,s.state_alias');
		$this->db->from('state as s');
		if($country<> ""):
			$this->db->join('country as c','c.country_id = s.country_id');
			$this->db->where('country_alias',$country);
		endif;
		$this->db->where("s.status = 'A'");
		$this->db->order_by('s.state_name','ASC');
		$query = $this->db->get();
		//echo $this->db->last_query();die;
		if($query->num_rows() > 0):
           	return $query->result_array();
		endif;
	}	// END OF FUNCTION
	/***********************************************************************
	** Function name : get_country_for_homes
	** Developed By : Ravi Kumar
	** Purpose  : This function get country for homes
	** Date : 21 AUGUST 2019
	************************************************************************/
	public function get_country_for_homes()
	{
		$this->db->select('id,country_id, country_name, country_alias');
		$this->db->from('country');
		$this->db->order_by('country_name','ASC');
		$this->db->where("status = 'A'");
		$query = $this->db->get();
		//echo $this->db->last_query(); die;
        if($query->num_rows() > 0):
           	return $query->result_array();
		endif;
	}	// END OF FUNCTION
	
	/***********************************************************************
	** Function name : check_existdata
	** Developed By : Tejaswi
	** Purpose  : This function used for check_existdata
	** Date : 18 JULY 2019
	************************************************************************/
	public function check_existdata($table="",$field_type="",$field_value='',$type="",$user_type='',$label='')
	{
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($field_type,$field_value);
		if($user_type <> ""):
		$this->db->where('user_type',$user_type);
		$this->db->where('user_label',$label);
		endif;
		//$this->db->where('status','A');
		$query = $this->db->get();
		//echo $this->db->last_query();die;
        if($query->num_rows() > 0):
        	if($type == "single"):
           	return $query->row_array();
            else:
            return $query->result_array();	
            endif;
		endif;
	}	// END OF FUNCTION

	/***********************************************************************
	** Function name : get_profile_data
	** Developed By : Tejaswi
	** Purpose  : This function used for get_profile_data
	** Date : 18 JULY 2019
	************************************************************************/
	public function get_profile_data($table="",$field_type="",$field_value='',$type='')
	{
		//echo $type;die;
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($field_type,$field_value);
		if($type == "single"):
		$this->db->where('status','A');
		$query = $this->db->get();
        if($query->num_rows() > 0):
           	return $query->row_array();
		endif;
	    else:
	   // echo "hie";die;
	    $this->db->where('status','Y');
		$query = $this->db->get();
		//echo $this->db->last_query();die;
        if($query->num_rows() > 0):
           	return $query->result_array();
		endif;
	    endif;
	}	// END OF FUNCTION

	/***********************************************************************
	** Function name : get_days
	** Developed By : Tejaswi
	** Purpose  : This function used for get_days
	** Date : 18 JULY 2019
	************************************************************************/
	public function get_days()
	{
		$days = array('monday','tuesday','wednesday','thursday','friday','saturday','sunday');
		return $days;
	}	// END OF FUNCTION

    /***********************************************************************
	** Function name : get_password
	** Developed By : Tejaswi
	** Purpose  : This function used for get_password
	** Date : 18 JULY 2019
	************************************************************************/
	public function get_password($table="",$field_type="",$field_value='')
	{
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($field_type,$field_value);
		$this->db->where('status','A');
		$query = $this->db->get();
        if($query->num_rows() > 0):
           $data =  $query->row_array();
           return $data['user_password'];
		endif;
	}	// END OF FUNCTION
	
	/***********************************************************************
	** Function name : get_banner_for_homes
	** Developed By : Ravi Kumar
	** Purpose  : This function get banner for homes
	** Date : 23 AUGUST 2019
	************************************************************************/
	public function get_banner_for_homes()
	{
		$this->db->select('id, banner_id, banner_image, banner_alt');
		$this->db->from('banner');
		$this->db->where("status = 'A'");
		$query = $this->db->get();
        if($query->num_rows() > 0):
           	return $query->result_array();
		endif;
	}	// END OF FUNCTION

	/***********************************************************************
	** Function name : get_appslider
	** Developed By : Ravi Kumar
	** Purpose  : This function get appslider
	** Date : 23 AUGUST 2019
	************************************************************************/
	public function get_appslider()
	{
		$this->db->select('*');
		$this->db->from('app_slider');
		$this->db->where("status = 'A'");
		$query = $this->db->get();
        if($query->num_rows() > 0):
           	return $query->result_array();
		endif;
	}	// END OF FUNCTION
	/***********************************************************************
	** Function name : get_testimonials
	** Developed By : Tejaswi
	** Purpose  : This function used for get_testimonials
	** Date : 18 JULY 2019
	************************************************************************/
	public function get_testimonials($table="",$type='',$id='')
	{
		$this->db->select('*');
		$this->db->from($table);
		if($id <> ""):
			$this->db->where('userid',$id);
		endif;
		if($type == 'multiple'):
		$this->db->where('status','A');
	    endif;
		$query = $this->db->get();
		//echo $this->db->last_query();die;
        if($query->num_rows() > 0):
        	//$data =  $query->result_array();
        	if($type == 'single'):
        		$data =  $query->row_array();
        	else:
        		$data =  $query->result_array();
        	endif;
           return $data;
		endif;
	}	// END OF FUNCTION

	/***********************************************************************
	** Function name : get_general
	** Developed By : Tejaswi
	** Purpose  : This function used for get_general
	** Date : 18 JULY 2019
	************************************************************************/
	public function get_general()
	{
		$this->db->select('*');
		$this->db->from('general_data');
		$this->db->where('status','A');
		$query = $this->db->get();
        if($query->num_rows() > 0):
           $data =  $query->row_array();
           return $data;
		endif;
	}	// END OF FUNCTION

	/***********************************************************************
	** Function name : get_roadassis
	** Developed By : Tejaswi
	** Purpose  : This function used for get_roadassis
	** Date : 18 JULY 2019
	************************************************************************/
	public function get_roadassis($table='')
	{
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('status','A');
		$query = $this->db->get();
        if($query->num_rows() > 0):
           $data =  $query->row_array();
           return $data;
		endif;
	}	// END OF FUNCTION

	/***********************************************************************
	** Function name : get_homeabout
	** Developed By : Tejaswi
	** Purpose  : This function used for get_homeabout
	** Date : 18 JULY 2019
	************************************************************************/
	public function get_homeabout($table='')
	{
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('status','A');
		$query = $this->db->get();
        if($query->num_rows() > 0):
           $data =  $query->row_array();
           return $data;
		endif;
	}	// END OF FUNCTION

	/***********************************************************************
	** Function name : get_order_process
	** Developed By : Tejaswi
	** Purpose  : This function used for get_order_process
	** Date : 18 JULY 2019
	************************************************************************/
	public function get_order_process($table='')
	{
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('status','A');
		$query = $this->db->get();
        if($query->num_rows() > 0):
           $data =  $query->result_array();
           return $data;
		endif;
	}	// END OF FUNCTION
	/***********************************************************************
	** Function name : get_bannercontent
	** Developed By : Tejaswi
	** Purpose  : This function used for get_bannercontent
	** Date : 18 JULY 2019
	************************************************************************/
	public function get_bannercontent($table='')
	{
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('status','A');
		$query = $this->db->get();
        if($query->num_rows() > 0):
           $data =  $query->row_array();
           return $data;
		endif;
	}	// END OF FUNCTION		

	/***********************************************************************
	** Function name : get_chooseus
	** Developed By : Tejaswi
	** Purpose  : This function used for get_chooseus
	** Date : 18 JULY 2019
	************************************************************************/
	public function get_chooseus($table='')
	{
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('status','A');
		$query = $this->db->get();
        if($query->num_rows() > 0):
           $data =  $query->row_array();
           return $data;
		endif;
	}	// END OF FUNCTION		

	/***********************************************************************
	** Function name : get_ad_banner
	** Developed By : Tejaswi
	** Purpose  : This function used for get_ad_banner
	** Date : 18 JULY 2019
	************************************************************************/
	public function get_ad_banner($pagename='')
	{
		$this->db->select('*');
		$this->db->from('advertisement');
		$this->db->where('title_slug',$pagename);
		$this->db->where('status','A');
		$query = $this->db->get();
        if($query->num_rows() > 0):
           $data =  $query->row_array();
           return $data;
		endif;
	}	// END OF FUNCTION		

	/***********************************************************************
	** Function name : check_data
	** Developed By : Tejaswi
	** Purpose  : This function used for check_data
	** Date : 18 JULY 2019
	************************************************************************/
	public function check_data($table='',$phone='',$type_field='',$user_type='')
	{
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('user_phone',$phone);
		$this->db->where($type_field,$user_type);
		$query = $this->db->get();
        if($query->num_rows() > 0):
           $data =  $query->row_array();
           return $data;
		endif;
	}	// END OF FUNCTION	

	/***********************************************************************
	** Function name : match_otp
	** Developed By : Tejaswi
	** Purpose  : This function used for match_otp
	** Date : 18 JULY 2019
	************************************************************************/
	public function match_otp($table='',$field_type='',$field_value='',$user_type='')
	{
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($field_type,$field_value);
		$this->db->where('user_type',$user_type);
		$query = $this->db->get();
        if($query->num_rows() > 0):
           $data =  $query->row_array();
           return $data;
		endif;
	}	// END OF FUNCTION		
	
    /***********************************************************************
	** Function name : getvehiclefueldata
	** Developed By : Tejaswi
	** Purpose  : This function getvehiclefueldata
	** Date : 23 AUGUST 2019
	************************************************************************/
	public function getvehiclefueldata($table='')
	{
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where("status = 'A'");
		$query = $this->db->get();
        if($query->num_rows() > 0):
           	return $query->result_array();
		endif;
	}	// END OF FUNCTION
	/***********************************************************************
	** Function name : getvehicledata
	** Developed By : Tejaswi
	** Purpose  : This function getvehicledata
	** Date : 23 AUGUST 2019
	************************************************************************/
	public function getvehicledata($tabel='',$id='')
	{
		$this->db->select('vt.vehicle_type_name,vt.vehicle_type_id,ft.fuel_type_name,ft.fuel_type_id,uv.registration_year,uv.id');
		$this->db->from('user_vehicle_type as uv');
		$this->db->join('vehicle_type as vt','vt.vehicle_type_id = uv.vehicle_type_id');
		$this->db->join('fuel_type as ft','ft.fuel_type_id = uv.fuel_type_id');
		$this->db->where("uv.status = 'A'");
		$this->db->where("uv.user_id",$id);
		$query = $this->db->get();
		//echo $this->db->last_query();die;
        if($query->num_rows() > 0):
           	return $query->result_array();
		endif;
	}	// END OF FUNCTION

	/***********************************************************************
	** Function name : get_pakage_details
	** Developed By : Tejaswi
	** Purpose  : This function get_pakage_details
	** Date : 23 AUGUST 2019
	************************************************************************/
	public function get_pakage_details($table='')
	{
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where("status = 'A'");
		$this->db->order_by('orders','ASC');
		$query = $this->db->get();
        if($query->num_rows() > 0):
           	return $query->result_array();
		endif;
	}	// END OF FUNCTION
	
	/***********************************************************************
	** Function name : get_active_details
	** Developed By : Ravi Kumar
	** Purpose  : This function get_active_pakage
	** Date : 23 OCTOBER 2019
	************************************************************************/
	public function get_active_pakage($pid='')
	{
		$this->db->select('*');
		$this->db->from("package_details");
		$this->db->where("package_id",$pid);
		$this->db->where("status = 'A'");
		//$this->db->order_by('orders','ASC');
		$query = $this->db->get();
        if($query->num_rows() > 0):
           	return $query->row_array();
		endif;
	}	// END OF FUNCTION
	
	/***********************************************************************
	** Function name : get_referaldata
	** Developed By : Ravi Kumar
	** Purpose  : This function get_referaldata
	** Date : 23 OCTOBER 2019
	************************************************************************/
	public function get_referaldata($table='',$referal='')
	{
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where("sales_p_referral",$referal);
		$this->db->where("status = 'A'");
		//$this->db->order_by('orders','ASC');
		$query = $this->db->get();
        if($query->num_rows() > 0):
           	return $query->row_array();
		endif;
	}	// END OF FUNCTION

	/***********************************************************************
	** Function name : get_ratingddata
	** Developed By : Tejaswi
	** Purpose  : This function get_ratingddata
	** Date : 23 OCTOBER 2019
	************************************************************************/
	public function get_ratingddata($table='',$field_name='',$field_value='',$type='',$merchant_id='')
	{
		$this->db->select('rr.*,u.user_name,u.user_image,s.service_name');
		$this->db->from($table);
		if($type=="users"):
		$this->db->join('users as u','rr.merchant_id = u.user_id');
	    else:
	    $this->db->join('users as u','rr.user_id = u.user_id');
	    endif;
		$this->db->join('services as s','s.service_id = rr.service_type_id');
		$this->db->where($field_name,$field_value);
		if($type =="user"):
			$this->db->where('merchant_id',$merchant_id);
		endif;
		$this->db->where("rr.status = 'A'");
		//$this->db->order_by('orders','ASC');
		$query = $this->db->get();
		//echo $this->db->last_query();die;
        if($query->num_rows() > 0):
           	return $query->result_array();
		endif;
	}	// END OF FUNCTION

	/***********************************************************************
	** Function name : get_order_deatils
	** Developed By : Tejaswi
	** Purpose  : This function get_order_deatils
	** Date : 23 OCTOBER 2019
	************************************************************************/
	public function get_order_deatils($table='',$field_name='',$field_value='')
	{
		$this->db->select('o.*,u.user_name,u.user_image,s.service_name');
		$this->db->from($table);
		$this->db->join('users as u','o.user_id = u.user_id');
		$this->db->join('services as s','s.service_id = o.service_type_id');
		$this->db->where($field_name,$field_value);
		$this->db->where("o.status = 'A'");
		//$this->db->order_by('orders','ASC');
		$query = $this->db->get();
        if($query->num_rows() > 0):
           	return $query->result_array();
		endif;
	}	// END OF FUNCTION

	/***********************************************************************
	** Function name : get_sproviderservices
	** Developed By : Ravi Kumar
	** Purpose  : This function get_sproviderservices
	** Date : 23 OCTOBER 2019
	************************************************************************/
	public function get_sproviderservices($table='',$field_name='',$field_value='')
	{
		$returnData		=	array();
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($field_name,$field_value);
		$this->db->where("status = 'A'");
		//$this->db->order_by('orders','ASC');
		$query = $this->db->get();
		//echo $this->db->last_query();die;
        if($query->num_rows() >0):	
			$data 	=	$query->result_array();
			//print_r($data);die;
			foreach($data as $value):
				array_push($returnData,$value['service_id']);
			endforeach;
		endif;
		return $returnData;
	}	// END OF FUNCTION
	/***********************************************************************
	** Function name: get_forgot_code
	** Developed By: Tejaswi
	** Purpose: This function used for get forgot code
	** Date: 18 JULY 2019
	************************************************************************/
	public function get_forgot_code($textlength='6')
	{
		$chars = "1234567890";
		$pwd = "";
		
		for ($i = 0; $i < $textlength; $i++) {
			$pwd .= $chars[mt_rand(0, strlen($chars)-1)];
		}
		return $pwd;
	}	

	/***********************************************************************
	** Function name: getlimitedchar
	** Developed By: Tejaswi
	** Purpose: This function used for getlimitedchar
	** Date: 18 JULY 2019
	************************************************************************/
	public function getlimitedchar($text='',$length='-2')
	{
		$limitedtext = substr($text, $length);
		return $limitedtext;
	}		

	/***********************************************************************
	** Function name : gettotalRating
	** Developed By : tejaswi
	** Purpose  : This function used for get Rating 
	** Date : 17 OCTOBER 2018
	************************************************************************/
	function gettotalRating($merchantId='')
	{
		$ratingData['rating']		=	floatval(0);
		$ratingData['count']		=	floatval(0);
		$this->db->select('sum(user_rating) as total_rating, count(user_rating) as total_count');
		$this->db->from('review_rating');
		$this->db->where("merchant_id",$merchantId);
		$query	=	$this->db->get();
		//echo $this->db->last_query();die;
		if($query->num_rows() > 0):  
			$data 	=	$query->row_array(); 
			if($data['total_rating'] > 0 && $data['total_count'] > 0):
				$ratingData['rating']		=	floatval($data['total_rating']/$data['total_count']);
				$ratingData['count']		=	floatval($data['total_count']);
			endif;
		endif; 
		return $ratingData;
	}	// END OF FUNCTION 	 

	/***********************************************************************
	** Function name : getlimitdata
	** Developed By : Tejaswi
	** Purpose  : This function used for getlimitdata
	** Date : 18 JULY 2019
	************************************************************************/
	public function getlimitdata($user_id='',$city_name='',$action='')
	{
		$result = array();
		$this->db->select('ud.*,c.city_name,c.city_alias');
		$this->db->from('wems_user_daily_limit as ud');
		$this->db->join('wems_city as c','ud.city_id = c.city_id');
		$this->db->where('ud.user_id',$user_id);
		if($action == 'data'):
		$this->db->where('c.city_alias',$city_name);
	    endif;
		$this->db->group_by('ud.city_id');
		$this->db->order_by('c.id','DESC');
		$query = $this->db->get();
		//echo $this->db->last_query();die;
        if($query->num_rows() > 0):
         if($action == 'data'):
           $data =  $query->result_array();
           foreach($data as $result){
           	array_push($result,$result['city_alias']);
           }
           return $result;
          elseif($action=='count'):
          	return $query->result_array();
          
         endif;
		endif;
	}	// END OF FUNCTION	

	/***********************************************************************
	** Function name : getallratingdata
	** Developed By : Ravi Kumar
	** Purpose  : This function getallratingdata
	** Date : 23 OCTOBER 2019
	************************************************************************/
	public function getallratingdata($merchant_id='',$service_name='')
	{   
		$this->db->select('u.user_id as userid,m.user_id as merchantid,u.user_name
		,m.user_name as merchant_name,s.service_name,r.rating_id,
		r.user_rating,r.user_review,r.creation_date');
		$this->db->from('wems_review_rating as r');
		$this->db->join('wems_users as u','r.user_id = u.user_id');
		$this->db->join('wems_users as m','r.merchant_id = m.user_id ');
		$this->db->join('wems_services as s','r.service_type_id = s.service_id');
		$this->db->where('r.merchant_id',$merchant_id);
		$this->db->where('s.service_name',$service_name);
		
		//$this->db->order_by('orders','ASC');
		$query = $this->db->get();
		// /echo $this->db->last_query();die;
        if($query->num_rows() >0):	
			$data 	=	$query->result_array();
			return $data;
		endif;
		
	}	// END OF FUNCTION

	/***********************************************************************
	** Function name : get_state_id
	** Developed By : Ravi Kumar
	** Purpose  : This function get_state_id
	** Date : 21 AUGUST 2019
	************************************************************************/
	public function get_state_id($state_alias='')
	{
		$this->db->select('state_id');
		$this->db->from('state');
		//$this->db->order_by('state_name','ASC');
		$this->db->where("state_name",$state_alias);
		$query = $this->db->get();
		//echo $this->db->last_query(); die;
        if($query->num_rows() > 0):
           	 $data = $query->row_array();
           	 return $data['state_id'];
		endif;
	}	// END OF FUNCTION

	/***********************************************************************
	** Function name : checkexistcity
	** Developed By : Ravi Kumar
	** Purpose  : This function checkexistcity
	** Date : 21 AUGUST 2019
	************************************************************************/
	public function checkexistcity($table='',$field_name='',$field_value='')
	{
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($field_name,$field_value);
		$query = $this->db->get();
		//echo $this->db->last_query(); die;
        if($query->num_rows() > 0):
           	return $query->result_array();
		endif;
	}	// END OF FUNCTION

	/***********************************************************************
	** Function name : getuserbyip
	** Developed By : Ravi Kumar
	** Purpose  : This function getuserbyip
	** Date : 21 AUGUST 2019
	************************************************************************/
	public function getuserbyip($ip='',$date='')
	{
		$this->db->select('*');
		$this->db->from('wems_total_usersvisit_perday');
		$this->db->where('user_ip',$ip);
		$this->db->where('creation_date',$date);
		$query = $this->db->get();
		//echo $this->db->last_query(); die;
        if($query->num_rows() > 0):
           	return $query->num_rows();
          else:
          	return false;
		endif;
	}	// END OF FUNCTION


	/***********************************************************************
	** Function name: getLoginBrowserData
	** Developed By: Manoj Kumar
	** Purpose: This function used for get data by encryptId
	** Date : 18 JULY 2019
	************************************************************************/
	public function getLoginBrowserData($fieldName='',$fieldValue='')
	{  
		$this->db->select('*');
		$this->db->from('users_login_log');	
		$this->db->where($fieldName,$fieldValue);
		$this->db->order_by('id',DESC);
		$this->db->limit(1);
		$query = $this->db->get();
		//echo $this->db->last_query();die;
		if($query->num_rows() > 0):
			$data =  $query->row_array();
			$loginbrowserdata = $data['login_token'];
			//echo $loginbrowserdata;die;
			if($loginbrowserdata != $this->session->userdata('USER_LOGIN_TOKEN')):
				redirect(base_url().'user/logout');
		    endif;
		else:
			redirect(base_url().'user/logout');
		endif;
	}	// END OF FUNCTION

	/***********************************************************************
	** Function name: getLoginBrowserDataMer
	** Developed By: Manoj Kumar
	** Purpose: This function used for get data by encryptId
	** Date : 18 JULY 2019
	************************************************************************/
	public function getLoginBrowserDataMer($fieldName='',$fieldValue='')
	{  
		$this->db->select('*');
		$this->db->from('users_login_log');	
		$this->db->where($fieldName,$fieldValue);
		$this->db->order_by('id',DESC);
		$this->db->limit(1);
		$query = $this->db->get();
		//echo $this->db->last_query();die;
		if($query->num_rows() > 0):
			$data =  $query->row_array();
			$loginbrowserdata = $data['login_token'];
			//echo $loginbrowserdata;die;
			if($loginbrowserdata != $this->session->userdata('MERCHANT_LOGIN_TOKEN')):
				redirect(base_url().'sproviders/logout');
		    endif;
		else:
			return false;
		endif;
	}	// END OF FUNCTION

	/***********************************************************************
	** Function name : getSelectedVehicleType
	** Developed By : Manoj Kumar
	** Purpose  : This function used for get Selected Vehicle Type
	** Date : 25 JULY 2019
	************************************************************************/
	function getSelectedVehicleType($merchantId='',$merchantServicesId='')	
	{
		$returnData		=	array();
		$this->db->select('vehicle_type_id');
		$this->db->from('merchant_vehicle_type');
		$this->db->where('merchant_services_id',$merchantServicesId);
		$this->db->where('merchant_id',$merchantId);
		$query	=	$this->db->get();
		if($query->num_rows() >0):	
			$data 	=	$query->result_array();
			foreach($data as $value):
				array_push($returnData,$value['vehicle_type_id']);
			endforeach;
		endif;
		return $returnData;
	}	// END OF FUNCTION

	/***********************************************************************
	** Function name : getVehicleType
	** Developed By : Manoj Kumar
	** Purpose  : This function used for get Vehicle Type
	** Date : 25 JULY 2019
	************************************************************************/
	function getVehicleType()	
	{
		$this->db->select('vehicle_type_id,vehicle_type_name,image');
		$this->db->from('vehicle_type');
		$this->db->where("status = 'A'");
		$this->db->order_by("id ASC");
		$query	=	$this->db->get();
		if($query->num_rows() >0):	
			return $query->result_array();
		else:
			return false;
		endif;
	}	// END OF FUNCTION

	/***********************************************************************
	** Function name : getMainVehicleType
	** Developed By : Manoj Kumar
	** Purpose  : This function used for get Vehicle Type
	** Date : 25 JULY 2019
	************************************************************************/
	function getMainVehicleType()	
	{
		$this->db->select('main_vehicle_type_id,main_vehicle_type_name');
		$this->db->from('main_vehicle_type');
		$this->db->where("status = 'A'");
		$this->db->order_by("id ASC");
		$query	=	$this->db->get();
		if($query->num_rows() >0):	
			return $query->result_array();
		else:
			return false;
		endif;
	}	// END OF FUNCTION
	/***********************************************************************
	** Function name : getVehicleTypeList
	** Developed By : Manoj Kumar
	** Purpose  : This function used for get Vehicle Type List
	** Date : 25 JULY 2019
	************************************************************************/
	function getVehicleTypeList($merchantId='',$type='',$service_id='')	
	{
		$this->db->select('vt.vehicle_type_id, vt.vehicle_type_name');
		$this->db->from('merchant_vehicle_type as mvt');
		$this->db->join("vehicle_type as vt","mvt.vehicle_type_id=vt.vehicle_type_id","LEFT");
		$this->db->where('mvt.merchant_id',$merchantId);
		if($service_id):
			$this->db->where('mvt.merchant_services_id',$service_id);
		endif;
		$this->db->group_by('mvt.vehicle_type_id');
		$query	=	$this->db->get();
		if($query->num_rows() >0):	
			if($type == 'single'):
				return $query->row_array();
			else:
				return $query->result_array();
			endif;
		else:
			return false;
		endif;
	}	// END OF FUNCTION

	/***********************************************************************
	** Function name : getMerchantServicesData
	** Developed By : Manoj Kumar
	** Purpose  : This function used for get Merchant Services Data
	** Date : 22 JULY 2019
	************************************************************************/
	function getMerchantServicesData($action='',$tblName='',$whereCon='',$shortField='',$numPage='',$cnt='')
	{ 
		$this->db->select('merser.*, ser.service_name, ser.service_image');
		$this->db->from($tblName);
		$this->db->join("services as ser","merser.service_id=ser.service_id","LEFT");
		if($whereCon['where']):	$this->db->where($whereCon['where']);	 	endif;
		if($whereCon['like']):  $this->db->where($whereCon['like']); 		endif;
		if($shortField):		$this->db->order_by($shortField);			endif;
		$this->db->group_by("merser.service_id");
		if($numPage):			$this->db->limit($numPage,$cnt);			endif;
		$query = $this->db->get();  
		if($action == 'data'):	
			if($query->num_rows() > 0):	
				return $query->result_array();
			else:
				return false;
			endif;
		elseif($action == 'count'):
			return $query->num_rows();
		endif;
	}	// END OF FUNCTION
	/***********************************************************************
	** Function name : getServiceType
	** Developed By : Manoj Kumar
	** Purpose  : This function used for get Service Type
	** Date : 25 JULY 2019
	************************************************************************/
	function getServiceType($serviceId='')
	{
		$html			=	'<option value="">Select Service Type</option>';
		$this->db->select('service_id,service_name');
		$this->db->from('services');
		$this->db->where("status = 'A'");
		$this->db->order_by("service_name ASC");
		$query	=	$this->db->get();
		if($query->num_rows() >0):	
			$data	=	$query->result_array();
			foreach($data as $info): 
				if($info['service_id'] == $serviceId):  $select ='selected="selected"'; else: $select =''; endif;
				$html		.=	'<option value="'.$info['service_id'].'" '.$select.'>'.$info['service_name'].'</option>';
			endforeach;
		endif;
			
		return $html;
	}	// END OF FUNCTION

	/***********************************************************************
	** Function name : getAddressData
	** Developed By : Manoj Kumar
	** Purpose  : This function used for get Address Data
	** Date : 13 OCTOBER 2018
	************************************************************************/
	function getAddressData($userId='',$count='')
	{
		$this->db->select('address_id,add_name,add_phone,add_address1,add_address2,add_city,add_state,add_pincode,add_type');
		$this->db->from('users_address');
		$this->db->where("user_id",$userId);
		$this->db->where("status = 'Y'");
		$this->db->order_by("address_id ASC");
		if($count):
			$this->db->limit($count);
		endif;
		$query	=	$this->db->get();
		if($query->num_rows() > 0):
			return $query->result_array();
		else:
			return false;
		endif;
	}	// END OF FUNCTION

	/***********************************************************************
	** Function name : get_product_listing
	** Developed By : TEJASWI
	** Purpose  : This function get get_product_listing
	** Date : 23 APRIL 2020
	************************************************************************/
	public function get_product_listing($action='',$product_id='',$limit='')
	{ 
		$returnData					=		array();
		$this->db->select('u.user_name,prod.prod_id,prod.item_name,prod.item_name_slug,prod.item_weight,prod.item_price,prod.short_description,prod.full_description,prod.product_dimensions,prod.material,prod.estimated_delivery,prod.item_image,prod.created_by,prod.status');
		$this->db->from('product as prod');
		$this->db->join('users as u','u.user_id = prod.created_by');
		if($product_id <> ""):
			$this->db->where('prod.item_name_slug',$product_id);
		endif;
		if($limit <> ""):
			$this->db->limit($limit);
		endif;
		$query = $this->db->get();
		//echo $this->db->last_query();die;
		if($query->num_rows() > 0):
			if($action == 'multiple'):
				$data = $query->result_array();

				if($data <> ""):
					foreach($data as $data):
						//$whereCon['vehicle_details_id']		=	$data['vehicle_details_id'];
						//$whereCon['user_id']				=	$this->session->userdata('user_id');
						$multipleImages						=	$this->common_model->getAllData('prod_image','prod_id',$data['prod_id']);
						//$likedvehicles						=	$this->getSelectFieldInArray('multiple','vehicle_details_id','vehicle_likes','','',$whereCon);
						$resultData['prod_id']				=	$data['prod_id']?$data['prod_id']:"";
						$resultData['item_name']			=	$data['item_name']?$data['item_name']:"";
						$resultData['item_name_slug']		=	$data['item_name_slug']?$data['item_name_slug']:"";
						$resultData['item_weight']			=	$data['item_weight']?$data['item_weight']:"";
						$resultData['item_price']			=	$data['item_price']?$data['item_price']:"";
						$resultData['short_description']	=	$data['short_description']?$data['short_description']:"";
						$resultData['full_description']		=	$data['full_description']?$data['full_description']:"";
						$resultData['product_dimensions']	=	$data['product_dimensions']?$data['product_dimensions']:"";
						$resultData['material']				=	$data['material']?$data['material']:"";
						$resultData['estimated_delivery']	=	$data['estimated_delivery']?$data['estimated_delivery']:"";
						$resultData['item_image']			=	$data['item_image']?$data['item_image']:"";
						$resultData['user_name']			=	$data['user_name']?$data['user_name']:"";
						$resultData['status']			=	$data['status']?$data['status']:"";
						array_push($returnData,$resultData);
					
					endforeach;
					return $returnData;
				endif;
			elseif($action == 'single'):
				$data 	=	$query->row_array();
				if($data <> ""):
						//$whereCon['vehicle_details_id']		=	$data['vehicle_details_id'];
						//$whereCon['user_id']				=	$this->session->userdata('user_id');
						$multipleImages						=	$this->common_model->getAllData('prod_image','prod_id',$data['prod_id']);
						//$likedvehicles						=	$this->getSelectFieldInArray('multiple','vehicle_details_id','vehicle_likes','','',$whereCon);
						$resultData['prod_id']				=	$data['prod_id']?$data['prod_id']:"";
						$resultData['item_name']			=	$data['item_name']?$data['item_name']:"";
						$resultData['item_name_slug']		=	$data['item_name_slug']?$data['item_name_slug']:"";
						$resultData['item_weight']			=	$data['item_weight']?$data['item_weight']:"";
						$resultData['item_price']			=	$data['item_price']?$data['item_price']:"";
						$resultData['short_description']	=	$data['short_description']?$data['short_description']:"";
						$resultData['full_description']		=	$data['full_description']?$data['full_description']:"";
						$resultData['product_dimensions']	=	$data['product_dimensions']?$data['product_dimensions']:"";
						$resultData['material']				=	$data['material']?$data['material']:"";
						$resultData['estimated_delivery']	=	$data['estimated_delivery']?$data['estimated_delivery']:"";
						$resultData['item_image']			=	$data['item_image']?$data['item_image']:"";
						$resultData['user_name']			=	$data['user_name']?$data['user_name']:"";
						$resultData['status']				=	$data['status']?$data['status']:"";
						$resultData['multipleImages']		=	$multipleImages?$multipleImages:"";
						return $resultData;
				endif;
			endif;
		endif;
	}

}	