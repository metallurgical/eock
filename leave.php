<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Leave extends CI_Controller {
	
    function __construct()
    {
		parent::__construct();
		date_default_timezone_set('Asia/Kuala_Lumpur');
		$this->load->library('pdf');
		//$this->output->enable_profiler(TRUE);
		if($this->session->userdata('id_users') == ''){
			redirect('users/login');
		}
	
	}

	function index()
	{	
		//call session
		$data['id_users']=$this->session->userdata('id_users');
		$data['user_type']=$this->session->userdata('user_type');
		
		if($data['user_type']=='staff')
		{
			//get users details staff
			$table 					= 'users';
			$tableNameToJoin 		= array('staff');
			$tableRelation 			= array('users.id_users = staff.id_users');
			$where 			   		= array('users.id_users' => $data['id_users']); 
			$data['rsProfile'] 		= $this->m_query->get_specified_row($table, $where, $tableNameToJoin , $tableRelation);
			
		}
		else
		{
			redirect('users/login', 'refresh');
		}
		
		//get tahun semasa
		$table_year= date("Y");
		
		//get bulan semasa 
		$bulan= date("m");
		
		//get leave staff
		$table 					= 'leave_staff';
		$where 			   		= array('id_users' => $data['id_users'],'leave_code' =>'AL','table_year' => $table_year); 
		$data['get_leave_staff'] = $this->m_query->get_specified_row($table, $where);
		
		if($data['get_leave_staff']== True)
		{
		
			//get total hari telah bekerja
			$date2=$data['rsProfile']['date_start_work'];
			$date1 = date("Y-m-d");
			$datetime1 = new DateTime($date1);
			$datetime2 = new DateTime($date2);
			$interval = date_diff($datetime1, $datetime2);
			$days = $interval->format('%a');
			
			//kira berapa hari dapat cuti AL jika bekerja kurang dari 365
			//$dapat_hari=substr($date2,5,2);
			$hasil_bulan=$interval->format('%m months');
			$hasil_hari=$hasil_bulan + 1;
			
			/*if($data['get_leave_staff']['jumlah_bulan'] < 13)
			{
				//auto update leave staff
				$table     			= "leave_staff";
				$arrayData 			= array(
									'earn_value'		=> $hasil_hari,
									'balance'			=> $hasil_hari + $data['get_leave_staff']['bf_value'] - $data['get_leave_staff']['taken_value'],
									'jumlah_bulan'		=> $hasil_hari
									);
				$where				= array('id_users'	=> $data['id_users'],'leave_code' =>'AL','table_year' => $table_year); 
				$update_leave_staff		= $this->m_query->update_data($arrayData,$table,$where);
			}*/
			
			if($bulan==04)
			{
				$table     			= "leave_staff";
				$arrayData 			= array(
									'bf_value'			=> 0.00,
									'balance'			=> $data['get_leave_staff']['earn_value']-$data['get_leave_staff']['taken_value']
									);
				$where				= array('id_users'	=> $data['id_users'],'leave_code' =>'AL','table_year' => $table_year);  
				$update_leave_staff		= $this->m_query->update_data($arrayData,$table,$where);
			}
			
			if($data['rsProfile']['gender'] == 'Male')
			{
				//get leave staff
				$table 					= 'leave_staff';
				$tableNameToJoin 		= array('leave_name_male');
				$tableRelation 			= array('leave_staff.leave_code = leave_name_male.leave_code');
				$where 			   		= array('leave_staff.id_users' => $data['id_users'],'leave_staff.table_year' => $table_year);
				$order_by 			   	= array('leave_staff.leave_code','asc');
				$data['leave_staff'] 	= $this->m_query->get_all_rows($table, $where, $tableNameToJoin, $tableRelation, $order_by);
				
				$this->load->view('staff/v_apply_leave_male',$data);
			}
			else if($data['rsProfile']['gender'] == 'Female')
			{
				//get leave staff
				$table 					= 'leave_staff';
				$tableNameToJoin 		= array('leave_name_female');
				$tableRelation 			= array('leave_staff.leave_code = leave_name_female.leave_code');
				$where 			   		= array('leave_staff.id_users' => $data['id_users'],'leave_staff.table_year' => $table_year);
				$order_by 			   	= array('leave_staff.leave_code','asc');
				$data['leave_staff'] 	= $this->m_query->get_all_rows($table, $where, $tableNameToJoin, $tableRelation, $order_by);
				
				$this->load->view('staff/v_apply_leave_female',$data);
			}
		}
		else
		{
			
			$this->load->view('staff/v_add_leave_staff',$data);
		}
	}
			
	
	function add_leave_staff()
	{
		//call session
		$data['id_users']=$this->session->userdata('id_users');
		$data['user_type']=$this->session->userdata('user_type');
		
		//get leave staff
		$table 					= 'leave_staff';
		$where 			   		= array('id_users' => $data['id_users'],'leave_code' =>'AL'); 
		$order_by 			   	= array('table_year','desc');
		$data['get_leave_staff'] = $this->m_query->get_specified_row($table, $where,$tableNameToJoin=False, $tableRelation=False, $order_by);
		
		//tahun semasa
		$table_year= date("Y");
		
		//get bulan semasa 
		$bulan= date("m");
		
		//get staff
		$table 					= 'staff';
		$where 			   		= array('id_users' => $data['id_users']); 
		$data['get_staff'] = $this->m_query->get_specified_row($table, $where);
		
		//get users details staff
		$table 					= 'users';
		$tableNameToJoin 		= array('staff');
		$tableRelation 			= array('users.id_users = staff.id_users');
		$where 			   		= array('users.id_users' => $data['id_users']); 
		$data['rsProfile'] 		= $this->m_query->get_specified_row($table, $where, $tableNameToJoin , $tableRelation);
			
		//get total hari telah bekerja
		$date2=$data['rsProfile']['date_start_work'];
		$date1 = date("Y-m-d");
		$datetime1 = new DateTime($date1);
		$datetime2 = new DateTime($date2);
		$interval = date_diff($datetime1, $datetime2);
		$days = $interval->format('%a');
		
		if($days  > 12)
		{
			
				if($data['get_staff']['gender'] == 'Male')
				{
				
					//get leave name
					$table 					= 'leave_name_male';
					$leave_name_male 			= $this->m_query->get_all_rows($table);

					//insert staff leave
					foreach($leave_name_male as $key => $value)
					{
				
						
							if($value['leave_code']=='AL')
							{
								if($data['get_leave_staff']['balance']>6.00)
								{
									$table     		= "leave_staff";
									$arrayData 		= array(
														'id_users'			=> $data['id_users'],
														'leave_code'		=> $value['leave_code'],
														'bf_value'			=> 6.00,
														'earn_value'		=> 14.00,
														'balance'			=> 20.00,
														'table_year'		=> $table_year,
														'jumlah_bulan'		=> 13
														);
									$this->m_query->insert_data($arrayData,$table);
								}
								else
								{
									$table     		= "leave_staff";
									$arrayData 		= array(
														'id_users'			=> $data['id_users'],
														'leave_code'		=> $value['leave_code'],
														'bf_value'			=> $data['get_leave_staff']['balance'],
														'earn_value'		=> 14.00,
														'balance'			=> 14.00 + $data['get_leave_staff']['balance'],
														'table_year'		=> $table_year,
														'jumlah_bulan'		=> 13
														);
									$this->m_query->insert_data($arrayData,$table);
								}
							}
							else if($value['leave_code']=='CL')
							{
								$table     		= "leave_staff";
								$arrayData 		= array(
													'id_users'			=> $data['id_users'],
													'leave_code'		=> $value['leave_code'],
													'earn_value'		=> 2.00,
													'balance'			=> 2.00,
													'table_year'		=> $table_year,
													'jumlah_bulan'		=> 13
													);
								$this->m_query->insert_data($arrayData,$table);
							}
							else if($value['leave_code']=='EL')
							{
								$table     		= "leave_staff";
								$arrayData 		= array(
													'id_users'			=> $data['id_users'],
													'leave_code'		=> $value['leave_code'],
													'table_year'		=> $table_year,
													'jumlah_bulan'		=> 13
													);
								$this->m_query->insert_data($arrayData,$table);
							}
							else if($value['leave_code']=='PT')
							{
								$table     		= "leave_staff";
								$arrayData 		= array(
													'id_users'			=> $data['id_users'],
													'leave_code'		=> $value['leave_code'],
													'earn_value'		=> 1.00,
													'balance'			=> 1.00,
													'table_year'		=> $table_year,
													'jumlah_bulan'		=> 13
													);
								$this->m_query->insert_data($arrayData,$table);
							}
							else if($value['leave_code']=='SL')
							{
								$table     		= "leave_staff";
								$arrayData 		= array(
													'id_users'			=> $data['id_users'],
													'leave_code'		=> $value['leave_code'],
													'earn_value'		=> 14.00,
													'balance'			=> 14.00,
													'table_year'		=> $table_year,
													'jumlah_bulan'		=> 13
													);
								$this->m_query->insert_data($arrayData,$table);
							}
							else if($value['leave_code']=='RL')
							{
								$table     		= "leave_staff";
								$arrayData 		= array(
													'id_users'			=> $data['id_users'],
													'leave_code'		=> $value['leave_code'],
													'table_year'		=> $table_year,
													'jumlah_bulan'		=> 13
													);
								$this->m_query->insert_data($arrayData,$table);
							}
							else if($value['leave_code']=='UP')
							{
								$table     		= "leave_staff";
								$arrayData 		= array(
													'id_users'			=> $data['id_users'],
													'leave_code'		=> $value['leave_code'],
													'table_year'		=> $table_year,
													'jumlah_bulan'		=> 13
													);
								$this->m_query->insert_data($arrayData,$table);
							}
						
					}
				}
				else if($data['get_staff']['gender'] == 'Female')
				{
				
					//get leave name
					$table 					= 'leave_name_female';
					$leave_name_female 			= $this->m_query->get_all_rows($table);

					//insert staff leave
					foreach($leave_name_female as $key => $value)
					{
				
						
							if($value['leave_code']=='AL')
							{
								if($data['get_leave_staff']['balance']>6.00)
								{
									$table     		= "leave_staff";
									$arrayData 		= array(
														'id_users'			=> $data['id_users'],
														'leave_code'		=> $value['leave_code'],
														'bf_value'			=> 6.00,
														'earn_value'		=> 14.00,
														'balance'			=> 20.00,
														'table_year'		=> $table_year,
														'jumlah_bulan'		=> 13
														);
									$this->m_query->insert_data($arrayData,$table);
								}
								else
								{
									$table     		= "leave_staff";
									$arrayData 		= array(
														'id_users'			=> $data['id_users'],
														'leave_code'		=> $value['leave_code'],
														'bf_value'			=> $data['get_leave_staff']['balance'],
														'earn_value'		=> 14.00,
														'balance'			=> 14.00 + $data['get_leave_staff']['balance'],
														'table_year'		=> $table_year,
														'jumlah_bulan'		=> 13
														);
									$this->m_query->insert_data($arrayData,$table);
								}
							}
							else if($value['leave_code']=='CL')
							{
								$table     		= "leave_staff";
								$arrayData 		= array(
													'id_users'			=> $data['id_users'],
													'leave_code'		=> $value['leave_code'],
													'earn_value'		=> 2.00,
													'balance'			=> 2.00,
													'table_year'		=> $table_year,
													'jumlah_bulan'		=> 13
													);
								$this->m_query->insert_data($arrayData,$table);
							}
							else if($value['leave_code']=='EL')
							{
								$table     		= "leave_staff";
								$arrayData 		= array(
													'id_users'			=> $data['id_users'],
													'leave_code'		=> $value['leave_code'],
													'table_year'		=> $table_year,
													'jumlah_bulan'		=> 13
													);
								$this->m_query->insert_data($arrayData,$table);
							}
							else if($value['leave_code']=='MT')
							{
								$table     		= "leave_staff";
								$arrayData 		= array(
													'id_users'			=> $data['id_users'],
													'leave_code'		=> $value['leave_code'],
													'earn_value'		=> 60.00,
													'balance'			=> 60.00,
													'table_year'		=> $table_year,
													'jumlah_bulan'		=> 13
													);
								$this->m_query->insert_data($arrayData,$table);
							}
							else if($value['leave_code']=='SL')
							{
								$table     		= "leave_staff";
								$arrayData 		= array(
													'id_users'			=> $data['id_users'],
													'leave_code'		=> $value['leave_code'],
													'earn_value'		=> 14.00,
													'balance'			=> 14.00,
													'table_year'		=> $table_year,
													'jumlah_bulan'		=> 13
													);
								$this->m_query->insert_data($arrayData,$table);
							}
							else if($value['leave_code']=='RL')
							{
								$table     		= "leave_staff";
								$arrayData 		= array(
													'id_users'			=> $data['id_users'],
													'leave_code'		=> $value['leave_code'],
													'table_year'		=> $table_year,
													'jumlah_bulan'		=> 13
													);
								$this->m_query->insert_data($arrayData,$table);
							}
							else if($value['leave_code']=='UP')
							{
								$table     		= "leave_staff";
								$arrayData 		= array(
													'id_users'			=> $data['id_users'],
													'leave_code'		=> $value['leave_code'],
													'table_year'		=> $table_year,
													'jumlah_bulan'		=> 13
													);
								$this->m_query->insert_data($arrayData,$table);
							}
						
					}
				}
		}
		else
		{
			
				if($data['get_staff']['gender'] == 'Male')
				{
				
					//get leave name
					$table 					= 'leave_name_male';
					$leave_name_male 			= $this->m_query->get_all_rows($table);

					//insert staff leave
					foreach($leave_name_male as $key => $value)
					{
				
						
							if($value['leave_code']=='AL')
							{
								if($data['get_leave_staff']['balance']>6.00)
								{
									$table     		= "leave_staff";
									$arrayData 		= array(
														'id_users'			=> $data['id_users'],
														'leave_code'		=> $value['leave_code'],
														'bf_value'			=> 6.00,
														'earn_value'		=> 12.00,
														'balance'			=> 18.00,
														'table_year'		=> $table_year,
														'jumlah_bulan'		=> 13
														);
									$this->m_query->insert_data($arrayData,$table);
								}
								else
								{
									$table     		= "leave_staff";
									$arrayData 		= array(
														'id_users'			=> $data['id_users'],
														'leave_code'		=> $value['leave_code'],
														'bf_value'			=> $data['get_leave_staff']['balance'],
														'earn_value'		=> 12.00,
														'balance'			=> 12.00 + $data['get_leave_staff']['balance'],
														'table_year'		=> $table_year,
														'jumlah_bulan'		=> 13
														);
									$this->m_query->insert_data($arrayData,$table);
								}
							}
							else if($value['leave_code']=='CL')
							{
								$table     		= "leave_staff";
								$arrayData 		= array(
													'id_users'			=> $data['id_users'],
													'leave_code'		=> $value['leave_code'],
													'earn_value'		=> 2.00,
													'balance'			=> 2.00,
													'table_year'		=> $table_year,
													'jumlah_bulan'		=> 13
													);
								$this->m_query->insert_data($arrayData,$table);
							}
							else if($value['leave_code']=='EL')
							{
								$table     		= "leave_staff";
								$arrayData 		= array(
													'id_users'			=> $data['id_users'],
													'leave_code'		=> $value['leave_code'],
													'table_year'		=> $table_year,
													'jumlah_bulan'		=> 13
													);
								$this->m_query->insert_data($arrayData,$table);
							}
							else if($value['leave_code']=='PT')
							{
								$table     		= "leave_staff";
								$arrayData 		= array(
													'id_users'			=> $data['id_users'],
													'leave_code'		=> $value['leave_code'],
													'earn_value'		=> 1.00,
													'balance'			=> 1.00,
													'table_year'		=> $table_year,
													'jumlah_bulan'		=> 13
													);
								$this->m_query->insert_data($arrayData,$table);
							}
							else if($value['leave_code']=='SL')
							{
								$table     		= "leave_staff";
								$arrayData 		= array(
													'id_users'			=> $data['id_users'],
													'leave_code'		=> $value['leave_code'],
													'earn_value'		=> 14.00,
													'balance'			=> 14.00,
													'table_year'		=> $table_year,
													'jumlah_bulan'		=> 13
													);
								$this->m_query->insert_data($arrayData,$table);
							}
							else if($value['leave_code']=='RL')
							{
								$table     		= "leave_staff";
								$arrayData 		= array(
													'id_users'			=> $data['id_users'],
													'leave_code'		=> $value['leave_code'],
													'table_year'		=> $table_year,
													'jumlah_bulan'		=> 13
													);
								$this->m_query->insert_data($arrayData,$table);
							}
							else if($value['leave_code']=='UP')
							{
								$table     		= "leave_staff";
								$arrayData 		= array(
													'id_users'			=> $data['id_users'],
													'leave_code'		=> $value['leave_code'],
													'table_year'		=> $table_year,
													'jumlah_bulan'		=> 13
													);
								$this->m_query->insert_data($arrayData,$table);
							}
						
					}
				}
				else if($data['get_staff']['gender'] == 'Female')
				{
				
					//get leave name
					$table 					= 'leave_name_female';
					$leave_name_female 			= $this->m_query->get_all_rows($table);

					//insert staff leave
					foreach($leave_name_female as $key => $value)
					{
				
						
							if($value['leave_code']=='AL')
							{
								if($data['get_leave_staff']['balance']>6.00)
								{
									$table     		= "leave_staff";
									$arrayData 		= array(
														'id_users'			=> $data['id_users'],
														'leave_code'		=> $value['leave_code'],
														'bf_value'			=> 6.00,
														'earn_value'		=> 12.00,
														'balance'			=> 18.00,
														'table_year'		=> $table_year,
														'jumlah_bulan'		=> 13
														);
									$this->m_query->insert_data($arrayData,$table);
								}
								else
								{
									$table     		= "leave_staff";
									$arrayData 		= array(
														'id_users'			=> $data['id_users'],
														'leave_code'		=> $value['leave_code'],
														'bf_value'			=> $data['get_leave_staff']['balance'],
														'earn_value'		=> 12.00,
														'balance'			=> 12.00 + $data['get_leave_staff']['balance'],
														'table_year'		=> $table_year,
														'jumlah_bulan'		=> 13
														);
									$this->m_query->insert_data($arrayData,$table);
								}
							}
							else if($value['leave_code']=='CL')
							{
								$table     		= "leave_staff";
								$arrayData 		= array(
													'id_users'			=> $data['id_users'],
													'leave_code'		=> $value['leave_code'],
													'earn_value'		=> 2.00,
													'balance'			=> 2.00,
													'table_year'		=> $table_year,
													'jumlah_bulan'		=> 13
													);
								$this->m_query->insert_data($arrayData,$table);
							}
							else if($value['leave_code']=='EL')
							{
								$table     		= "leave_staff";
								$arrayData 		= array(
													'id_users'			=> $data['id_users'],
													'leave_code'		=> $value['leave_code'],
													'table_year'		=> $table_year,
													'jumlah_bulan'		=> 13
													);
								$this->m_query->insert_data($arrayData,$table);
							}
							else if($value['leave_code']=='MT')
							{
								$table     		= "leave_staff";
								$arrayData 		= array(
													'id_users'			=> $data['id_users'],
													'leave_code'		=> $value['leave_code'],
													'earn_value'		=> 60.00,
													'balance'			=> 60.00,
													'table_year'		=> $table_year,
													'jumlah_bulan'		=> 13
													);
								$this->m_query->insert_data($arrayData,$table);
							}
							else if($value['leave_code']=='SL')
							{
								$table     		= "leave_staff";
								$arrayData 		= array(
													'id_users'			=> $data['id_users'],
													'leave_code'		=> $value['leave_code'],
													'earn_value'		=> 14.00,
													'balance'			=> 14.00,
													'table_year'		=> $table_year,
													'jumlah_bulan'		=> 13
													);
								$this->m_query->insert_data($arrayData,$table);
							}
							else if($value['leave_code']=='RL')
							{
								$table     		= "leave_staff";
								$arrayData 		= array(
													'id_users'			=> $data['id_users'],
													'leave_code'		=> $value['leave_code'],
													'table_year'		=> $table_year,
													'jumlah_bulan'		=> 13
													);
								$this->m_query->insert_data($arrayData,$table);
							}
							else if($value['leave_code']=='UP')
							{
								$table     		= "leave_staff";
								$arrayData 		= array(
													'id_users'			=> $data['id_users'],
													'leave_code'		=> $value['leave_code'],
													'table_year'		=> $table_year,
													'jumlah_bulan'		=> 13
													);
								$this->m_query->insert_data($arrayData,$table);
							}
						
					}
				}
		}
		//$this->session->set_flashdata('success', 'The information leave table succesfully save');
		redirect('staff/leave');
	}
	
	function new_leave()
	{
		//call session
		$data['id_users']=$this->session->userdata('id_users');
		$data['user_type']=$this->session->userdata('user_type');
		
		//get users details staff
		$table 					= 'users';
		$tableNameToJoin 		= array('staff');
		$tableRelation 			= array('users.id_users = staff.id_users');
		$where 			   		= array('users.id_users' => $data['id_users']); 
		$data['rsProfile'] 		= $this->m_query->get_specified_row($table, $where, $tableNameToJoin , $tableRelation);
							
		//tahun register
		$table_year= date("Y");
		
		$inputData = $this->input->post();	
		
		//jika apply leave AL
		if($inputData['leave_code']=='AL')
		{
		
			//kira adakah hari nak cuti 4 hari sebelum apply
			$date2=$inputData['date_from'];
			$date1 = date("Y-m-d");
			$datetime1 = new DateTime($date1);
			$datetime2 = new DateTime($date2);
			$interval = date_diff($datetime1, $datetime2);
			$days = $interval->format('%a');
			
			//get leave staff
			$table 					= 'leave_staff';
			$where 			   		= array('leave_staff.id_users' => $data['id_users'],'leave_staff.leave_code' => 'AL','leave_staff.table_year' =>$table_year); 
			$data['leave_staff'] 	= $this->m_query->get_specified_row($table, $where);
			
			if($data['leave_staff']['pending'] ==0.00)
			{
			
				if($days >=4 )
				{
					
					
					if($data['leave_staff']['balance']  >= $inputData['no_of_days'])
					{
					
						if(empty($inputData['time_type']))
						{
							//insert apply leave AL
							$table     		= "apply_leave";
							$arrayData 		= array(
												'id_users'			=> $data['id_users'],
												'leave_type'		=> $inputData['leave_type'],
												'no_of_days'		=> $inputData['no_of_days'],
												'date_from'			=> $inputData['date_from'],
												'date_to'			=> $inputData['date_to'],
												'leave_code'		=> $inputData['leave_code'],
												'state_reason'		=> $inputData['state_reason'],
												
												
												);
							$new_id 		=$this->m_query->insert_data($arrayData,$table);
							
							//update table leave staff
							$data['id_users']=$this->session->userdata('id_users');
							$inputData = $this->input->post();	
							
							$table     			= "leave_staff";
							$arrayData 		= array(
												'pending'			=> $inputData['no_of_days']
												
												);
							$where				= array('id_users'	=> $data['id_users'],'leave_code' =>'AL','table_year' =>$table_year); 
							$update_leave_staff		= $this->m_query->update_data($arrayData,$table,$where);
							
							//upload attachment
							if($new_id)
							{
								#Upload Photo
								$config['upload_path'] = 'assets/leave/';
								$config['allowed_types'] = 'gif|jpg|png|jpeg|jpe|pdf|doc|docx|rtf|text|txt';
								$newFileName = $_FILES['userfile']['name'];
								$fileExt = array_pop(explode(".", $newFileName));
								$config['file_name'] = $new_id.'.'.$fileExt;
								
								$table     			= "apply_leave";
								$arrayData 			= array(
								'file'			=> $new_id.'.'.$fileExt
								);
								$where				= array('id_apply_leave'	=> $new_id);

								$update_gallery 		= $this->m_query->update_data($arrayData,$table,$where);
											
							
								$this->load->library('upload', $config);
								$this->upload->do_upload();
							
							}
							
							//send email///
							
							if($inputData['leave_code']=='AL')
							{
								$inputData['leave_code'] = 'Annual Leave';
							}
							else if($inputData['leave_code']=='CL')
							{
								$inputData['leave_code'] = 'Compassionate Leave';
							}
							else if($inputData['leave_code']=='EL')
							{
								$inputData['leave_code'] = 'Emergency Leave';
							}
							else if($inputData['leave_code']=='PT')
							{
								$inputData['leave_code'] = 'Paternity Leave';
							}
							else if($inputData['leave_code']=='SL')
							{
								$inputData['leave_code'] = 'Sick Leave';
							}
							else if($inputData['leave_code']=='RL')
							{
								$inputData['leave_code'] = 'Replacement Leave';
							}
							else if($inputData['leave_code']=='UP')
							{
								$inputData['leave_code'] = 'Unpaid Leave';
							}
							else if($inputData['leave_code']=='MT')
							{
								$inputData['leave_code'] = 'Maternity Leave';
							}
							//get admin
							$table 					= 'admin';
							$staff			        = $this->m_query->get_all_rows($table);
							
							//pecahkan date
							$orderdate = explode('-', $inputData['date_from']);
							$date_dari=$orderdate[2].'-'.$orderdate[1].'-'.$orderdate[0];
							
							$orderdate2 = explode('-', $inputData['date_to']);
							$date_ke=$orderdate2[2].'-'.$orderdate2[1].'-'.$orderdate2[0];
							//tutup pecahkan date
							
							foreach($staff as $key => $value){
							
						
								//message
								$message = "Dear Sir / Madam,\n\n";
								$message .= "Application leave by ".$data['rsProfile']['fullname']."(".$data['rsProfile']['staff_no'].")\n\n";
								$message .= $inputData['leave_code']. " : ".$inputData['no_of_days']." days\n";
								$message .= "Start Date : ".$date_dari."\n";
								$message .= "End Date : ".$date_ke."\n\n";
								$message .= "Kindly please check Leave Management System for details.\n\n";
								$message .= "Thank You";
								
								$this->load->helper('email');
								$this->load->library('email');
								
								$config['protocol']     ='tls';
								$config['smtp_host']    ='ssl://smtp.googlemail.com';
								$config['smtp_port']    ='465';
								$config['smtp_timeout'] ='30';
								$config['smtp_user']    ='leaveapplication00@gmail.com';
								$config['smtp_pass']    ='passworD';
								$config['charset']      ='utf-8';
								$config['newline']      ="\r\n";
								$config['wordwrap']     = TRUE;
								$config['mailtype']     = 'text';
								$this->email->initialize($config);
								$this->email->from('leaveapplication00@gmail.com');
								$this->email->to($value['email']); 
								$this->email->subject('e-Leave Application');
								$this->email->message($message);  
								$this->email->send();
			
								
							}
							//tutup send email///
							
						$this->session->set_flashdata('success', 'The information leave is succesfully save');
						redirect('staff/leave');
								
						}
						else 
						{
							
							//insert apply leave AL
							$table     		= "apply_leave";
							$arrayData 		= array(
												'id_users'			=> $data['id_users'],
												'leave_type'		=> $inputData['leave_type'],
												'time_type'			=> $inputData['time_type'],
												'no_of_days'		=> $inputData['no_of_days'],
												'date_from'			=> $inputData['date_from'],
												'date_to'			=> $inputData['date_to'],
												'leave_code'		=> $inputData['leave_code'],
												'state_reason'		=> $inputData['state_reason'],
												
												
												);
							$new_id 		=$this->m_query->insert_data($arrayData,$table);
							
							//update table leave staff
							$data['id_users']=$this->session->userdata('id_users');
							$inputData = $this->input->post();	
							
							$table     			= "leave_staff";
							$arrayData 		= array(
												'pending'			=> $inputData['no_of_days']
												
												);
							$where				= array('id_users'	=> $data['id_users'],'leave_code' =>'AL','table_year' =>$table_year); 
							$update_leave_staff = $this->m_query->update_data($arrayData,$table,$where);
							
							//upload attachment
							if($new_id)
							{
								#Upload Photo
								$config['upload_path'] = 'assets/leave/';
								$config['allowed_types'] = 'gif|jpg|png|jpeg|jpe|pdf|doc|docx|rtf|text|txt';
								$newFileName = $_FILES['userfile']['name'];
								$fileExt = array_pop(explode(".", $newFileName));
								$config['file_name'] = $new_id.'.'.$fileExt;
								
								$table     			= "apply_leave";
								$arrayData 			= array(
								'file'			=> $new_id.'.'.$fileExt
								);
								$where				= array('id_apply_leave'	=> $new_id);

								$update_gallery 		= $this->m_query->update_data($arrayData,$table,$where);
											
							
								$this->load->library('upload', $config);
								$this->upload->do_upload();
							}
							
							//send email///
							
							if($inputData['leave_code']=='AL')
							{
								$inputData['leave_code'] = 'Annual Leave';
							}
							else if($inputData['leave_code']=='CL')
							{
								$inputData['leave_code'] = 'Compassionate Leave';
							}
							else if($inputData['leave_code']=='EL')
							{
								$inputData['leave_code'] = 'Emergency Leave';
							}
							else if($inputData['leave_code']=='PT')
							{
								$inputData['leave_code'] = 'Paternity Leave';
							}
							else if($inputData['leave_code']=='SL')
							{
								$inputData['leave_code'] = 'Sick Leave';
							}
							else if($inputData['leave_code']=='RL')
							{
								$inputData['leave_code'] = 'Replacement Leave';
							}
							else if($inputData['leave_code']=='UP')
							{
								$inputData['leave_code'] = 'Unpaid Leave';
							}
							else if($inputData['leave_code']=='MT')
							{
								$inputData['leave_code'] = 'Maternity Leave';
							}
							//get admin
							$table 					= 'admin';
							$staff			        = $this->m_query->get_all_rows($table);
							
							//pecahkan date
							$orderdate = explode('-', $inputData['date_from']);
							$date_dari=$orderdate[2].'-'.$orderdate[1].'-'.$orderdate[0];
							
							$orderdate2 = explode('-', $inputData['date_to']);
							$date_ke=$orderdate2[2].'-'.$orderdate2[1].'-'.$orderdate2[0];
							//tutup pecahkan date
							
							foreach($staff as $key => $value){
							
						
								//message
								$message = "Dear Sir / Madam,\n\n";
								$message .= "Application leave by ".$data['rsProfile']['fullname']."(".$data['rsProfile']['staff_no'].")\n\n";
								$message .= $inputData['leave_code']. " : ".$inputData['no_of_days']." days\n";
								$message .= "Start Date : ".$date_dari."\n";
								$message .= "End Date : ".$date_ke."\n\n";
								$message .= "Kindly please check Leave Management System for details.\n\n";
								$message .= "Thank You";
								
								$this->load->helper('email');
								$this->load->library('email');
								
								$config['protocol']     ='tls';
								$config['smtp_host']    ='ssl://smtp.googlemail.com';
								$config['smtp_port']    ='465';
								$config['smtp_timeout'] ='30';
								$config['smtp_user']    ='leaveapplication00@gmail.com';
								$config['smtp_pass']    ='passworD';
								$config['charset']      ='utf-8';
								$config['newline']      ="\r\n";
								$config['wordwrap']     = TRUE;
								$config['mailtype']     = 'text';
								$this->email->initialize($config);
								$this->email->from('leaveapplication00@gmail.com');
								$this->email->to($value['email']); 
								$this->email->subject('e-Leave Application');
								$this->email->message($message);  
								$this->email->send();
			
								
							}
							//tutup send email///
							
							$this->session->set_flashdata('success', 'The information leave is succesfully save');
							redirect('staff/leave');
						}
					}
					else
					{
						$this->session->set_flashdata('error', 'The total leave is not available.');
						redirect('staff/leave');
					}
					
					
				}
				else
				{
					$this->session->set_flashdata('error', 'The application must be apply more than 4 days from the date taken.');
					redirect('staff/leave');
				}
			}
			else
			{
				$this->session->set_flashdata('error', 'The application is not available. Please contact administrator for any inquires.');
				redirect('staff/leave');
			}
		}
		////////////////////////////////////////////////////////////////////////////////////////////////tamat AL
		
		//jika apply leave CL
		else if($inputData['leave_code']=='CL')
		{
		
			//get leave staff
			$table 					= 'leave_staff';
			$where 			   		= array('leave_staff.id_users' => $data['id_users'],'leave_staff.leave_code' => 'CL','leave_staff.table_year' =>$table_year); 
			$data['leave_staff'] 	= $this->m_query->get_specified_row($table, $where);
			
			if($data['leave_staff']['pending'] ==0.00)
			{
				if($data['leave_staff']['balance']  >= $inputData['no_of_days'])
				{
			
					if(!empty($_FILES['userfile']['name']))
					{
					
						if(empty($inputData['time_type']))
						{
							//insert apply leave CL
							$table     		= "apply_leave";
							$arrayData 		= array(
												'id_users'			=> $data['id_users'],
												'leave_type'		=> $inputData['leave_type'],
												'no_of_days'		=> $inputData['no_of_days'],
												'date_from'			=> $inputData['date_from'],
												'date_to'			=> $inputData['date_to'],
												'leave_code'		=> $inputData['leave_code'],
												'state_reason'		=> $inputData['state_reason'],
												
												
												);
							$new_id 		=$this->m_query->insert_data($arrayData,$table);
							
							//update table leave staff
							$data['id_users']=$this->session->userdata('id_users');
							$inputData = $this->input->post();	
							
							$table     			= "leave_staff";
							$arrayData 		= array(
												'pending'			=> $inputData['no_of_days']
												
												);
							$where				= array('id_users'	=> $data['id_users'],'leave_code' =>'CL','table_year' =>$table_year); 
							$update_leave_staff		= $this->m_query->update_data($arrayData,$table,$where);
							
							//upload attachment
								if($new_id)
								{
									#Upload Photo
									$config['upload_path'] = 'assets/leave/';
									$config['allowed_types'] = 'gif|jpg|png|jpeg|jpe|pdf|doc|docx|rtf|text|txt';
									$newFileName = $_FILES['userfile']['name'];
									$fileExt = array_pop(explode(".", $newFileName));
									$config['file_name'] = $new_id.'.'.$fileExt;
									
									$table     			= "apply_leave";
									$arrayData 			= array(
									'file'			=> $new_id.'.'.$fileExt
									);
									$where				= array('id_apply_leave'	=> $new_id);

									$update_gallery 		= $this->m_query->update_data($arrayData,$table,$where);
												
								
									$this->load->library('upload', $config);
									$this->upload->do_upload();
								}
								
							//send email///
							
							if($inputData['leave_code']=='AL')
							{
								$inputData['leave_code'] = 'Annual Leave';
							}
							else if($inputData['leave_code']=='CL')
							{
								$inputData['leave_code'] = 'Compassionate Leave';
							}
							else if($inputData['leave_code']=='EL')
							{
								$inputData['leave_code'] = 'Emergency Leave';
							}
							else if($inputData['leave_code']=='PT')
							{
								$inputData['leave_code'] = 'Paternity Leave';
							}
							else if($inputData['leave_code']=='SL')
							{
								$inputData['leave_code'] = 'Sick Leave';
							}
							else if($inputData['leave_code']=='RL')
							{
								$inputData['leave_code'] = 'Replacement Leave';
							}
							else if($inputData['leave_code']=='UP')
							{
								$inputData['leave_code'] = 'Unpaid Leave';
							}
							else if($inputData['leave_code']=='MT')
							{
								$inputData['leave_code'] = 'Maternity Leave';
							}
							//get admin
							$table 					= 'admin';
							$staff			        = $this->m_query->get_all_rows($table);
							
							//pecahkan date
							$orderdate = explode('-', $inputData['date_from']);
							$date_dari=$orderdate[2].'-'.$orderdate[1].'-'.$orderdate[0];
							
							$orderdate2 = explode('-', $inputData['date_to']);
							$date_ke=$orderdate2[2].'-'.$orderdate2[1].'-'.$orderdate2[0];
							//tutup pecahkan date
							
							foreach($staff as $key => $value){
							
						
								//message
								$message = "Dear Sir / Madam,\n\n";
								$message .= "Application leave by ".$data['rsProfile']['fullname']."(".$data['rsProfile']['staff_no'].")\n\n";
								$message .= $inputData['leave_code']. " : ".$inputData['no_of_days']." days\n";
								$message .= "Start Date : ".$date_dari."\n";
								$message .= "End Date : ".$date_ke."\n\n";
								$message .= "Kindly please check Leave Management System for details.\n\n";
								$message .= "Thank You";
								
								$this->load->helper('email');
								$this->load->library('email');
								
								$config['protocol']     ='tls';
								$config['smtp_host']    ='ssl://smtp.googlemail.com';
								$config['smtp_port']    ='465';
								$config['smtp_timeout'] ='30';
								$config['smtp_user']    ='leaveapplication00@gmail.com';
								$config['smtp_pass']    ='passworD';
								$config['charset']      ='utf-8';
								$config['newline']      ="\r\n";
								$config['wordwrap']     = TRUE;
								$config['mailtype']     = 'text';
								$this->email->initialize($config);
								$this->email->from('leaveapplication00@gmail.com');
								$this->email->to($value['email']); 
								$this->email->subject('e-Leave Application');
								$this->email->message($message);  
								$this->email->send();
			
								
							}
							//tutup send email///
							
							$this->session->set_flashdata('success', 'The information leave is succesfully save');
							redirect('staff/leave');
						}
						else 
						{
							//insert apply leave CL
							$table     		= "apply_leave";
							$arrayData 		= array(
												'id_users'			=> $data['id_users'],
												'leave_type'		=> $inputData['leave_type'],
												'time_type'			=> $inputData['time_type'],
												'no_of_days'		=> $inputData['no_of_days'],
												'date_from'			=> $inputData['date_from'],
												'date_to'			=> $inputData['date_to'],
												'leave_code'		=> $inputData['leave_code'],
												'state_reason'		=> $inputData['state_reason'],
												
												
												);
							$new_id 		=$this->m_query->insert_data($arrayData,$table);
							
							//update table leave staff
							$data['id_users']=$this->session->userdata('id_users');
							$inputData = $this->input->post();	
							
							$table     			= "leave_staff";
							$arrayData 		= array(
												'pending'			=> $inputData['no_of_days']
												
												);
							$where				= array('id_users'	=> $data['id_users'],'leave_code' =>'CL','table_year' =>$table_year); 
							$update_leave_staff		= $this->m_query->update_data($arrayData,$table,$where);
									
							//upload attachment
								if($new_id)
								{
									#Upload Photo
									$config['upload_path'] = 'assets/leave/';
									$config['allowed_types'] = 'gif|jpg|png|jpeg|jpe|pdf|doc|docx|rtf|text|txt';
									$newFileName = $_FILES['userfile']['name'];
									$fileExt = array_pop(explode(".", $newFileName));
									$config['file_name'] = $new_id.'.'.$fileExt;
									
									$table     			= "apply_leave";
									$arrayData 			= array(
									'file'			=> $new_id.'.'.$fileExt
									);
									$where				= array('id_apply_leave'	=> $new_id);

									$update_gallery 		= $this->m_query->update_data($arrayData,$table,$where);
												
								
									$this->load->library('upload', $config);
									$this->upload->do_upload();
								}
								
							//send email///
							
							if($inputData['leave_code']=='AL')
							{
								$inputData['leave_code'] = 'Annual Leave';
							}
							else if($inputData['leave_code']=='CL')
							{
								$inputData['leave_code'] = 'Compassionate Leave';
							}
							else if($inputData['leave_code']=='EL')
							{
								$inputData['leave_code'] = 'Emergency Leave';
							}
							else if($inputData['leave_code']=='PT')
							{
								$inputData['leave_code'] = 'Paternity Leave';
							}
							else if($inputData['leave_code']=='SL')
							{
								$inputData['leave_code'] = 'Sick Leave';
							}
							else if($inputData['leave_code']=='RL')
							{
								$inputData['leave_code'] = 'Replacement Leave';
							}
							else if($inputData['leave_code']=='UP')
							{
								$inputData['leave_code'] = 'Unpaid Leave';
							}
							else if($inputData['leave_code']=='MT')
							{
								$inputData['leave_code'] = 'Maternity Leave';
							}
							//get admin
							$table 					= 'admin';
							$staff			        = $this->m_query->get_all_rows($table);
							
							//pecahkan date
							$orderdate = explode('-', $inputData['date_from']);
							$date_dari=$orderdate[2].'-'.$orderdate[1].'-'.$orderdate[0];
							
							$orderdate2 = explode('-', $inputData['date_to']);
							$date_ke=$orderdate2[2].'-'.$orderdate2[1].'-'.$orderdate2[0];
							//tutup pecahkan date
							
							foreach($staff as $key => $value){
							
						
								//message
								$message = "Dear Sir / Madam,\n\n";
								$message .= "Application leave by ".$data['rsProfile']['fullname']."(".$data['rsProfile']['staff_no'].")\n\n";
								$message .= $inputData['leave_code']. " : ".$inputData['no_of_days']." days\n";
								$message .= "Start Date : ".$date_dari."\n";
								$message .= "End Date : ".$date_ke."\n\n";
								$message .= "Kindly please check Leave Management System for details.\n\n";
								$message .= "Thank You";
								
								$this->load->helper('email');
								$this->load->library('email');
								
								$config['protocol']     ='tls';
								$config['smtp_host']    ='ssl://smtp.googlemail.com';
								$config['smtp_port']    ='465';
								$config['smtp_timeout'] ='30';
								$config['smtp_user']    ='leaveapplication00@gmail.com';
								$config['smtp_pass']    ='passworD';
								$config['charset']      ='utf-8';
								$config['newline']      ="\r\n";
								$config['wordwrap']     = TRUE;
								$config['mailtype']     = 'text';
								$this->email->initialize($config);
								$this->email->from('leaveapplication00@gmail.com');
								$this->email->to($value['email']); 
								$this->email->subject('e-Leave Application');
								$this->email->message($message);  
								$this->email->send();
			
								
							}
							//tutup send email///
							
							$this->session->set_flashdata('success', 'The information leave is succesfully save');
							redirect('staff/leave');
						}
					}
					else
					{
						$this->session->set_flashdata('error', 'Please attach the file');
						redirect('staff/leave');
					}
				}
				else
				{
					$this->session->set_flashdata('error', 'The total leave is not available.');
					redirect('staff/leave');
				}
			}
			else
			{
				$this->session->set_flashdata('error', 'The application is not available. Please contact administrator for any inquires.');
				redirect('staff/leave');
			}
		}
		
		//jika apply leave EL
		else if($inputData['leave_code']=='EL')
		{
			
			//kira adakah hari nak cuti 4 hari sebelum apply
			$date2=$inputData['date_from'];
			$date1 = date("Y-m-d");
			$datetime1 = new DateTime($date1);
			$datetime2 = new DateTime($date2);
			$interval = date_diff($datetime1, $datetime2);
			$days = $interval->format('%a');
			
			//get leave staff
			$table 					= 'leave_staff';
			$where 			   		= array('leave_staff.id_users' => $data['id_users'],'leave_staff.leave_code' => 'EL','leave_staff.table_year' =>$table_year); 
			$data['leave_staff'] 	= $this->m_query->get_specified_row($table, $where);
			
			if($data['leave_staff']['pending'] ==0.00)
			{
				//get leave staff AL
				$table 					= 'leave_staff';
				$where 			   		= array('leave_staff.id_users' => $data['id_users'],'leave_staff.leave_code' => 'AL','leave_staff.table_year' =>$table_year); 
				$data['leave_staff_AL'] 	= $this->m_query->get_specified_row($table, $where);
				
				if($data['leave_staff_AL']['balance']  >= $inputData['no_of_days'])
				{
			
					//if($days >=3 )
					//{
						if(!empty($_FILES['userfile']['name']))
						{
							if(empty($inputData['time_type']))
							{
								//insert apply leave EL
								$table     		= "apply_leave";
								$arrayData 		= array(
													'id_users'			=> $data['id_users'],
													'leave_type'		=> $inputData['leave_type'],
													'no_of_days'		=> $inputData['no_of_days'],
													'date_from'			=> $inputData['date_from'],
													'date_to'			=> $inputData['date_to'],
													'leave_code'		=> $inputData['leave_code'],
													'state_reason'		=> $inputData['state_reason'],
													
													
													);
								$new_id 		=$this->m_query->insert_data($arrayData,$table);
								
								//update table leave staff
								$data['id_users']=$this->session->userdata('id_users');
								$inputData = $this->input->post();	
								
								$table     			= "leave_staff";
								$arrayData 		= array(
													'pending'			=> $inputData['no_of_days']
													
													);
								$where				= array('id_users'	=> $data['id_users'],'leave_code' =>'EL','table_year' =>$table_year);
								$update_leave_staff		= $this->m_query->update_data($arrayData,$table,$where);
								
								//upload attachment
								if($new_id)
								{
									#Upload Photo
									$config['upload_path'] = 'assets/leave/';
									$config['allowed_types'] = 'gif|jpg|png|jpeg|jpe|pdf|doc|docx|rtf|text|txt';
									$newFileName = $_FILES['userfile']['name'];
									$fileExt = array_pop(explode(".", $newFileName));
									$config['file_name'] = $new_id.'.'.$fileExt;
									
									$table     			= "apply_leave";
									$arrayData 			= array(
									'file'			=> $new_id.'.'.$fileExt
									);
									$where				= array('id_apply_leave'	=> $new_id);

									$update_gallery 		= $this->m_query->update_data($arrayData,$table,$where);
												
								
									$this->load->library('upload', $config);
									$this->upload->do_upload();
								}
								
								//send email///
							
							if($inputData['leave_code']=='AL')
							{
								$inputData['leave_code'] = 'Annual Leave';
							}
							else if($inputData['leave_code']=='CL')
							{
								$inputData['leave_code'] = 'Compassionate Leave';
							}
							else if($inputData['leave_code']=='EL')
							{
								$inputData['leave_code'] = 'Emergency Leave';
							}
							else if($inputData['leave_code']=='PT')
							{
								$inputData['leave_code'] = 'Paternity Leave';
							}
							else if($inputData['leave_code']=='SL')
							{
								$inputData['leave_code'] = 'Sick Leave';
							}
							else if($inputData['leave_code']=='RL')
							{
								$inputData['leave_code'] = 'Replacement Leave';
							}
							else if($inputData['leave_code']=='UP')
							{
								$inputData['leave_code'] = 'Unpaid Leave';
							}
							else if($inputData['leave_code']=='MT')
							{
								$inputData['leave_code'] = 'Maternity Leave';
							}
							//get admin
							$table 					= 'admin';
							$staff			        = $this->m_query->get_all_rows($table);
							
							//pecahkan date
							$orderdate = explode('-', $inputData['date_from']);
							$date_dari=$orderdate[2].'-'.$orderdate[1].'-'.$orderdate[0];
							
							$orderdate2 = explode('-', $inputData['date_to']);
							$date_ke=$orderdate2[2].'-'.$orderdate2[1].'-'.$orderdate2[0];
							//tutup pecahkan date
							
							foreach($staff as $key => $value){
							
						
								//message
								$message = "Dear Sir / Madam,\n\n";
								$message .= "Application leave by ".$data['rsProfile']['fullname']."(".$data['rsProfile']['staff_no'].")\n\n";
								$message .= $inputData['leave_code']. " : ".$inputData['no_of_days']." days\n";
								$message .= "Start Date : ".$date_dari."\n";
								$message .= "End Date : ".$date_ke."\n\n";
								$message .= "Kindly please check Leave Management System for details.\n\n";
								$message .= "Thank You";
								
								$this->load->helper('email');
								$this->load->library('email');
								
								$config['protocol']     ='tls';
								$config['smtp_host']    ='ssl://smtp.googlemail.com';
								$config['smtp_port']    ='465';
								$config['smtp_timeout'] ='30';
								$config['smtp_user']    ='leaveapplication00@gmail.com';
								$config['smtp_pass']    ='passworD';
								$config['charset']      ='utf-8';
								$config['newline']      ="\r\n";
								$config['wordwrap']     = TRUE;
								$config['mailtype']     = 'text';
								$this->email->initialize($config);
								$this->email->from('leaveapplication00@gmail.com');
								$this->email->to($value['email']); 
								$this->email->subject('e-Leave Application');
								$this->email->message($message);  
								$this->email->send();
			
								
							}
							//tutup send email///
							
								$this->session->set_flashdata('success', 'The information leave is succesfully save');
								redirect('staff/leave');
							}
							else 
							{
								//insert apply leave EL
								$table     		= "apply_leave";
								$arrayData 		= array(
													'id_users'			=> $data['id_users'],
													'leave_type'		=> $inputData['leave_type'],
													'time_type'			=> $inputData['time_type'],
													'no_of_days'		=> $inputData['no_of_days'],
													'date_from'			=> $inputData['date_from'],
													'date_to'			=> $inputData['date_to'],
													'leave_code'		=> $inputData['leave_code'],
													'state_reason'		=> $inputData['state_reason'],
													
													
													);
								$new_id 		=$this->m_query->insert_data($arrayData,$table);
								
								//update table leave staff
								$data['id_users']=$this->session->userdata('id_users');
								$inputData = $this->input->post();	
								
								$table     			= "leave_staff";
								$arrayData 		= array(
													'pending'			=> $inputData['no_of_days']
													
													);
				 
								$where				= array('id_users'	=> $data['id_users'],'leave_code' =>'EL','table_year' =>$table_year);
								$update_leave_staff		= $this->m_query->update_data($arrayData,$table,$where);
								
								//upload attachment
								if($new_id)
								{
									#Upload Photo
									$config['upload_path'] = 'assets/leave/';
									$config['allowed_types'] = 'gif|jpg|png|jpeg|jpe|pdf|doc|docx|rtf|text|txt';
									$newFileName = $_FILES['userfile']['name'];
									$fileExt = array_pop(explode(".", $newFileName));
									$config['file_name'] = $new_id.'.'.$fileExt;
									
									$table     			= "apply_leave";
									$arrayData 			= array(
									'file'			=> $new_id.'.'.$fileExt
									);
									$where				= array('id_apply_leave'	=> $new_id);

									$update_gallery 		= $this->m_query->update_data($arrayData,$table,$where);
												
								
									$this->load->library('upload', $config);
									$this->upload->do_upload();
								}
								
								//send email///
							
							if($inputData['leave_code']=='AL')
							{
								$inputData['leave_code'] = 'Annual Leave';
							}
							else if($inputData['leave_code']=='CL')
							{
								$inputData['leave_code'] = 'Compassionate Leave';
							}
							else if($inputData['leave_code']=='EL')
							{
								$inputData['leave_code'] = 'Emergency Leave';
							}
							else if($inputData['leave_code']=='PT')
							{
								$inputData['leave_code'] = 'Paternity Leave';
							}
							else if($inputData['leave_code']=='SL')
							{
								$inputData['leave_code'] = 'Sick Leave';
							}
							else if($inputData['leave_code']=='RL')
							{
								$inputData['leave_code'] = 'Replacement Leave';
							}
							else if($inputData['leave_code']=='UP')
							{
								$inputData['leave_code'] = 'Unpaid Leave';
							}
							else if($inputData['leave_code']=='MT')
							{
								$inputData['leave_code'] = 'Maternity Leave';
							}
							//get admin
							$table 					= 'admin';
							$staff			        = $this->m_query->get_all_rows($table);
							
							//pecahkan date
							$orderdate = explode('-', $inputData['date_from']);
							$date_dari=$orderdate[2].'-'.$orderdate[1].'-'.$orderdate[0];
							
							$orderdate2 = explode('-', $inputData['date_to']);
							$date_ke=$orderdate2[2].'-'.$orderdate2[1].'-'.$orderdate2[0];
							//tutup pecahkan date
							
							foreach($staff as $key => $value){
							
						
								//message
								$message = "Dear Sir / Madam,\n\n";
								$message .= "Application leave by ".$data['rsProfile']['fullname']."(".$data['rsProfile']['staff_no'].")\n\n";
								$message .= $inputData['leave_code']. " : ".$inputData['no_of_days']." days\n";
								$message .= "Start Date : ".$date_dari."\n";
								$message .= "End Date : ".$date_ke."\n\n";
								$message .= "Kindly please check Leave Management System for details.\n\n";
								$message .= "Thank You";
								
								$this->load->helper('email');
								$this->load->library('email');
								
								$config['protocol']     ='tls';
								$config['smtp_host']    ='ssl://smtp.googlemail.com';
								$config['smtp_port']    ='465';
								$config['smtp_timeout'] ='30';
								$config['smtp_user']    ='leaveapplication00@gmail.com';
								$config['smtp_pass']    ='passworD';
								$config['charset']      ='utf-8';
								$config['newline']      ="\r\n";
								$config['wordwrap']     = TRUE;
								$config['mailtype']     = 'text';
								$this->email->initialize($config);
								$this->email->from('leaveapplication00@gmail.com');
								$this->email->to($value['email']); 
								$this->email->subject('e-Leave Application');
								$this->email->message($message);  
								$this->email->send();
			
								
							}
							//tutup send email///
							
								$this->session->set_flashdata('success', 'The information leave is succesfully save');
								redirect('staff/leave');
							}
						}
						else
						{
							$this->session->set_flashdata('error', 'Please attach the file');
							redirect('staff/leave');
						}
					//}
					//else
					//{
					//	$this->session->set_flashdata('error', 'Sorry, apply leave must more than three days');
					//	redirect('staff/leave');
					//}
				}
				else
				{
					$this->session->set_flashdata('error', 'The total leave is not available.');
					redirect('staff/leave');
				}
			}
			else
			{
				$this->session->set_flashdata('error', 'The application is not available. Please contact administrator for any inquires.');
				redirect('staff/leave');
			}
					
		}
		
		//jika apply leave MT
		else if($inputData['leave_code']=='MT')
		{
		
			//get leave staff
			$table 					= 'leave_staff';
			$where 			   		= array('leave_staff.id_users' => $data['id_users'],'leave_staff.leave_code' => 'MT','leave_staff.table_year' =>$table_year); 
			$data['leave_staff'] 	= $this->m_query->get_specified_row($table, $where);
			
			if($data['leave_staff']['pending'] ==0.00)
			{
			
			
				if($data['leave_staff']['balance']  >= $inputData['no_of_days'])
				{
					if(!empty($_FILES['userfile']['name']))
					{
				
						if(empty($inputData['time_type']))
						{
							//insert apply leave ML
							$table     		= "apply_leave";
							$arrayData 		= array(
												'id_users'			=> $data['id_users'],
												'leave_type'		=> $inputData['leave_type'],
												'no_of_days'		=> $inputData['no_of_days'],
												'date_from'			=> $inputData['date_from'],
												'date_to'			=> $inputData['date_to'],
												'leave_code'		=> $inputData['leave_code'],
												'state_reason'		=> $inputData['state_reason'],
												
												
												);
							$new_id 		=$this->m_query->insert_data($arrayData,$table);
							
							//update table leave staff
							$data['id_users']=$this->session->userdata('id_users');
							$inputData = $this->input->post();	
							
							$table     			= "leave_staff";
							$arrayData 		= array(
												'pending'			=> $inputData['no_of_days']
												
												);
							$where				= array('id_users'	=> $data['id_users'],'leave_code' =>'MT','table_year' =>$table_year);
							$update_leave_staff		= $this->m_query->update_data($arrayData,$table,$where);
							
							//upload attachment
							if($new_id)
							{
								#Upload Photo
								$config['upload_path'] = 'assets/leave/';
								$config['allowed_types'] = 'gif|jpg|png|jpeg|jpe|pdf|doc|docx|rtf|text|txt';
								$newFileName = $_FILES['userfile']['name'];
								$fileExt = array_pop(explode(".", $newFileName));
								$config['file_name'] = $new_id.'.'.$fileExt;
								
								$table     			= "apply_leave";
								$arrayData 			= array(
								'file'			=> $new_id.'.'.$fileExt
								);
								$where				= array('id_apply_leave'	=> $new_id);

								$update_gallery 		= $this->m_query->update_data($arrayData,$table,$where);
											
							
								$this->load->library('upload', $config);
								$this->upload->do_upload();
							}
							
							//send email///
							
							if($inputData['leave_code']=='AL')
							{
								$inputData['leave_code'] = 'Annual Leave';
							}
							else if($inputData['leave_code']=='CL')
							{
								$inputData['leave_code'] = 'Compassionate Leave';
							}
							else if($inputData['leave_code']=='EL')
							{
								$inputData['leave_code'] = 'Emergency Leave';
							}
							else if($inputData['leave_code']=='PT')
							{
								$inputData['leave_code'] = 'Paternity Leave';
							}
							else if($inputData['leave_code']=='SL')
							{
								$inputData['leave_code'] = 'Sick Leave';
							}
							else if($inputData['leave_code']=='RL')
							{
								$inputData['leave_code'] = 'Replacement Leave';
							}
							else if($inputData['leave_code']=='UP')
							{
								$inputData['leave_code'] = 'Unpaid Leave';
							}
							else if($inputData['leave_code']=='MT')
							{
								$inputData['leave_code'] = 'Maternity Leave';
							}
							//get admin
							$table 					= 'admin';
							$staff			        = $this->m_query->get_all_rows($table);
							
							//pecahkan date
							$orderdate = explode('-', $inputData['date_from']);
							$date_dari=$orderdate[2].'-'.$orderdate[1].'-'.$orderdate[0];
							
							$orderdate2 = explode('-', $inputData['date_to']);
							$date_ke=$orderdate2[2].'-'.$orderdate2[1].'-'.$orderdate2[0];
							//tutup pecahkan date
							
							foreach($staff as $key => $value){
							
						
								//message
								$message = "Dear Sir / Madam,\n\n";
								$message .= "Application leave by ".$data['rsProfile']['fullname']."(".$data['rsProfile']['staff_no'].")\n\n";
								$message .= $inputData['leave_code']. " : ".$inputData['no_of_days']." days\n";
								$message .= "Start Date : ".$date_dari."\n";
								$message .= "End Date : ".$date_ke."\n\n";
								$message .= "Kindly please check Leave Management System for details.\n\n";
								$message .= "Thank You";
								
								$this->load->helper('email');
								$this->load->library('email');
								
								$config['protocol']     ='tls';
								$config['smtp_host']    ='ssl://smtp.googlemail.com';
								$config['smtp_port']    ='465';
								$config['smtp_timeout'] ='30';
								$config['smtp_user']    ='leaveapplication00@gmail.com';
								$config['smtp_pass']    ='passworD';
								$config['charset']      ='utf-8';
								$config['newline']      ="\r\n";
								$config['wordwrap']     = TRUE;
								$config['mailtype']     = 'text';
								$this->email->initialize($config);
								$this->email->from('leaveapplication00@gmail.com');
								$this->email->to($value['email']); 
								$this->email->subject('e-Leave Application');
								$this->email->message($message);  
								$this->email->send();
			
								
							}
							//tutup send email///
							
							$this->session->set_flashdata('success', 'The information leave is succesfully save');
							redirect('staff/leave');
						}
						else 
						{
							//insert apply leave MT
							$table     		= "apply_leave";
							$arrayData 		= array(
												'id_users'			=> $data['id_users'],
												'leave_type'		=> $inputData['leave_type'],
												'time_type'			=> $inputData['time_type'],
												'no_of_days'		=> $inputData['no_of_days'],
												'date_from'			=> $inputData['date_from'],
												'date_to'			=> $inputData['date_to'],
												'leave_code'		=> $inputData['leave_code'],
												'state_reason'		=> $inputData['state_reason'],
												
												
												);
							$new_id 		=$this->m_query->insert_data($arrayData,$table);
							
							//update table leave staff
							$data['id_users']=$this->session->userdata('id_users');
							$inputData = $this->input->post();	
							
							$table     			= "leave_staff";
							$arrayData 		= array(
												'pending'			=> $inputData['no_of_days']
												
												);
							$where				= array('id_users'	=> $data['id_users'],'leave_code' =>'MT','table_year' =>$table_year); 
							$update_leave_staff		= $this->m_query->update_data($arrayData,$table,$where);
							//upload attachment
							if($new_id)
							{
								#Upload Photo
								$config['upload_path'] = 'assets/leave/';
								$config['allowed_types'] = 'gif|jpg|png|jpeg|jpe|pdf|doc|docx|rtf|text|txt';
								$newFileName = $_FILES['userfile']['name'];
								$fileExt = array_pop(explode(".", $newFileName));
								$config['file_name'] = $new_id.'.'.$fileExt;
								
								$table     			= "apply_leave";
								$arrayData 			= array(
								'file'			=> $new_id.'.'.$fileExt
								);
								$where				= array('id_apply_leave'	=> $new_id);

								$update_gallery 		= $this->m_query->update_data($arrayData,$table,$where);
											
							
								$this->load->library('upload', $config);
								$this->upload->do_upload();
							}
							
							//send email///
							
							if($inputData['leave_code']=='AL')
							{
								$inputData['leave_code'] = 'Annual Leave';
							}
							else if($inputData['leave_code']=='CL')
							{
								$inputData['leave_code'] = 'Compassionate Leave';
							}
							else if($inputData['leave_code']=='EL')
							{
								$inputData['leave_code'] = 'Emergency Leave';
							}
							else if($inputData['leave_code']=='PT')
							{
								$inputData['leave_code'] = 'Paternity Leave';
							}
							else if($inputData['leave_code']=='SL')
							{
								$inputData['leave_code'] = 'Sick Leave';
							}
							else if($inputData['leave_code']=='RL')
							{
								$inputData['leave_code'] = 'Replacement Leave';
							}
							else if($inputData['leave_code']=='UP')
							{
								$inputData['leave_code'] = 'Unpaid Leave';
							}
							else if($inputData['leave_code']=='MT')
							{
								$inputData['leave_code'] = 'Maternity Leave';
							}
							//get admin
							$table 					= 'admin';
							$staff			        = $this->m_query->get_all_rows($table);
							
							//pecahkan date
							$orderdate = explode('-', $inputData['date_from']);
							$date_dari=$orderdate[2].'-'.$orderdate[1].'-'.$orderdate[0];
							
							$orderdate2 = explode('-', $inputData['date_to']);
							$date_ke=$orderdate2[2].'-'.$orderdate2[1].'-'.$orderdate2[0];
							//tutup pecahkan date
							
							foreach($staff as $key => $value){
							
						
								//message
								$message = "Dear Sir / Madam,\n\n";
								$message .= "Application leave by ".$data['rsProfile']['fullname']."(".$data['rsProfile']['staff_no'].")\n\n";
								$message .= $inputData['leave_code']. " : ".$inputData['no_of_days']." days\n";
								$message .= "Start Date : ".$date_dari."\n";
								$message .= "End Date : ".$date_ke."\n\n";
								$message .= "Kindly please check Leave Management System for details.\n\n";
								$message .= "Thank You";
								
								$this->load->helper('email');
								$this->load->library('email');
								
								$config['protocol']     ='tls';
								$config['smtp_host']    ='ssl://smtp.googlemail.com';
								$config['smtp_port']    ='465';
								$config['smtp_timeout'] ='30';
								$config['smtp_user']    ='leaveapplication00@gmail.com';
								$config['smtp_pass']    ='passworD';
								$config['charset']      ='utf-8';
								$config['newline']      ="\r\n";
								$config['wordwrap']     = TRUE;
								$config['mailtype']     = 'text';
								$this->email->initialize($config);
								$this->email->from('leaveapplication00@gmail.com');
								$this->email->to($value['email']); 
								$this->email->subject('e-Leave Application');
								$this->email->message($message);  
								$this->email->send();
			
								
							}
							//tutup send email///
								
							$this->session->set_flashdata('success', 'The information leave is succesfully save');
							redirect('staff/leave');
						}
					}
					else
					{
						$this->session->set_flashdata('error', 'Please attach the file');
						redirect('staff/leave');
					}
				}
				else
				{
					$this->session->set_flashdata('error', 'The total leave is not available.');
					redirect('staff/leave');
				}
			}
			else
			{
				$this->session->set_flashdata('error', 'The application is not available. Please contact administrator for any inquires.');
				redirect('staff/leave');
			}
				
		}
		
		//jika apply leave PT
		else if($inputData['leave_code']=='PT')
		{
		
			//get leave staff
			$table 					= 'leave_staff';
			$where 			   		= array('leave_staff.id_users' => $data['id_users'],'leave_staff.leave_code' => 'PT','leave_staff.table_year' =>$table_year); 
			$data['leave_staff'] 	= $this->m_query->get_specified_row($table, $where);
			
			if($data['leave_staff']['pending'] ==0.00)
			{
			
			
				if($data['leave_staff']['balance']  >= $inputData['no_of_days'])
				{
					if(!empty($_FILES['userfile']['name']))
					{
				
						if(empty($inputData['time_type']))
						{
							//insert apply leave PT
							$table     		= "apply_leave";
							$arrayData 		= array(
												'id_users'			=> $data['id_users'],
												'leave_type'		=> $inputData['leave_type'],
												'no_of_days'		=> $inputData['no_of_days'],
												'date_from'			=> $inputData['date_from'],
												'date_to'			=> $inputData['date_to'],
												'leave_code'		=> $inputData['leave_code'],
												'state_reason'		=> $inputData['state_reason'],
												
												
												);
							$new_id 		=$this->m_query->insert_data($arrayData,$table);
							
							//update table leave staff
							$data['id_users']=$this->session->userdata('id_users');
							$inputData = $this->input->post();	
							
							$table     			= "leave_staff";
							$arrayData 		= array(
												'pending'			=> $inputData['no_of_days']
												
												);
							$where				= array('id_users'	=> $data['id_users'],'leave_code' =>'PT','table_year' =>$table_year);
							$update_leave_staff		= $this->m_query->update_data($arrayData,$table,$where);
							
							//upload attachment
							if($new_id)
							{
								#Upload Photo
								$config['upload_path'] = 'assets/leave/';
								$config['allowed_types'] = 'gif|jpg|png|jpeg|jpe|pdf|doc|docx|rtf|text|txt';
								$newFileName = $_FILES['userfile']['name'];
								$fileExt = array_pop(explode(".", $newFileName));
								$config['file_name'] = $new_id.'.'.$fileExt;
								
								$table     			= "apply_leave";
								$arrayData 			= array(
								'file'			=> $new_id.'.'.$fileExt
								);
								$where				= array('id_apply_leave'	=> $new_id);

								$update_gallery 		= $this->m_query->update_data($arrayData,$table,$where);
											
							
								$this->load->library('upload', $config);
								$this->upload->do_upload();
							}
							
							//send email///
							
							if($inputData['leave_code']=='AL')
							{
								$inputData['leave_code'] = 'Annual Leave';
							}
							else if($inputData['leave_code']=='CL')
							{
								$inputData['leave_code'] = 'Compassionate Leave';
							}
							else if($inputData['leave_code']=='EL')
							{
								$inputData['leave_code'] = 'Emergency Leave';
							}
							else if($inputData['leave_code']=='PT')
							{
								$inputData['leave_code'] = 'Paternity Leave';
							}
							else if($inputData['leave_code']=='SL')
							{
								$inputData['leave_code'] = 'Sick Leave';
							}
							else if($inputData['leave_code']=='RL')
							{
								$inputData['leave_code'] = 'Replacement Leave';
							}
							else if($inputData['leave_code']=='UP')
							{
								$inputData['leave_code'] = 'Unpaid Leave';
							}
							else if($inputData['leave_code']=='MT')
							{
								$inputData['leave_code'] = 'Maternity Leave';
							}
							//get admin
							$table 					= 'admin';
							$staff			        = $this->m_query->get_all_rows($table);
							
							//pecahkan date
							$orderdate = explode('-', $inputData['date_from']);
							$date_dari=$orderdate[2].'-'.$orderdate[1].'-'.$orderdate[0];
							
							$orderdate2 = explode('-', $inputData['date_to']);
							$date_ke=$orderdate2[2].'-'.$orderdate2[1].'-'.$orderdate2[0];
							//tutup pecahkan date
							
							foreach($staff as $key => $value){
							
						
								//message
								$message = "Dear Sir / Madam,\n\n";
								$message .= "Application leave by ".$data['rsProfile']['fullname']."(".$data['rsProfile']['staff_no'].")\n\n";
								$message .= $inputData['leave_code']. " : ".$inputData['no_of_days']." days\n";
								$message .= "Start Date : ".$date_dari."\n";
								$message .= "End Date : ".$date_ke."\n\n";
								$message .= "Kindly please check Leave Management System for details.\n\n";
								$message .= "Thank You";
								
								$this->load->helper('email');
								$this->load->library('email');
								
								$config['protocol']     ='tls';
								$config['smtp_host']    ='ssl://smtp.googlemail.com';
								$config['smtp_port']    ='465';
								$config['smtp_timeout'] ='30';
								$config['smtp_user']    ='leaveapplication00@gmail.com';
								$config['smtp_pass']    ='passworD';
								$config['charset']      ='utf-8';
								$config['newline']      ="\r\n";
								$config['wordwrap']     = TRUE;
								$config['mailtype']     = 'text';
								$this->email->initialize($config);
								$this->email->from('leaveapplication00@gmail.com');
								$this->email->to($value['email']); 
								$this->email->subject('e-Leave Application');
								$this->email->message($message);  
								$this->email->send();
			
								
							}
							//tutup send email///
							
							$this->session->set_flashdata('success', 'The information leave is succesfully save');
							redirect('staff/leave');
						}
						else 
						{
							//insert apply leave PT
							$table     		= "apply_leave";
							$arrayData 		= array(
												'id_users'			=> $data['id_users'],
												'leave_type'		=> $inputData['leave_type'],
												'time_type'			=> $inputData['time_type'],
												'no_of_days'		=> $inputData['no_of_days'],
												'date_from'			=> $inputData['date_from'],
												'date_to'			=> $inputData['date_to'],
												'leave_code'		=> $inputData['leave_code'],
												'state_reason'		=> $inputData['state_reason'],
												
												
												);
							$new_id 		=$this->m_query->insert_data($arrayData,$table);
							
							//update table leave staff
							$data['id_users']=$this->session->userdata('id_users');
							$inputData = $this->input->post();	
							
							$table     			= "leave_staff";
							$arrayData 		= array(
												'pending'			=> $inputData['no_of_days']
												
												);
							$where				= array('id_users'	=> $data['id_users'],'leave_code' =>'PT','table_year' =>$table_year); 
							$update_leave_staff		= $this->m_query->update_data($arrayData,$table,$where);
							//upload attachment
							if($new_id)
							{
								#Upload Photo
								$config['upload_path'] = 'assets/leave/';
								$config['allowed_types'] = 'gif|jpg|png|jpeg|jpe|pdf|doc|docx|rtf|text|txt';
								$newFileName = $_FILES['userfile']['name'];
								$fileExt = array_pop(explode(".", $newFileName));
								$config['file_name'] = $new_id.'.'.$fileExt;
								
								$table     			= "apply_leave";
								$arrayData 			= array(
								'file'			=> $new_id.'.'.$fileExt
								);
								$where				= array('id_apply_leave'	=> $new_id);

								$update_gallery 		= $this->m_query->update_data($arrayData,$table,$where);
											
							
								$this->load->library('upload', $config);
								$this->upload->do_upload();
							}
							
							//send email///
							
							if($inputData['leave_code']=='AL')
							{
								$inputData['leave_code'] = 'Annual Leave';
							}
							else if($inputData['leave_code']=='CL')
							{
								$inputData['leave_code'] = 'Compassionate Leave';
							}
							else if($inputData['leave_code']=='EL')
							{
								$inputData['leave_code'] = 'Emergency Leave';
							}
							else if($inputData['leave_code']=='PT')
							{
								$inputData['leave_code'] = 'Paternity Leave';
							}
							else if($inputData['leave_code']=='SL')
							{
								$inputData['leave_code'] = 'Sick Leave';
							}
							else if($inputData['leave_code']=='RL')
							{
								$inputData['leave_code'] = 'Replacement Leave';
							}
							else if($inputData['leave_code']=='UP')
							{
								$inputData['leave_code'] = 'Unpaid Leave';
							}
							else if($inputData['leave_code']=='MT')
							{
								$inputData['leave_code'] = 'Maternity Leave';
							}
							//get admin
							$table 					= 'admin';
							$staff			        = $this->m_query->get_all_rows($table);
							
							//pecahkan date
							$orderdate = explode('-', $inputData['date_from']);
							$date_dari=$orderdate[2].'-'.$orderdate[1].'-'.$orderdate[0];
							
							$orderdate2 = explode('-', $inputData['date_to']);
							$date_ke=$orderdate2[2].'-'.$orderdate2[1].'-'.$orderdate2[0];
							//tutup pecahkan date
							
							foreach($staff as $key => $value){
							
						
								//message
								$message = "Dear Sir / Madam,\n\n";
								$message .= "Application leave by ".$data['rsProfile']['fullname']."(".$data['rsProfile']['staff_no'].")\n\n";
								$message .= $inputData['leave_code']. " : ".$inputData['no_of_days']." days\n";
								$message .= "Start Date : ".$date_dari."\n";
								$message .= "End Date : ".$date_ke."\n\n";
								$message .= "Kindly please check Leave Management System for details.\n\n";
								$message .= "Thank You";
								
								$this->load->helper('email');
								$this->load->library('email');
								
								$config['protocol']     ='tls';
								$config['smtp_host']    ='ssl://smtp.googlemail.com';
								$config['smtp_port']    ='465';
								$config['smtp_timeout'] ='30';
								$config['smtp_user']    ='leaveapplication00@gmail.com';
								$config['smtp_pass']    ='passworD';
								$config['charset']      ='utf-8';
								$config['newline']      ="\r\n";
								$config['wordwrap']     = TRUE;
								$config['mailtype']     = 'text';
								$this->email->initialize($config);
								$this->email->from('leaveapplication00@gmail.com');
								$this->email->to($value['email']); 
								$this->email->subject('e-Leave Application');
								$this->email->message($message);  
								$this->email->send();
			
								
							}
							//tutup send email///
							
							$this->session->set_flashdata('success', 'The information leave is succesfully save');
							redirect('staff/leave');
						}
					}
					else
					{
						$this->session->set_flashdata('error', 'Please attach the file');
						redirect('staff/leave');
					}
				}
				else
				{
					$this->session->set_flashdata('error', 'The total leave is not available.');
					redirect('staff/leave');
				}
			}
			else
			{
				$this->session->set_flashdata('error', 'The application is not available. Please contact administrator for any inquires.');
				redirect('staff/leave');
			}
				
		}
		
		//jika apply leave SL
		else if($inputData['leave_code']=='SL')
		{
			
			//get leave staff
			$table 					= 'leave_staff';
			$where 			   		= array('leave_staff.id_users' => $data['id_users'],'leave_staff.leave_code' => 'SL','leave_staff.table_year' =>$table_year); 
			$data['leave_staff'] 	= $this->m_query->get_specified_row($table, $where);
			
			if($data['leave_staff']['pending'] ==0.00)
			{
			
			
				if($data['leave_staff']['balance']  >= $inputData['no_of_days'])
				{
					
					if(!empty($_FILES['userfile']['name']))
					{
					
						if(empty($inputData['time_type']))
						{
							//insert apply leave SL
							$table     		= "apply_leave";
							$arrayData 		= array(
												'id_users'			=> $data['id_users'],
												'leave_type'		=> $inputData['leave_type'],
												'no_of_days'		=> $inputData['no_of_days'],
												'date_from'			=> $inputData['date_from'],
												'date_to'			=> $inputData['date_to'],
												'leave_code'		=> $inputData['leave_code'],
												'state_reason'		=> $inputData['state_reason'],
												
												
												);
							$new_id 		=$this->m_query->insert_data($arrayData,$table);
							
							//update table leave staff
							$data['id_users']=$this->session->userdata('id_users');
							$inputData = $this->input->post();	
							
							$table     			= "leave_staff";
							$arrayData 		= array(
												'pending'			=> $inputData['no_of_days']
												
												);
							$where				= array('id_users'	=> $data['id_users'],'leave_code' =>'SL','table_year' =>$table_year);
							$update_leave_staff		= $this->m_query->update_data($arrayData,$table,$where);
							
							//upload attachment
							if($new_id)
							{
								#Upload Photo
								$config['upload_path'] = 'assets/leave/';
								$config['allowed_types'] = 'gif|jpg|png|jpeg|jpe|pdf|doc|docx|rtf|text|txt';
								$newFileName = $_FILES['userfile']['name'];
								$fileExt = array_pop(explode(".", $newFileName));
								$config['file_name'] = $new_id.'.'.$fileExt;
								
								$table     			= "apply_leave";
								$arrayData 			= array(
								'file'			=> $new_id.'.'.$fileExt
								);
								$where				= array('id_apply_leave'	=> $new_id);

								$update_gallery 		= $this->m_query->update_data($arrayData,$table,$where);
											
							
								$this->load->library('upload', $config);
								$this->upload->do_upload();
							}
							
							//send email///
							
							if($inputData['leave_code']=='AL')
							{
								$inputData['leave_code'] = 'Annual Leave';
							}
							else if($inputData['leave_code']=='CL')
							{
								$inputData['leave_code'] = 'Compassionate Leave';
							}
							else if($inputData['leave_code']=='EL')
							{
								$inputData['leave_code'] = 'Emergency Leave';
							}
							else if($inputData['leave_code']=='PT')
							{
								$inputData['leave_code'] = 'Paternity Leave';
							}
							else if($inputData['leave_code']=='SL')
							{
								$inputData['leave_code'] = 'Sick Leave';
							}
							else if($inputData['leave_code']=='RL')
							{
								$inputData['leave_code'] = 'Replacement Leave';
							}
							else if($inputData['leave_code']=='UP')
							{
								$inputData['leave_code'] = 'Unpaid Leave';
							}
							else if($inputData['leave_code']=='MT')
							{
								$inputData['leave_code'] = 'Maternity Leave';
							}
							//get admin
							$table 					= 'admin';
							$staff			        = $this->m_query->get_all_rows($table);
							
							//pecahkan date
							$orderdate = explode('-', $inputData['date_from']);
							$date_dari=$orderdate[2].'-'.$orderdate[1].'-'.$orderdate[0];
							
							$orderdate2 = explode('-', $inputData['date_to']);
							$date_ke=$orderdate2[2].'-'.$orderdate2[1].'-'.$orderdate2[0];
							//tutup pecahkan date
							
							foreach($staff as $key => $value){
							
						
								//message
								$message = "Dear Sir / Madam,\n\n";
								$message .= "Application leave by ".$data['rsProfile']['fullname']."(".$data['rsProfile']['staff_no'].")\n\n";
								$message .= $inputData['leave_code']. " : ".$inputData['no_of_days']." days\n";
								$message .= "Start Date : ".$date_dari."\n";
								$message .= "End Date : ".$date_ke."\n\n";
								$message .= "Kindly please check Leave Management System for details.\n\n";
								$message .= "Thank You";
								
								$this->load->helper('email');
								$this->load->library('email');
								
								$config['protocol']     ='tls';
								$config['smtp_host']    ='ssl://smtp.googlemail.com';
								$config['smtp_port']    ='465';
								$config['smtp_timeout'] ='30';
								$config['smtp_user']    ='leaveapplication00@gmail.com';
								$config['smtp_pass']    ='passworD';
								$config['charset']      ='utf-8';
								$config['newline']      ="\r\n";
								$config['wordwrap']     = TRUE;
								$config['mailtype']     = 'text';
								$this->email->initialize($config);
								$this->email->from('leaveapplication00@gmail.com');
								$this->email->to($value['email']); 
								$this->email->subject('e-Leave Application');
								$this->email->message($message);  
								$this->email->send();
			
								
							}
							//tutup send email///
							
							$this->session->set_flashdata('success', 'The information leave is succesfully save');
							redirect('staff/leave');
						}
						else 
						{
							//insert apply leave SL
							$table     		= "apply_leave";
							$arrayData 		= array(
												'id_users'			=> $data['id_users'],
												'leave_type'		=> $inputData['leave_type'],
												'time_type'			=> $inputData['time_type'],
												'no_of_days'		=> $inputData['no_of_days'],
												'date_from'			=> $inputData['date_from'],
												'date_to'			=> $inputData['date_to'],
												'leave_code'		=> $inputData['leave_code'],
												'state_reason'		=> $inputData['state_reason'],
												
												
												);
							$new_id 		=$this->m_query->insert_data($arrayData,$table);
							
							//update table leave staff
							$data['id_users']=$this->session->userdata('id_users');
							$inputData = $this->input->post();	
							
							$table     			= "leave_staff";
							$arrayData 		= array(
												'pending'			=> $inputData['no_of_days']
												
												);
							$where				= array('id_users'	=> $data['id_users'],'leave_code' =>'SL','table_year' =>$table_year); 
							$update_leave_staff		= $this->m_query->update_data($arrayData,$table,$where);
						
							//upload attachment
							if($new_id)
							{
								#Upload Photo
								$config['upload_path'] = 'assets/leave/';
								$config['allowed_types'] = 'gif|jpg|png|jpeg|jpe|pdf|doc|docx|rtf|text|txt';
								$newFileName = $_FILES['userfile']['name'];
								$fileExt = array_pop(explode(".", $newFileName));
								$config['file_name'] = $new_id.'.'.$fileExt;
								
								$table     			= "apply_leave";
								$arrayData 			= array(
								'file'			=> $new_id.'.'.$fileExt
								);
								$where				= array('id_apply_leave'	=> $new_id);

								$update_gallery 		= $this->m_query->update_data($arrayData,$table,$where);
											
							
								$this->load->library('upload', $config);
								$this->upload->do_upload();
							}
							
							//send email///
							
							if($inputData['leave_code']=='AL')
							{
								$inputData['leave_code'] = 'Annual Leave';
							}
							else if($inputData['leave_code']=='CL')
							{
								$inputData['leave_code'] = 'Compassionate Leave';
							}
							else if($inputData['leave_code']=='EL')
							{
								$inputData['leave_code'] = 'Emergency Leave';
							}
							else if($inputData['leave_code']=='PT')
							{
								$inputData['leave_code'] = 'Paternity Leave';
							}
							else if($inputData['leave_code']=='SL')
							{
								$inputData['leave_code'] = 'Sick Leave';
							}
							else if($inputData['leave_code']=='RL')
							{
								$inputData['leave_code'] = 'Replacement Leave';
							}
							else if($inputData['leave_code']=='UP')
							{
								$inputData['leave_code'] = 'Unpaid Leave';
							}
							else if($inputData['leave_code']=='MT')
							{
								$inputData['leave_code'] = 'Maternity Leave';
							}
							//get admin
							$table 					= 'admin';
							$staff			        = $this->m_query->get_all_rows($table);
							
							//pecahkan date
							$orderdate = explode('-', $inputData['date_from']);
							$date_dari=$orderdate[2].'-'.$orderdate[1].'-'.$orderdate[0];
							
							$orderdate2 = explode('-', $inputData['date_to']);
							$date_ke=$orderdate2[2].'-'.$orderdate2[1].'-'.$orderdate2[0];
							//tutup pecahkan date
							
							foreach($staff as $key => $value){
							
						
								//message
								$message = "Dear Sir / Madam,\n\n";
								$message .= "Application leave by ".$data['rsProfile']['fullname']."(".$data['rsProfile']['staff_no'].")\n\n";
								$message .= $inputData['leave_code']. " : ".$inputData['no_of_days']." days\n";
								$message .= "Start Date : ".$date_dari."\n";
								$message .= "End Date : ".$date_ke."\n\n";
								$message .= "Kindly please check Leave Management System for details.\n\n";
								$message .= "Thank You";
								
								$this->load->helper('email');
								$this->load->library('email');
								
								$config['protocol']     ='tls';
								$config['smtp_host']    ='ssl://smtp.googlemail.com';
								$config['smtp_port']    ='465';
								$config['smtp_timeout'] ='30';
								$config['smtp_user']    ='leaveapplication00@gmail.com';
								$config['smtp_pass']    ='passworD';
								$config['charset']      ='utf-8';
								$config['newline']      ="\r\n";
								$config['wordwrap']     = TRUE;
								$config['mailtype']     = 'text';
								$this->email->initialize($config);
								$this->email->from('leaveapplication00@gmail.com');
								$this->email->to($value['email']); 
								$this->email->subject('e-Leave Application');
								$this->email->message($message);  
								$this->email->send();
			
								
							}
							//tutup send email///
							
							$this->session->set_flashdata('success', 'The information leave is succesfully save');
							redirect('staff/leave');
							//redirect('staff/leave/new_leave_print/'.$new_id);
						}
						
					}
					else
					{
						$this->session->set_flashdata('error', 'Please attach the file');
						redirect('staff/leave');
					}
				}
				else
				{
					$this->session->set_flashdata('error', 'The total leave is not available.');
					redirect('staff/leave');
				}
			
			}
			else
			{
				$this->session->set_flashdata('error', 'The application is not available. Please contact administrator for any inquires.');
				redirect('staff/leave');
			}
				
		}
		
		//jika apply leave RL
		else if($inputData['leave_code']=='RL')
		{
		
			//kira adakah hari nak cuti 4 hari sebelum apply
			$date2=$inputData['date_from'];
			$date1 = date("Y-m-d");
			$datetime1 = new DateTime($date1);
			$datetime2 = new DateTime($date2);
			$interval = date_diff($datetime1, $datetime2);
			$days = $interval->format('%a');
			
			if($days >=4 )
			{
				
				
					if(empty($inputData['time_type']))
					{
						//insert apply leave RL
						$table     		= "apply_leave";
						$arrayData 		= array(
											'id_users'			=> $data['id_users'],
											'leave_type'		=> $inputData['leave_type'],
											'no_of_days'		=> $inputData['no_of_days'],
											'date_from'			=> $inputData['date_from'],
											'date_to'			=> $inputData['date_to'],
											'leave_code'		=> $inputData['leave_code'],
											'state_reason'		=> $inputData['state_reason'],
											
											
											);
						$this->m_query->insert_data($arrayData,$table);
						
						//update table leave staff
						$data['id_users']=$this->session->userdata('id_users');
						$inputData = $this->input->post();	
						
						$table     			= "leave_staff";
						$arrayData 		= array(
											'pending'			=> $inputData['no_of_days']
											
											);
						$where				= array('id_users'	=> $data['id_users'],'leave_code' =>'RL'); 
						$update_leave_staff		= $this->m_query->update_data($arrayData,$table,$where);
						
						//send email///
							
							if($inputData['leave_code']=='AL')
							{
								$inputData['leave_code'] = 'Annual Leave';
							}
							else if($inputData['leave_code']=='CL')
							{
								$inputData['leave_code'] = 'Compassionate Leave';
							}
							else if($inputData['leave_code']=='EL')
							{
								$inputData['leave_code'] = 'Emergency Leave';
							}
							else if($inputData['leave_code']=='PT')
							{
								$inputData['leave_code'] = 'Paternity Leave';
							}
							else if($inputData['leave_code']=='SL')
							{
								$inputData['leave_code'] = 'Sick Leave';
							}
							else if($inputData['leave_code']=='RL')
							{
								$inputData['leave_code'] = 'Replacement Leave';
							}
							else if($inputData['leave_code']=='UP')
							{
								$inputData['leave_code'] = 'Unpaid Leave';
							}
							else if($inputData['leave_code']=='MT')
							{
								$inputData['leave_code'] = 'Maternity Leave';
							}
							//get admin
							$table 					= 'admin';
							$staff			        = $this->m_query->get_all_rows($table);
							
							//pecahkan date
							$orderdate = explode('-', $inputData['date_from']);
							$date_dari=$orderdate[2].'-'.$orderdate[1].'-'.$orderdate[0];
							
							$orderdate2 = explode('-', $inputData['date_to']);
							$date_ke=$orderdate2[2].'-'.$orderdate2[1].'-'.$orderdate2[0];
							//tutup pecahkan date
							
							foreach($staff as $key => $value){
							
						
								//message
								$message = "Dear Sir / Madam,\n\n";
								$message .= "Application leave by ".$data['rsProfile']['fullname']."(".$data['rsProfile']['staff_no'].")\n\n";
								$message .= $inputData['leave_code']. " : ".$inputData['no_of_days']." days\n";
								$message .= "Start Date : ".$date_dari."\n";
								$message .= "End Date : ".$date_ke."\n\n";
								$message .= "Kindly please check Leave Management System for details.\n\n";
								$message .= "Thank You";
								
								$this->load->helper('email');
								$this->load->library('email');
								
								$config['protocol']     ='tls';
								$config['smtp_host']    ='ssl://smtp.googlemail.com';
								$config['smtp_port']    ='465';
								$config['smtp_timeout'] ='30';
								$config['smtp_user']    ='leaveapplication00@gmail.com';
								$config['smtp_pass']    ='passworD';
								$config['charset']      ='utf-8';
								$config['newline']      ="\r\n";
								$config['wordwrap']     = TRUE;
								$config['mailtype']     = 'text';
								$this->email->initialize($config);
								$this->email->from('leaveapplication00@gmail.com');
								$this->email->to($value['email']); 
								$this->email->subject('e-Leave Application');
								$this->email->message($message);  
								$this->email->send();
			
								
							}
							//tutup send email///
							
						$this->session->set_flashdata('success', 'The information leave is succesfully save');
						redirect('staff/leave');
					}
					else 
					{
						//insert apply leave RL
						$table     		= "apply_leave";
						$arrayData 		= array(
											'id_users'			=> $data['id_users'],
											'leave_type'		=> $inputData['leave_type'],
											'time_type'			=> $inputData['time_type'],
											'no_of_days'		=> $inputData['no_of_days'],
											'date_from'			=> $inputData['date_from'],
											'date_to'			=> $inputData['date_to'],
											'leave_code'		=> $inputData['leave_code'],
											'state_reason'		=> $inputData['state_reason'],
											
											
											);
						$this->m_query->insert_data($arrayData,$table);
						
						//update table leave staff
						$data['id_users']=$this->session->userdata('id_users');
						$inputData = $this->input->post();	
						
						$table     			= "leave_staff";
						$arrayData 		= array(
											'pending'			=> $inputData['no_of_days']
											
											);
						$where				= array('id_users'	=> $data['id_users'],'leave_code' =>'RL'); 
						$update_leave_staff		= $this->m_query->update_data($arrayData,$table,$where);
						
						//send email///
							
							if($inputData['leave_code']=='AL')
							{
								$inputData['leave_code'] = 'Annual Leave';
							}
							else if($inputData['leave_code']=='CL')
							{
								$inputData['leave_code'] = 'Compassionate Leave';
							}
							else if($inputData['leave_code']=='EL')
							{
								$inputData['leave_code'] = 'Emergency Leave';
							}
							else if($inputData['leave_code']=='PT')
							{
								$inputData['leave_code'] = 'Paternity Leave';
							}
							else if($inputData['leave_code']=='SL')
							{
								$inputData['leave_code'] = 'Sick Leave';
							}
							else if($inputData['leave_code']=='RL')
							{
								$inputData['leave_code'] = 'Replacement Leave';
							}
							else if($inputData['leave_code']=='UP')
							{
								$inputData['leave_code'] = 'Unpaid Leave';
							}
							else if($inputData['leave_code']=='MT')
							{
								$inputData['leave_code'] = 'Maternity Leave';
							}
							//get admin
							$table 					= 'admin';
							$staff			        = $this->m_query->get_all_rows($table);
							
							//pecahkan date
							$orderdate = explode('-', $inputData['date_from']);
							$date_dari=$orderdate[2].'-'.$orderdate[1].'-'.$orderdate[0];
							
							$orderdate2 = explode('-', $inputData['date_to']);
							$date_ke=$orderdate2[2].'-'.$orderdate2[1].'-'.$orderdate2[0];
							//tutup pecahkan date
							
							foreach($staff as $key => $value){
							
						
								//message
								$message = "Dear Sir / Madam,\n\n";
								$message .= "Application leave by ".$data['rsProfile']['fullname']."(".$data['rsProfile']['staff_no'].")\n\n";
								$message .= $inputData['leave_code']. " : ".$inputData['no_of_days']." days\n";
								$message .= "Start Date : ".$date_dari."\n";
								$message .= "End Date : ".$date_ke."\n\n";
								$message .= "Kindly please check Leave Management System for details.\n\n";
								$message .= "Thank You";
								
								$this->load->helper('email');
								$this->load->library('email');
								
								$config['protocol']     ='tls';
								$config['smtp_host']    ='ssl://smtp.googlemail.com';
								$config['smtp_port']    ='465';
								$config['smtp_timeout'] ='30';
								$config['smtp_user']    ='leaveapplication00@gmail.com';
								$config['smtp_pass']    ='passworD';
								$config['charset']      ='utf-8';
								$config['newline']      ="\r\n";
								$config['wordwrap']     = TRUE;
								$config['mailtype']     = 'text';
								$this->email->initialize($config);
								$this->email->from('leaveapplication00@gmail.com');
								$this->email->to($value['email']); 
								$this->email->subject('e-Leave Application');
								$this->email->message($message);  
								$this->email->send();
			
								
							}
							//tutup send email///
							
						$this->session->set_flashdata('success', 'The information leave is succesfully save');
						redirect('staff/leave');
					}
				
			}
			else
			{
				$this->session->set_flashdata('error', 'The application must be apply more than 4 days from the date taken.');
				redirect('staff/leave');
			}
		}
		
		//jika apply leave UP
		else if($inputData['leave_code']=='UP')
		{
		
			if(empty($inputData['time_type']))
			{
				//insert apply leave UP
				$table     		= "apply_leave";
				$arrayData 		= array(
									'id_users'			=> $data['id_users'],
									'leave_type'		=> $inputData['leave_type'],
									'no_of_days'		=> $inputData['no_of_days'],
									'date_from'			=> $inputData['date_from'],
									'date_to'			=> $inputData['date_to'],
									'leave_code'		=> $inputData['leave_code'],
									'state_reason'		=> $inputData['state_reason'],
									
									
									);
				$new_id 		=$this->m_query->insert_data($arrayData,$table);
				
				//update table leave staff
				$data['id_users']=$this->session->userdata('id_users');
				$inputData = $this->input->post();	
				
				$table     			= "leave_staff";
				$arrayData 		= array(
									'pending'			=> $inputData['no_of_days']
									
									);
				$where				= array('id_users'	=> $data['id_users'],'leave_code' =>'UP'); 
				$update_leave_staff		= $this->m_query->update_data($arrayData,$table,$where);
				
				//upload attachment
				if($new_id)
				{
					#Upload Photo
					$config['upload_path'] = 'assets/leave/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg|jpe|pdf|doc|docx|rtf|text|txt';
					$newFileName = $_FILES['userfile']['name'];
					$fileExt = array_pop(explode(".", $newFileName));
					$config['file_name'] = $new_id.'.'.$fileExt;
					
					$table     			= "apply_leave";
					$arrayData 			= array(
					'file'			=> $new_id.'.'.$fileExt
					);
					$where				= array('id_apply_leave'	=> $new_id);

					$update_gallery 		= $this->m_query->update_data($arrayData,$table,$where);
								
				
					$this->load->library('upload', $config);
					$this->upload->do_upload();
				}
				
				
				//send email///
							
							if($inputData['leave_code']=='AL')
							{
								$inputData['leave_code'] = 'Annual Leave';
							}
							else if($inputData['leave_code']=='CL')
							{
								$inputData['leave_code'] = 'Compassionate Leave';
							}
							else if($inputData['leave_code']=='EL')
							{
								$inputData['leave_code'] = 'Emergency Leave';
							}
							else if($inputData['leave_code']=='PT')
							{
								$inputData['leave_code'] = 'Paternity Leave';
							}
							else if($inputData['leave_code']=='SL')
							{
								$inputData['leave_code'] = 'Sick Leave';
							}
							else if($inputData['leave_code']=='RL')
							{
								$inputData['leave_code'] = 'Replacement Leave';
							}
							else if($inputData['leave_code']=='UP')
							{
								$inputData['leave_code'] = 'Unpaid Leave';
							}
							else if($inputData['leave_code']=='MT')
							{
								$inputData['leave_code'] = 'Maternity Leave';
							}
							//get admin
							$table 					= 'admin';
							$staff			        = $this->m_query->get_all_rows($table);
							
							//pecahkan date
							$orderdate = explode('-', $inputData['date_from']);
							$date_dari=$orderdate[2].'-'.$orderdate[1].'-'.$orderdate[0];
							
							$orderdate2 = explode('-', $inputData['date_to']);
							$date_ke=$orderdate2[2].'-'.$orderdate2[1].'-'.$orderdate2[0];
							//tutup pecahkan date
							
							foreach($staff as $key => $value){
							
						
								//message
								$message = "Dear Sir / Madam,\n\n";
								$message .= "Application leave by ".$data['rsProfile']['fullname']."(".$data['rsProfile']['staff_no'].")\n\n";
								$message .= $inputData['leave_code']. " : ".$inputData['no_of_days']." days\n";
								$message .= "Start Date : ".$date_dari."\n";
								$message .= "End Date : ".$date_ke."\n\n";
								$message .= "Kindly please check Leave Management System for details.\n\n";
								$message .= "Thank You";
								
								$this->load->helper('email');
								$this->load->library('email');
								
								$config['protocol']     ='tls';
								$config['smtp_host']    ='ssl://smtp.googlemail.com';
								$config['smtp_port']    ='465';
								$config['smtp_timeout'] ='30';
								$config['smtp_user']    ='leaveapplication00@gmail.com';
								$config['smtp_pass']    ='passworD';
								$config['charset']      ='utf-8';
								$config['newline']      ="\r\n";
								$config['wordwrap']     = TRUE;
								$config['mailtype']     = 'text';
								$this->email->initialize($config);
								$this->email->from('leaveapplication00@gmail.com');
								$this->email->to($value['email']); 
								$this->email->subject('e-Leave Application');
								$this->email->message($message);  
								$this->email->send();
			
								
							}
							//tutup send email///
							
				$this->session->set_flashdata('success', 'The information leave is succesfully save');
				redirect('staff/leave');
			}
			else 
			{
				//insert apply leave UP
				$table     		= "apply_leave";
				$arrayData 		= array(
									'id_users'			=> $data['id_users'],
									'leave_type'		=> $inputData['leave_type'],
									'time_type'			=> $inputData['time_type'],
									'no_of_days'		=> $inputData['no_of_days'],
									'date_from'			=> $inputData['date_from'],
									'date_to'			=> $inputData['date_to'],
									'leave_code'		=> $inputData['leave_code'],
									'state_reason'		=> $inputData['state_reason'],
									
									
									);
				$new_id 		=$this->m_query->insert_data($arrayData,$table);
				
				//update table leave staff
				$data['id_users']=$this->session->userdata('id_users');
				$inputData = $this->input->post();	
				
				$table     			= "leave_staff";
				$arrayData 		= array(
									'pending'			=> $inputData['no_of_days']
									
									);
				$where				= array('id_users'	=> $data['id_users'],'leave_code' =>'UP'); 
				$update_leave_staff		= $this->m_query->update_data($arrayData,$table,$where);
				
				//upload attachment
				if($new_id)
				{
					#Upload Photo
					$config['upload_path'] = 'assets/leave/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg|jpe|pdf|doc|docx|rtf|text|txt';
					$newFileName = $_FILES['userfile']['name'];
					$fileExt = array_pop(explode(".", $newFileName));
					$config['file_name'] = $new_id.'.'.$fileExt;
					
					$table     			= "apply_leave";
					$arrayData 			= array(
					'file'			=> $new_id.'.'.$fileExt
					);
					$where				= array('id_apply_leave'	=> $new_id);

					$update_gallery 		= $this->m_query->update_data($arrayData,$table,$where);
								
				
					$this->load->library('upload', $config);
					$this->upload->do_upload();
				}
				
				
				//send email///
							
							if($inputData['leave_code']=='AL')
							{
								$inputData['leave_code'] = 'Annual Leave';
							}
							else if($inputData['leave_code']=='CL')
							{
								$inputData['leave_code'] = 'Compassionate Leave';
							}
							else if($inputData['leave_code']=='EL')
							{
								$inputData['leave_code'] = 'Emergency Leave';
							}
							else if($inputData['leave_code']=='PT')
							{
								$inputData['leave_code'] = 'Paternity Leave';
							}
							else if($inputData['leave_code']=='SL')
							{
								$inputData['leave_code'] = 'Sick Leave';
							}
							else if($inputData['leave_code']=='RL')
							{
								$inputData['leave_code'] = 'Replacement Leave';
							}
							else if($inputData['leave_code']=='UP')
							{
								$inputData['leave_code'] = 'Unpaid Leave';
							}
							else if($inputData['leave_code']=='MT')
							{
								$inputData['leave_code'] = 'Maternity Leave';
							}
							//get admin
							$table 					= 'admin';
							$staff			        = $this->m_query->get_all_rows($table);
							
							//pecahkan date
							$orderdate = explode('-', $inputData['date_from']);
							$date_dari=$orderdate[2].'-'.$orderdate[1].'-'.$orderdate[0];
							
							$orderdate2 = explode('-', $inputData['date_to']);
							$date_ke=$orderdate2[2].'-'.$orderdate2[1].'-'.$orderdate2[0];
							//tutup pecahkan date
							
							foreach($staff as $key => $value){
							
						
								//message
								$message = "Dear Sir / Madam,\n\n";
								$message .= "Application leave by ".$data['rsProfile']['fullname']."(".$data['rsProfile']['staff_no'].")\n\n";
								$message .= $inputData['leave_code']. " : ".$inputData['no_of_days']." days\n";
								$message .= "Start Date : ".$date_dari."\n";
								$message .= "End Date : ".$date_ke."\n\n";
								$message .= "Kindly please check Leave Management System for details.\n\n";
								$message .= "Thank You";
								
								$this->load->helper('email');
								$this->load->library('email');
								
								$config['protocol']     ='tls';
								$config['smtp_host']    ='ssl://smtp.googlemail.com';
								$config['smtp_port']    ='465';
								$config['smtp_timeout'] ='30';
								$config['smtp_user']    ='leaveapplication00@gmail.com';
								$config['smtp_pass']    ='passworD';
								$config['charset']      ='utf-8';
								$config['newline']      ="\r\n";
								$config['wordwrap']     = TRUE;
								$config['mailtype']     = 'text';
								$this->email->initialize($config);
								$this->email->from('leaveapplication00@gmail.com');
								$this->email->to($value['email']); 
								$this->email->subject('e-Leave Application');
								$this->email->message($message);  
								$this->email->send();
			
								
							}
							//tutup send email///
							
				$this->session->set_flashdata('success', 'The information leave is succesfully save');
				redirect('staff/leave');
			}
					
		}
	}
	
	function list_pending()
	{	
		//call session
		$data['id_users']=$this->session->userdata('id_users');
		$data['user_type']=$this->session->userdata('user_type');
		
		if($data['user_type']=='staff')
		{
			//get users details staff
			$table 					= 'users';
			$tableNameToJoin 		= array('staff');
			$tableRelation 			= array('users.id_users = staff.id_users');
			$where 			   		= array('users.id_users' => $data['id_users']); 
			$data['rsProfile'] 		= $this->m_query->get_specified_row($table, $where, $tableNameToJoin , $tableRelation);
			
		}
		else
		{
			redirect('users/login', 'refresh');
		}
		
		//get list pending
		$date_year = date("Y");
		$table 					= 'apply_leave';      
		$where					= array('leave_status' => 0,'SUBSTRING(date_from,1,4)'=>$date_year,'id_users'=>$data['id_users']);
		$data['apply_leave'] 	= $this->m_query->get_all_rows($table,$where);
			
		$this->load->view('staff/v_list_leave_pending',$data);
	}
	
	function view_pending()
	{
		//call session
		$data['id_users']=$this->session->userdata('id_users');
		$data['user_type']=$this->session->userdata('user_type');
		
		if($data['user_type']=='staff')
		{
			//get users details staff
			$table 					= 'users';
			$tableNameToJoin 		= array('staff');
			$tableRelation 			= array('users.id_users = staff.id_users');
			$where 			   		= array('users.id_users' => $data['id_users']); 
			$data['rsProfile'] 		= $this->m_query->get_specified_row($table, $where, $tableNameToJoin , $tableRelation);
			
		}
		else
		{
			redirect('users/login', 'refresh');
		}
		
		//get tahun semasa
		$table_year= date("Y");
		
		$id_apply_leave = $this->uri->segment(4);
		
		//get staff id_users
		$table 					= 'apply_leave';
		$tableNameToJoin 		= array('staff');
		$tableRelation 			= array('staff.id_users = apply_leave.id_users');
		$where 			   		= array('apply_leave.id_apply_leave' => $id_apply_leave); 
		$data['detail_staff'] 		= $this->m_query->get_specified_row($table, $where, $tableNameToJoin , $tableRelation);
		
		if($data['detail_staff']['gender']=='Male')
		{
			$table = "apply_leave";
			$tableNameToJoin 		= array('staff','leave_name_male');
			$tableRelation 			= array('apply_leave.id_users = staff.id_users','apply_leave.leave_code = leave_name_male.leave_code');
			$where = array(
							'id_apply_leave' => $id_apply_leave
						);
			$data['apply_leave'] = $this->m_query->get_specified_row($table,$where,$tableNameToJoin , $tableRelation);
			
			//get leave staff
			$table 					= 'leave_staff';
			$tableNameToJoin 		= array('leave_name_male');
			$tableRelation 			= array('leave_staff.leave_code = leave_name_male.leave_code');
			$where 			   		= array('leave_staff.id_users' => $data['apply_leave']['id_users'],'leave_staff.table_year' => $table_year);
			$order_by 			   	= array('leave_staff.leave_code','asc');
			$data['leave_staff'] 	= $this->m_query->get_all_rows($table, $where, $tableNameToJoin, $tableRelation, $order_by);
		}
		else if($data['detail_staff']['gender']=='Female')
		{
			$table = "apply_leave";
			$tableNameToJoin 		= array('staff','leave_name_female');
			$tableRelation 			= array('apply_leave.id_users = staff.id_users','apply_leave.leave_code = leave_name_female.leave_code');
			$where = array(
							'id_apply_leave' => $id_apply_leave
						);
			$data['apply_leave'] = $this->m_query->get_specified_row($table,$where,$tableNameToJoin , $tableRelation);
			
			//get leave staff
			$table 					= 'leave_staff';
			$tableNameToJoin 		= array('leave_name_female');
			$tableRelation 			= array('leave_staff.leave_code = leave_name_female.leave_code');
			$where 			   		= array('leave_staff.id_users' => $data['apply_leave']['id_users'],'leave_staff.table_year' => $table_year);
			$order_by 			   	= array('leave_staff.leave_code','asc');
			$data['leave_staff'] 	= $this->m_query->get_all_rows($table, $where, $tableNameToJoin, $tableRelation, $order_by);
		}
		
		$this->load->view('staff/v_view_leave_pending',$data);
	}
	
	function list_approved()
	{	
		//call session
		$data['id_users']=$this->session->userdata('id_users');
		$data['user_type']=$this->session->userdata('user_type');
		
		if($data['user_type']=='staff')
		{
			//get users details staff
			$table 					= 'users';
			$tableNameToJoin 		= array('staff');
			$tableRelation 			= array('users.id_users = staff.id_users');
			$where 			   		= array('users.id_users' => $data['id_users']); 
			$data['rsProfile'] 		= $this->m_query->get_specified_row($table, $where, $tableNameToJoin , $tableRelation);
			
		}
		else
		{
			redirect('users/login', 'refresh');
		}
		
		//get list approved
		$date_year = date("Y");
		$table 					= 'apply_leave';      
		$where					= array('leave_status' => 1,'SUBSTRING(date_from,1,4)'=>$date_year,'id_users'=>$data['id_users']);
		$data['apply_leave'] 	= $this->m_query->get_all_rows($table,$where);
			
		$this->load->view('staff/v_list_leave_approved',$data);
	}
	
	function view_approved()
	{
		//call session
		$data['id_users']=$this->session->userdata('id_users');
		$data['user_type']=$this->session->userdata('user_type');
		
		if($data['user_type']=='staff')
		{
			//get users details staff
			$table 					= 'users';
			$tableNameToJoin 		= array('staff');
			$tableRelation 			= array('users.id_users = staff.id_users');
			$where 			   		= array('users.id_users' => $data['id_users']); 
			$data['rsProfile'] 		= $this->m_query->get_specified_row($table, $where, $tableNameToJoin , $tableRelation);
			
		}
		else
		{
			redirect('users/login', 'refresh');
		}
		
		//get tahun semasa
		$table_year= date("Y");
		
		$id_apply_leave = $this->uri->segment(4);
		
		//get staff id_users
		$table 					= 'apply_leave';
		$tableNameToJoin 		= array('staff');
		$tableRelation 			= array('staff.id_users = apply_leave.id_users');
		$where 			   		= array('apply_leave.id_apply_leave' => $id_apply_leave); 
		$data['detail_staff'] 		= $this->m_query->get_specified_row($table, $where, $tableNameToJoin , $tableRelation);
		
		if($data['detail_staff']['gender']=='Male')
		{
			$table = "apply_leave";
			$tableNameToJoin 		= array('staff','leave_name_male');
			$tableRelation 			= array('apply_leave.id_users = staff.id_users','apply_leave.leave_code = leave_name_male.leave_code');
			$where = array(
							'id_apply_leave' => $id_apply_leave
						);
			$data['apply_leave'] = $this->m_query->get_specified_row($table,$where,$tableNameToJoin , $tableRelation);
			
			//get leave staff
			$table 					= 'leave_staff';
			$tableNameToJoin 		= array('leave_name_male');
			$tableRelation 			= array('leave_staff.leave_code = leave_name_male.leave_code');
			$where 			   		= array('leave_staff.id_users' => $data['apply_leave']['id_users'],'leave_staff.table_year' => $table_year);
			$order_by 			   	= array('leave_staff.leave_code','asc');
			$data['leave_staff'] 	= $this->m_query->get_all_rows($table, $where, $tableNameToJoin, $tableRelation, $order_by);
		}
		else if($data['detail_staff']['gender']=='Female')
		{
			$table = "apply_leave";
			$tableNameToJoin 		= array('staff','leave_name_female');
			$tableRelation 			= array('apply_leave.id_users = staff.id_users','apply_leave.leave_code = leave_name_female.leave_code');
			$where = array(
							'id_apply_leave' => $id_apply_leave
						);
			$data['apply_leave'] = $this->m_query->get_specified_row($table,$where,$tableNameToJoin , $tableRelation);
			
			//get leave staff
			$table 					= 'leave_staff';
			$tableNameToJoin 		= array('leave_name_female');
			$tableRelation 			= array('leave_staff.leave_code = leave_name_female.leave_code');
			$where 			   		= array('leave_staff.id_users' => $data['apply_leave']['id_users'],'leave_staff.table_year' => $table_year);
			$order_by 			   	= array('leave_staff.leave_code','asc');
			$data['leave_staff'] 	= $this->m_query->get_all_rows($table, $where, $tableNameToJoin, $tableRelation, $order_by);
		}
		
		$this->load->view('staff/v_view_leave_approved',$data);
	}
	
	function print_leave()
	{
		//call session
		$data['id_users']=$this->session->userdata('id_users');
		$data['user_type']=$this->session->userdata('user_type');
		
		if($data['user_type']=='staff')
		{
			//get users details staff
			$table 					= 'users';
			$tableNameToJoin 		= array('staff');
			$tableRelation 			= array('users.id_users = staff.id_users');
			$where 			   		= array('users.id_users' => $data['id_users']); 
			$data['rsProfile'] 		= $this->m_query->get_specified_row($table, $where, $tableNameToJoin , $tableRelation);
			
		}
		else
		{
			redirect('users/login', 'refresh');
		}
		
		$id_apply_leave = $this->uri->segment(4);
		
		
		//get tahun semasa
		$table_year= date("Y");
		
		//get staff id_users
		$table 					= 'apply_leave';
		$tableNameToJoin 		= array('staff','leave_staff');
		$tableRelation 			= array('staff.id_users = apply_leave.id_users','apply_leave.id_users = leave_staff.id_users');
		$where 			   		= array('apply_leave.id_apply_leave' => $id_apply_leave,'leave_staff.table_year' => $table_year); 
		$data['detail_staff'] 		= $this->m_query->get_specified_row($table, $where, $tableNameToJoin , $tableRelation);
		
		if($data['detail_staff']['gender']=='Female')
		{
			$table = "apply_leave";
			$tableNameToJoin 		= array('staff','leave_name_female');
			$tableRelation 			= array('apply_leave.id_users = staff.id_users','apply_leave.leave_code = leave_name_female.leave_code');
			$where = array(
							'id_apply_leave' => $id_apply_leave
						);
			$data['apply_leave'] = $this->m_query->get_specified_row($table,$where,$tableNameToJoin , $tableRelation);
		}
		
		else if($data['detail_staff']['gender']=='Male')
		{
			$table = "apply_leave";
			$tableNameToJoin 		= array('staff','leave_name_male');
			$tableRelation 			= array('apply_leave.id_users = staff.id_users','apply_leave.leave_code = leave_name_male.leave_code');
			$where = array(
							'id_apply_leave' => $id_apply_leave
						);
			$data['apply_leave'] = $this->m_query->get_specified_row($table,$where,$tableNameToJoin , $tableRelation);
		}
		
		
		$p = new pdf();
		$p->load_view('admin/v_print_leave', $data);
		$p->set_paper('c4', 'potrait');
		$p->render();
		$p->stream("download.pdf",array('Attachment'=>0));
		$p->stream("maklumat_permohonan.pdf");		
	}
	
	function list_rejected()
	{	
		//call session
		$data['id_users']=$this->session->userdata('id_users');
		$data['user_type']=$this->session->userdata('user_type');
		
		if($data['user_type']=='staff')
		{
			//get users details staff
			$table 					= 'users';
			$tableNameToJoin 		= array('staff');
			$tableRelation 			= array('users.id_users = staff.id_users');
			$where 			   		= array('users.id_users' => $data['id_users']); 
			$data['rsProfile'] 		= $this->m_query->get_specified_row($table, $where, $tableNameToJoin , $tableRelation);
			
		}
		else
		{
			redirect('users/login', 'refresh');
		}
		
		//get list approved
		$date_year = date("Y");
		$table 					= 'apply_leave';      
		$where					= array('leave_status' => 2,'SUBSTRING(date_from,1,4)'=>$date_year,'id_users'=>$data['id_users']);
		$data['apply_leave'] 	= $this->m_query->get_all_rows($table,$where);
			
		$this->load->view('staff/v_list_leave_rejected',$data);
	}
	
	function view_rejected()
	{
		//call session
		$data['id_users']=$this->session->userdata('id_users');
		$data['user_type']=$this->session->userdata('user_type');
		
		if($data['user_type']=='staff')
		{
			//get users details staff
			$table 					= 'users';
			$tableNameToJoin 		= array('staff');
			$tableRelation 			= array('users.id_users = staff.id_users');
			$where 			   		= array('users.id_users' => $data['id_users']); 
			$data['rsProfile'] 		= $this->m_query->get_specified_row($table, $where, $tableNameToJoin , $tableRelation);
			
		}
		else
		{
			redirect('users/login', 'refresh');
		}
		
		//get tahun semasa
		$table_year= date("Y");
		
		$id_apply_leave = $this->uri->segment(4);
		
		//get staff id_users
		$table 					= 'apply_leave';
		$tableNameToJoin 		= array('staff');
		$tableRelation 			= array('staff.id_users = apply_leave.id_users');
		$where 			   		= array('apply_leave.id_apply_leave' => $id_apply_leave); 
		$data['detail_staff'] 		= $this->m_query->get_specified_row($table, $where, $tableNameToJoin , $tableRelation);
		
		if($data['detail_staff']['gender']=='Male')
		{
			$table = "apply_leave";
			$tableNameToJoin 		= array('staff','leave_name_male');
			$tableRelation 			= array('apply_leave.id_users = staff.id_users','apply_leave.leave_code = leave_name_male.leave_code');
			$where = array(
							'id_apply_leave' => $id_apply_leave
						);
			$data['apply_leave'] = $this->m_query->get_specified_row($table,$where,$tableNameToJoin , $tableRelation);
			
			//get leave staff
			$table 					= 'leave_staff';
			$tableNameToJoin 		= array('leave_name_male');
			$tableRelation 			= array('leave_staff.leave_code = leave_name_male.leave_code');
			$where 			   		= array('leave_staff.id_users' => $data['apply_leave']['id_users'],'leave_staff.table_year' => $table_year);
			$order_by 			   	= array('leave_staff.leave_code','asc');
			$data['leave_staff'] 	= $this->m_query->get_all_rows($table, $where, $tableNameToJoin, $tableRelation, $order_by);
		}
		else if($data['detail_staff']['gender']=='Female')
		{
			$table = "apply_leave";
			$tableNameToJoin 		= array('staff','leave_name_female');
			$tableRelation 			= array('apply_leave.id_users = staff.id_users','apply_leave.leave_code = leave_name_female.leave_code');
			$where = array(
							'id_apply_leave' => $id_apply_leave
						);
			$data['apply_leave'] = $this->m_query->get_specified_row($table,$where,$tableNameToJoin , $tableRelation);
			
			//get leave staff
			$table 					= 'leave_staff';
			$tableNameToJoin 		= array('leave_name_female');
			$tableRelation 			= array('leave_staff.leave_code = leave_name_female.leave_code');
			$where 			   		= array('leave_staff.id_users' => $data['apply_leave']['id_users'],'leave_staff.table_year' => $table_year);
			$order_by 			   	= array('leave_staff.leave_code','asc');
			$data['leave_staff'] 	= $this->m_query->get_all_rows($table, $where, $tableNameToJoin, $tableRelation, $order_by);
		}
		
		$this->load->view('staff/v_view_leave_rejected',$data);
	}
	

}