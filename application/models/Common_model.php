<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Common_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct(); 
		$this->load->database(); 
	}
	
	/***********************************************************************
	** Function name : addData
	** Developed By : Manoj Kumar
	** Purpose  : This function used for add data
	** Date : 18 JULY 2019
	************************************************************************/
	public function addData($tableName='',$param=array())
	{
		$this->db->insert($tableName,$param);
		//echo $this->db->last_query();die;
		return $this->db->insert_id();

	}	// END OF FUNCTION
	
	/* * *********************************************************************
	 * * Function name : editData
	 * * Developed By : Manoj Kumar
	 * * Purpose  : This function used for edit data
	 * * Date : 18 JULY 2019
	 * * **********************************************************************/
	function editData($tableName='',$param='',$fieldName='',$fieldVallue='')
	{ 
		$this->db->where($fieldName,$fieldVallue);
		$this->db->update($tableName,$param);
      	//echo $this->db->last_query();die;
		return true;
	}	// END OF FUNCTION
	
	/***********************************************************************
	** Function name : detele_images
	** Developed By : tejaswi
	** Purpose  : This function used for detele_images
	** Date : 09 AUGUSt 2018
	************************************************************************/
	function delete_images($tableName='',$id='',$name=NULL,$fieldName='',$fieldVallue='')
	{ 
		//print_r($id);die;
		$this->db->where($id,$fieldVallue);
		$this->db->update($tableName,$fieldName);
		//echo $this->db->last_query();die;
		return true;
	}	// END OF FUNCTION

	/***********************************************************************
	** Function name : editDataByMultipleCondition
	** Developed By : Manoj Kumar
	** Purpose  : This function used for edit data by multiple condition
	** Date : 18 JULY 2019
	************************************************************************/
	function editDataByMultipleCondition($tableName='',$param=array(),$whereCondition=array())
	{
		$this->db->where($whereCondition);
		$this->db->update($tableName,$param);
		//echo $this->db->last_query();die;
		return true;
	}	// END OF FUNCTION
	
	/***********************************************************************
	** Function name : deleteData
	** Developed By : Manoj Kumar
	** Purpose  : This function used for delete data
	** Date : 18 JULY 2019
	************************************************************************/
	function deleteData($tableName='',$fieldName='',$fieldVallue='')
	{
		$this->db->delete($tableName,array($fieldName=>$fieldVallue));
		return true;
	}	// END OF FUNCTION
	/***********************************************************************
	** Function name : update_data
	** Developed By : Ravi Kumar
	** Purpose  : This function used for update data
	** Date : 03 APRIL 2018
	************************************************************************/
	function update_data($tblname='',$params=array(),$id='')
	{ //print_r($params); echo "<hr>"; print_r($email); echo "<hr>"; print_r($table); die;
		$this->db->where('id',$id);
		$this->db->update($tblname,$params);
		return true;
	}
	/***********************************************************************
	** Function name : deleteParticularData
	** Developed By : Manoj Kumar
	** Purpose  : This function used for delete particular data
	** Date : 18 JULY 2019
	************************************************************************/
	function deleteParticularData($tableName='',$fieldName='',$fieldValue='')
	{
		$this->db->delete($tableName,array($fieldName=>$fieldValue));
		return true;
	}	// END OF FUNCTION
	
	/***********************************************************************
	** Function name : deleteByMultipleCondition
	** Developed By : Manoj Kumar
	** Purpose  : This function used for delete by multiple condition
	** Date : 18 JULY 2019
	************************************************************************/
	function deleteByMultipleCondition($tableName='',$whereCondition=array())
	{
		$this->db->delete($tableName,$whereCondition);
		return true;
	}	// END OF FUNCTION
	
	/***********************************************************************
	** Function name: getDataByParticularField
	** Developed By: Manoj Kumar
	** Purpose: This function used for get data by encryptId
	** Date : 18 JULY 2019
	************************************************************************/
	public function getDataByParticularField($tableName='',$fieldName='',$fieldValue='')
	{  
		$this->db->select('*');
		$this->db->from($tableName);	
		$this->db->where($fieldName,$fieldValue);
		$query = $this->db->get();
		//echo $this->db->last_query();die;
		if($query->num_rows() > 0):
			return $query->row_array();
		else:
			return false;
		endif;
	}	// END OF FUNCTION

	/***********************************************************************
	** Function name: getAllData
	** Developed By: Manoj Kumar
	** Purpose: This function used for get All Data
	** Date : 18 JULY 2019
	************************************************************************/
	public function getAllData($tableName='',$fieldName='',$fieldValue='',$likename='',$likevalue='',$action='')
	{  
		$this->db->select('*');
		$this->db->from($tableName);	
		$this->db->where($fieldName,$fieldValue);
		if($likevalue <> ""):
		$this->db->like($likename,$likevalue);
		endif;
		$query = $this->db->get();
		//echo $this->db->last_query();die;
		if($action == 'count'):	
			return $query->num_rows();
		elseif($action == 'single'):	
			if($query->num_rows() > 0):
				return $query->row_array();
			else:
				return false;
			endif;
		elseif($action == 'multiple'):	
			if($query->num_rows() > 0):
				return $query->result_array();
			else:
				return false;
			endif;
		else:
			return false;
		endif;
	}	// END OF FUNCTION

	/***********************************************************************
	** Function name: getDataByQuery
	** Developed By: Manoj Kumar
	** Purpose: This function used for get data by query
	** Date : 18 JULY 2019
	************************************************************************/
	public function getDataByQuery($action='',$query='',$from='')
	{  
		//echo $query;die;
		$query = $this->db->query($query);

		if($from == 'procedure'):
			mysqli_next_result( $this->db->conn_id);
		endif;
		if($action == 'count'):	
			return $query->num_rows();
		elseif($action == 'single'):	
			if($query->num_rows() > 0):
				return $query->row_array();
			else:
				return false;
			endif;
		elseif($action == 'multiple'):	
			if($query->num_rows() > 0):
				return $query->result_array();
			else:
				return false;
			endif;
		else:
			return false;
		endif;
	}	// END OF FUNCTION
	
	/***********************************************************************
	** Function name: getFieldInArray
	** Developed By: Manoj Kumar
	** Purpose: This function used for get data by condition
	** Date : 09 AUGUSt 2018
	************************************************************************/
	public function getFieldInArray($field='',$query='')
	{  
		$returnarray			=	array();
		$query = $this->db->query($query);
		if($query->num_rows() > 0):
			$data	=	$query->result_array();
			foreach($data as $info):
				array_push($returnarray,trim($info[$field]));
			endforeach;
		endif;
		return $returnarray;
	}	// END OF FUNCTION

	/***********************************************************************
	** Function name: getTwoFieldsInArray
	** Developed By: Manoj Kumar
	** Purpose: This function used for get Two Fields In Array
	** Date : 22 OCTOBER 2018
	************************************************************************/
	public function getTwoFieldsInArray($firstField='',$secondField='',$query='')
	{  
		$returnarray			=	array();
		$query = $this->db->query($query);
		if($query->num_rows() > 0):
			$data	=	$query->result_array();
			foreach($data as $info):
				array_push($returnarray,array($firstField=>trim($info[$firstField]),$secondField=>trim($info[$secondField])));
			endforeach;
		endif;
		return $returnarray;
	}	// END OF FUNCTION
	
	/***********************************************************************
	** Function name: getParticularDataByFields
	** Developed By: Manoj Kumar
	** Purpose: This function used for get particular data by fields
	** Date : 18 JULY 2019
	************************************************************************/
	public function getParticularDataByFields($selectField='',$tableName='',$fieldName='',$fieldValue='')
	{  
		$this->db->select($selectField);
		$this->db->from($tableName);	
		$this->db->where($fieldName,ucfirst(strtolower($fieldValue)));
		$this->db->or_where($fieldName,strtolower($fieldValue));
		$query = $this->db->get();
		if($query->num_rows() > 0):
			return $query->row_array();
		else:
			return false;
		endif;
	}	// END OF FUNCTION

	/***********************************************************************
	** Function name: getLastOrderByFields
	** Developed By: Manoj Kumar
	** Purpose: This function used for get Last Order By Fields
	** Date : 18 JULY 2019
	************************************************************************/
	public function getLastOrderByFields($selectField='',$tableName='',$fieldName='',$fieldValue='')
	{  
		$this->db->select($selectField);
		$this->db->from($tableName);	
		if($fieldName && $fieldValue):
			$this->db->where($fieldName,$fieldValue);
		endif;
		$this->db->order_by($selectField.' DESC');
		$this->db->limit(1);
		$query = $this->db->get();
		if($query->num_rows() > 0):
			$data 	=	$query->row_array();
			return $data[$selectField];
		else:
			return 0;
		endif;
	}	// END OF FUNCTION

	/* * *********************************************************************
	 * * Function name : setAttributeInUse
	 * * Developed By : Manoj Kumar
	 * * Purpose  : This function used for set Attribute In Use
	 * * Date : 18 JULY 2019
	 * * **********************************************************************/
	function setAttributeInUse($tableName='',$param='',$fieldName='',$fieldValue='')
	{ 
		$paramarray[$param]	=	'Y';
		$this->db->where($fieldName,$fieldValue);
		$this->db->update($tableName,$paramarray);
		return true;
	}	// END OF FUNCTION

	/***********************************************************************
	** Function name : checkslugexist
	** Developed By : Ravi Kumar
	** Purpose  : This function checkslugexist
	** Date : 20 AUGUST 2019
	************************************************************************/
	public function checkslugexist($table='',$field_name='',$field_value='')
	{
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($field_name,$field_value);
		$this->db->where("status = 'A'");
		$query = $this->db->get();
        if($query->num_rows() > 0):
           $data = $query->row_array();
           	return $data;

		endif;
	}	// END OF FUNCTION

	/***********************************************************************
	** Function name : get_device_id
	** Developed By : Ravi Kumar
	** Purpose  : This function get_device_id
	** Date : 20 AUGUST 2019
	************************************************************************/
	public function get_device_id($table='',$field_name='',$field_value='')
	{
		$this->db->select('device_id');
		$this->db->from($table);
		$this->db->where($field_name,$field_value);
		$this->db->where("status = 'A'");
		$query = $this->db->get();
        if($query->num_rows() > 0):
           $data = $query->row_array();
           	return $data['device_id'];

		endif;
	}	// END OF FUNCTION

	/***********************************************************************
	** Function name : getuserData
	** Developed By : Ravi Kumar
	** Purpose  : This function getuserData
	** Date : 20 AUGUST 2019
	************************************************************************/
	public function getuserData($userId='')
	{
		$this->db->select('user_name,user_phone,user_image,user_email');
		$this->db->from('users');
		$this->db->where('user_id',$userId);
		$this->db->where("status = 'A'");
		$query = $this->db->get();
        if($query->num_rows() > 0):
           $data = $query->row_array();
           	return $data;
		endif;
	}	// END OF FUNCTION

	/***********************************************************************
	** Function name : getViewsCountData
	** Developed By : Ravi Kumar
	** Purpose  : This function getViewsCountData
	** Date : 20 AUGUST 2019
	************************************************************************/
	public function getViewsCountData($type='',$brandId='')
	{
		$this->db->select('vehicle_brand_id');
		$this->db->from('wems_vehicle_views');
		$this->db->where($type,$brandId);
		$query = $this->db->get();
        if($query->num_rows() > 0):
           	$data = $query->row_array();
           	$count =  count($data);
           	return $count;
		endif;
	}	// END OF FUNCTION

	/* * *********************************************************************
	 * * Function name : encriptPassword
	 * * Developed By : Manoj Kumar
	 * * Purpose  : This function used for encript_password
	 * * Date : 19 JULY 2019
	 * * **********************************************************************/
	public function encriptPassword($password)
	{
		return $this->encrypt->encode($password, $this->config->item('encryption_key'));
	}	// END OF FUNCTION
	
	/* * *********************************************************************
	 * * Function name : decryptsPassword
	 * * Developed By : Manoj Kumar
	 * * Purpose  : This function used for encript_password
	 * * Date : 19 JULY 2019
	 * * **********************************************************************/
	public function decryptsPassword($password)
	{
		return $this->encrypt->decode($password, $this->config->item('encryption_key'));
	}	// END OF FUNCTION

	/* * *********************************************************************
	 * * Function name : checkOTP
	 * * Developed By : Manoj Kumar
	 * * Purpose  : This function used for Admin otp
	 * * Date : 19 JULY 2019
	 * * **********************************************************************/
	public function checkOTP($mobile='',$userOtp='',$tableName='',$fieldValue='')
	{
		$this->db->select('*');
		$this->db->from($tableName);
		$this->db->where('mobile_number',$mobile);
		$this->db->where($fieldValue,$userOtp);
		$query	=	$this->db->get();
		if($query->num_rows() >0):
			return $query->row_array();
		else:
			return false;
		endif;
	}	// END OF FUNCTION

	
}	