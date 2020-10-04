<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function  __construct() 
	{ 
		parent:: __construct();
		error_reporting(E_ALL ^ E_NOTICE);
		$this->load->model(array('front_model','common_model'));
		$this->lang->load('statictext','english');
		$this->load->helper('general','common');  
	} 
	
	/* * *********************************************************************
	 * * Function name : login
	 * * Developed By : Tejaswi
	 * * Purpose  : This function use for Login
	 * * Date : 31 AUGUST 2020
	 * * **********************************************************************/
	public function login($redirectUrl='')
	{
		if($this->session->userdata('VB_USER_ID') <> ''):
			redirect(base_url().'my-profile');
		endif;
		if($redirectUrl):
	   		$this->session->set_userdata('VB_LOGIN_RED_URL',$redirectUrl);
			redirect(base_url().'login');
		endif;
		if($this->input->post('mobile_number')):  
			$mobile_number 	=	trim($this->input->post('mobile_number'));
			$result 		=	$this->common_model->getAllData('vb_users','mobile_number',$mobile_number,'','','single');
			if($result):
				if($this->common_model->decryptsPassword($result['password']) != trim($this->input->post('password'))):
					echo "wrongpassword";die;
				elseif($result['status'] == 'A'):
					if($result['user_phone_verify'] == 'Y'):
						$remember_me		=	$this->input->post('loggedin');
						$mobile_number		=	$this->input->post('mobile_number');
						$password			=	$this->input->post('password');
						$this->afterloginProcess($result,$remember_me,$mobile_number,$password);
					else:
						if($this->input->post('loggedin') == 'YES'):
							$this->session->set_userdata(array('VB_REGISTER_MOBILE'=>$result['mobile_number'],'VB_REMEMBER_ME'=>'YES','VB_REMEMBER_MOBILE'=>$this->input->post('mobile_number'),'VB_REMEMBER_PASSWORD'=>$this->input->post('password')));
						else:
							$this->session->set_userdata(array('VB_REGISTER_MOBILE'=>$result['mobile_number'],'VB_REMEMBER_ME'=>'NO','VB_REMEMBER_MOBILE'=>$this->input->post('mobile_number'),'VB_REMEMBER_PASSWORD'=>$this->input->post('password')));
						endif;
						$uParam['status']			=	'I';
						$uParam['user_phone_otp']	=	(int)4321;/*generateRandomString(4,'n');*/
						$this->common_model->editData('vb_users',$uParam,'user_id',(int)$result['user_id']);
						echo "accountinactive";die;
					endif;
				elseif($result['status'] == 'I'):
					if($this->input->post('loggedin') == 'YES'):
						$this->session->set_userdata(array('VB_REGISTER_MOBILE'=>$result['mobile_number'],'VB_REMEMBER_ME'=>'YES','VB_REMEMBER_MOBILE'=>$this->input->post('mobile_number'),'VB_REMEMBER_PASSWORD'=>$this->input->post('password')));
					else:
						$this->session->set_userdata(array('VB_REGISTER_MOBILE'=>$result['mobile_number'],'VB_REMEMBER_ME'=>'NO','VB_REMEMBER_MOBILE'=>$this->input->post('mobile_number'),'VB_REMEMBER_PASSWORD'=>$this->input->post('password')));
					endif;
					$uParam['status']			=	'I';
					$uParam['user_phone_otp']	=	(int)4321;/*generateRandomString(4,'n');*/
					$this->common_model->editData('vb_users',$uParam,'user_id',(int)$result['user_id']);
					echo "accountinactive";die;
				else:
					echo "blocked";die;
				endif;
			else:
				echo "noaccount";die;
			endif;
		endif;
		
		$this->layouts->set_title('Login | VBloggers');
		$this->layouts->set_keyword('Login | VBloggers');
		$this->layouts->set_description('Login | VBloggers');
		
		$this->layouts->login_view('user/login',array(),$data);
	}

	/* * *********************************************************************
	 * * Function name : afterloginProcess
	 * * Developed By : Manoj Kumar
	 * * Purpose  : This function used for after login Process
	 * * Date : 31 OCTOBER 2018
	 * * **********************************************************************/
	public function afterloginProcess($result=array(),$remember_me='',$mobile_number='',$password='')
	{
		setcookie('VB_USER_LOGIN_TOKEN',$loginParam['user_token'],time()+60*60*24*100,'/');
						
		$this->session->set_userdata(array(
											'VB_USER_LOGGED_IN'			=>	true,
											'VB_USER_ID'				=>	$result['user_id'],
											'VB_FULL_NAME'				=>	$result['full_name'],
											'VB_USER_EMAIL'				=>	$result['user_email'],
											'VB_USER_MOBILE'			=>	$result['mobile_number'],
											'VB_USER_CURRENT_PATH'		=>	$currentPath));
						
		
		if($remember_me == 'YES'):
			 setcookie("ct_username",$mobile_number,time()+60*60*24*100,'/');
			 setcookie("ct_password",$password,time()+60*60*24*100,'/');
			 setcookie("ct_remember_me",'YES',time()+60*60*24*100,'/');
		else:
			 setcookie("ct_username",$mobile_number,time()-60*60*24*100,'/');
			 setcookie("ct_password",$password,time()-60*60*24*100,'/');
			 setcookie("ct_remember_me",'YES',time()-60*60*24*100,'/');
		endif;
		if($this->session->userdata('VB_LOGIN_RED_URL') <> ""):
	    	 if($this->session->userdata('VB_LOGIN_RED_URL')):
	    	 	$redirectPath 				=	base64_decode($this->session->userdata('VB_LOGIN_RED_URL'));
		    	$this->session->unset_userdata('VB_LOGIN_RED_URL');
	    	    	echo 'redirect____'.$redirectPath.'';die;
	    	 endif;
	   	else:
			echo "success";die;
		endif;
	}

	/* * *********************************************************************
	 * * Function name : signUp
	 * * Developed By : Tejaswi
	 * * Purpose  : This function use for signUp
	 * * Date : 31 AUGUST 2020
	 * * **********************************************************************/
	public function signUp()
	{
		if($this->session->userdata('VB_USER_ID') <> ''):
			redirect(base_url().'my-profile');
		endif;
		if($this->input->post('FormType') == 'registrationForm'):
			if(($this->input->post('user_email') <> "") && ($this->input->post('mobile_number') <> "") && ($this->input->post('password') <> "")):
				$user_name 		=	stripslashes($this->input->post('user_name'));
				$user_email 	=	trim($this->input->post('user_email'));
				$mobile_number 	=	trim($this->input->post('mobile_number'));
				$password 		=	stripslashes($this->input->post('password'));
				
				$existData 		=	$this->common_model->getAllData('vb_users','mobile_number',$mobile_number);
				if($existData == ''):
					$existEmail 		=	$this->common_model->getAllData('vb_users','user_email',$user_email);
					if($existEmail == ''):
						$param['full_name'] 		=	stripslashes($this->input->post('full_name'));
						$param['user_email'] 		=	stripslashes($this->input->post('user_email'));
						$param['mobile_number'] 	=	trim($this->input->post('mobile_number'));
						$param['password'] 			=	$this->common_model->encriptPassword($this->input->post('password'));
						$param['user_phone_otp']	=	4321;/*(int)generateRandomString(4,n);*/
						$param['user_phone_verify']	=	'N';
						
						$param['creation_ip']		=	currentIp();
						$param['creation_date']		=	currentDateTime();
						$param['status']			=	'I';
						$lastInsertId = $this->common_model->addData('users',$param);							
						$Uparam['user_id']			=	generateUniqueId($lastInsertId);
						$Uwhere['id']				=	$lastInsertId;
						$this->common_model->editDataByMultipleCondition('users',$Uparam,$Uwhere);
						   
						$this->session->set_userdata('VB_REGISTER_MOBILE',$param['mobile_number']);
						echo 'success';die;
					else:
						echo "invalidemail";die;
					endif;
				else:
					echo "invalidphone";die;
				endif;
			else:
				echo "wentWrong";die;
			endif;
		endif;
		
		$this->layouts->set_title(stripcslashes('Sign Up | VBloggers'));
		$this->layouts->set_keyword(stripcslashes('Sign Up | VBloggers'));
		$this->layouts->set_description(stripcslashes('Sign Up | VBloggers'));
		
		$this->layouts->login_view('user/signup',array(),$data);
	}

	/* * *********************************************************************
	 * * Function name : otpverification
	 * * Developed By : Manoj Kumar
	 * * Purpose  : This function used for user otp verification
	 * * Date : 11 OCTOBER 2018
	 * * **********************************************************************/
	public function otpverification()
	{	
		if($this->session->userdata('VB_USER_ID') <> ''):
			redirect(base_url().'my-profile');
		endif;
		$data['error'] 						= 	'';
		$data['formError'] 					=	''; 	

		if($this->input->post('verifyotp')):
				$userData		=	$this->common_model->checkOTP(trim($this->session->userdata('VB_REGISTER_MOBILE')),trim($this->input->post('verifyotp')),'users','user_phone_otp');
				if($userData <> ""):  
					if($userData['status'] == 'I'):
						$param['user_phone_verify']	=	'Y';
						$param['user_phone_otp']	=	'';
						$param['status']			=	'A';
						$this->common_model->editData('vb_users',$param,'user_id',$userData['user_id']);
						
						$this->session->unset_userdata('VB_REGISTER_MOBILE');
						setcookie('VB_USER_LOGIN_TOKEN',$loginParam['user_token'],time()+60*60*24*100,'/');
						$this->session->set_userdata(array(
											'VB_USER_LOGGED_IN'		=>	true,
											'VB_USER_ID'			=>	$userData['user_id'],
											'VB_FULL_NAME'			=>	$userData['full_name'],
											'VB_USER_EMAIL'			=>	$userData['user_email'],
											'VB_USER_MOBILE'		=>	$userData['mobile_number'],
											'VB_USER_TYPE_ID'		=>	$userData['usertype_id'],
											'VB_USER_TYPE_NAME'		=>	$userData['usertype_name'],
											'VB_USER_CURRENT_PATH'	=>	$currentPath));
						echo "success";die;
					elseif($userData['status'] == 'B'):
						echo "blocked";die;
					elseif($userData['status'] == 'A'):
						echo "active";die;
					endif;
				else:
					echo "wrongotp";die;
				endif;
		endif;
		
		$this->layouts->set_title(stripcslashes('OTP Verification | VBloggers'));
		$this->layouts->set_keyword(stripcslashes('OTP Verification | VBloggers'));
		$this->layouts->set_description(stripcslashes('OTP Verification | VBloggers'));
		
		$this->layouts->login_view('user/otpverification',array(),$data);
	}
	/* * *********************************************************************
	 * * Function name : forgotPassword
	 * * Developed By : Tejaswi
	 * * Purpose  : This function use for forgotPassword
	 * * Date : 31 AUGUST 2020
	 * * **********************************************************************/
	public function forgotPassword()
	{
		if($this->session->userdata('VB_USER_ID') <> ''):
			redirect(base_url().'my-profile');
		endif;

		$data['error'] 						= 	'';
		
		if($this->input->post('mobile_number')):
			$mobile_number 	=	trim($this->input->post('mobile_number'));
			$result 		=	$this->common_model->getAllData('vb_users','mobile_number',$mobile_number,'','','single');
			if($result):	
				if($result['status'] != 'A'):	
					echo "blocked";die;
				else:	
					$param['user_password_otp']		=	4321;/*generateRandomString(4,'n');*/
					$this->common_model->editData('vb_users',$param,'user_id',$result['user_id']);
					$this->session->set_userdata('VB_FORGOT_USER_PHONE',$result['mobile_number']);
					echo "success";die;
				endif;
			else:
				echo "noaccount";die;
			endif;
		endif;
		
		$this->layouts->set_title(stripcslashes('Forgot Password | VBloggers'));
		$this->layouts->set_keyword(stripcslashes('Forgot Password | VBloggers'));
		$this->layouts->set_description(stripcslashes('Forgot Password | VBloggers'));
		
		$this->layouts->login_view('user/forgotpassword',array(),$data);
	}

	/* * *********************************************************************
	 * * Function name : resetPassword
	 * * Developed By : Tejaswi
	 * * Purpose  : This function use for resetPassword
	 * * Date : 31 AUGUST 2020
	 * * **********************************************************************/
	public function resetPassword()
	{
		if($this->session->userdata('VB_USER_ID') <> ''):
			redirect(base_url().'my-profile');
		endif;
		$data['error'] 						= 	'';
		if($this->input->post('otp')):  
			$userData		=	$this->common_model->checkOTP(trim($this->session->userdata('VB_FORGOT_USER_PHONE')),trim($this->input->post('otp')),'users','user_password_otp');
			if($userData <> ""):  
				if($userData['status'] == 'A'):
					$param['user_phone_otp']		=	'';
					$param['password']				=	$this->common_model->encriptPassword(trim($this->input->post('password')));
					$this->common_model->editData('vb_users',$param,'user_id',$userData['user_id']);
					$this->session->unset_userdata('VB_FORGOT_USER_PHONE');
					echo "success";die;
				else:
					echo "blocked";die;
				endif;
			else:
				echo "wrongotp";die;
			endif;
		endif;
		$this->layouts->set_title(stripcslashes('Reset Password | VBloggers'));
		$this->layouts->set_keyword(stripcslashes('Reset Password | VBloggers'));
		$this->layouts->set_description(stripcslashes('Reset Password | VBloggers'));
		
		$this->layouts->login_view('user/resetpassword',array(),$data);
	}

	/* * *********************************************************************
	 * * Function name : myProfile
	 * * Developed By : Tejaswi
	 * * Purpose  : This function use for myProfile
	 * * Date : 31 AUGUST 2020
	 * * **********************************************************************/
	public function myProfile()
	{
		//echo "<pre>";print_r($this->session->userdata());die;
		if($this->session->userdata('VB_USER_ID') == ''):
			redirect(base_url());
		endif;
		$this->layouts->set_title(stripcslashes('Profile | VBloggers'));
		$this->layouts->set_keyword(stripcslashes('Profile | VBloggers'));
		$this->layouts->set_description(stripcslashes('Profile | VBloggers'));
		
		$this->layouts->login_view('user/profile',array(),$data);
	}

	

	/* * *********************************************************************
	 * * Function name : logout
	 * * Developed By : Tejaswi
	 * * Purpose  : This function use for logout
	 * * Date : 31 AUGUST 2020
	 * * **********************************************************************/
	public function logout()
	{
		$this->session->unset_userdata(array(
											'VB_USER_LOGGED_IN',
											'VB_USER_ID',
											'VB_FULL_NAME',
											'VB_USER_EMAIL',
											'VB_USER_MOBILE',
											'VB_USER_CURRENT_PATH',
											'VB_USER_LAST_LOGIN'));
						
		redirect(base_url());
	}

}
