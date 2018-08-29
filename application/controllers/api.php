<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  
class Api extends CI_Controller {

	public function __construct() {
    	parent::__construct();
		
		$this->load->helper('status');
		$this->load->helper('message');
		
		$this->load->helper('transaction');
		$this->load->helper('api');
		$this->load->helper('init');
		$this->load->helper('fcm');
		
		$this->load->model('../m_api');
	}

	public function activation_account() {
		$activation_token = $this->uri->segment(3);
		$activate = $this->sosapi_model->accountActivation($activation_token);
		
		if ($activate=='1') {
			$this->load->view('activation');
		} 
		else {
			echo "activation failed";
		}
	}
	
	public function upload_identity() {
		$id = $this->input->post('id');
		
		$config['upload_path']   = './assets/uploads/member_identity/';;
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$this->load->library('upload', $config);
		
		if (!$this->upload->do_upload('imagefile')) {
			$error = array('error' => $this->upload->display_errors());
			$head_code	= 200;
			$result = array(
				'status'	=> '207',
				'message'	=> $error['error']
			);
		} 
		else {
			$image  = $this->upload->data();
			$result = array(
				'status'	=> '200',
				'id' 		=> $id,
				'data' 		=> $image
			);
			
			$data = array('identity_photo'=>$image['file_name']);
			$file = $image['file_name'];
			
			// update image
			$head_code	= 200;
			$updateData = $this->m_global->set_status('tm_member', 'member_id', $id, 'member_identity', $file);
			if($updateData == 1) {
				$resultData = $this->m_api->getIdentityUserById($id);
				$result = array(
					'status' 	=> '200',
					'message' 	=> 'Update success',
					'data' 		=> $resultData
				);
			} 
			else {
				$result = array(
					'status' 	=> '207',
					'message' 	=> 'No Update ',
					'data' 		=> []
				);
			}
		}

		json($result, $head_code);
	}
	
	public function upload_user_picture() {
		$id = $this->input->post('id');
		
		$config['upload_path']   = './assets/uploads/member/';;
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$this->load->library('upload', $config);
		
		if (!$this->upload->do_upload('imagefile')) {
			$error = array('error' => $this->upload->display_errors());
			$head_code	= 200;
			$result = array(
				'status'	=> '207',
				'message'	=> $error['error'],
				'data' 		=> []
			);
		} 
		else {
			$image  = $this->upload->data();
			$result = array(
				'status'	=> '200',
				'id' 		=> $id,
				'data' 		=> $image
			);
			
			$data = array('identity_photo'=>$image['file_name']);
			$file = $image['file_name'];
			
			// update image
			$head_code	= 200;
			$updateData = $this->m_global->set_status('tm_member', 'member_id', $id, 'member_image', $file);
			if($updateData == 1) {
				$resultData = $this->m_api->getIdentityUserById($id);
				$result = array(
					'status' 	=> '200',
					'message' 	=> 'Update success',
					'data' 		=> $resultData
				);
			} 
			else {
				$result = array(
					'status' 	=> '207',
					'message' 	=> 'No Update ',
					'data' 		=> []
				);
			}
		}

		json($result, $head_code);
	}
	
	/* new function */
	public function logout() {
		$getData = (array) json_decode(file_get_contents('php://input'));
		$x_token = md5('user_id');
		
		if(checking_header($x_token)) {
			// update is login
			$head_code	= 200;
			$updateData = $this->m_global->set_status('tm_member', 'member_id', $getData['user_id'], 'is_login', 0);
			if($updateData == 1) {
				// update device
				$this->m_global->set_status('tm_member', 'member_id', $getData['user_id'], 'device_token', "");
				
				// update last login
				$this->m_global->set_status('tm_member', 'member_id', $getData['user_id'], 'last_login', get_ymdhis());
				
				$head_code	= 200;
				$err_code 	= 300;
				$result 	= set_warning($err_code);
			} 
			else {
				$head_code	= 200;
				$err_code 	= 306;
				$result 	= set_warning($err_code);
			}
		}
		else {
			$head_code	= 200;
			$err_code 	= 401;
			$result 	= set_warning($err_code);
		}
		
		json($result, $head_code);
	}
	
	public function login() {
		$getData = (array) json_decode(file_get_contents('php://input'));
		$x_token = md5('email'.'password'.'role'.'device_token');
		
		if(checking_header($x_token)) {
			$cekExistingEmail = $this->m_api->cekEmail($getData['email']);
			if ($cekExistingEmail['response'] == '0') {
				$head_code	= 200;
				$err_code 	= 237;
				$result 	= set_warning($err_code);
			} 
			else {
				$query = $this->m_api->login($getData['email'], $getData['password']);
				$stringForToken = get_ymdhis() .'4ll4h';
				
				if ($query['response'] == '1') {
					// update device
					$this->m_global->set_status('tm_member', 'member_email', $getData['email'], 'device_token', $getData['device_token']);
					
					// update is login
					$this->m_global->set_status('tm_member', 'member_id', $getData['email'], 'is_login', 1);
					
					$head_code	= 200;
					$result = array(
						'status' 		=> '200',
						'message' 		=> 'success',
						'token' 		=> md5($stringForToken),
						'device_token' 	=> $getData['device_token'],
						'data' 			=> $query['data']
					);
				} 
				else {
					$head_code	= 200;
					$err_code 	= 204;
					$result 	= set_warning($err_code);
				}
			}
		}
		else {
			$head_code	= 200;
			$err_code 	= 401;
			$result 	= set_warning($err_code);
		}
		
		json($result, $head_code);
	}
	
	public function login_socmed() {
		$getData = (array) json_decode(file_get_contents('php://input'));
		$x_token = md5('email'.'firstname'.'lastname'.'socmed_token'.'device_token');
		
		if(checking_header($x_token)) {
			$query = $this->m_api->loginSocmed($getData['email']);
			$stringForToken = get_ymdhis() .'4ll4h';
			
			if ($query['response'] == '1') {
				// update device
				$this->m_global->set_status('tm_member', 'member_email', $getData['email'], 'device_token', $getData['device_token']);
				
				$head_code	= 200;
				$result = array(
					'status' 		=> '200',
					'message' 		=> 'success',
					'token' 		=> md5($stringForToken),
					'device_token' 	=> $getData['device_token'],
					'data' 			=> $query['data']
				);
			} 
			else {
				$generatedPassword = chr(rand(65,90)).chr(rand(65,90)).chr(rand(65,90)).chr(rand(65,90));
				
				$data = array(
					'member_email' 		=> $getData['email'],
					'member_status' 	=> 1,
					'device_token' 		=> $getData['device_token'],
					'member_password' 	=> md5($generatedPassword),
					'member_role' 		=> 'user',
					'join_date' 		=> get_ymdhis()
				);
				
				$crud = $this->m_crud->insert_id('tm_member', $data);
				if($crud == 0) {
					$head_code	= 200;
					$err_code 	= 204;
					$result 	= set_warning($err_code);
				}
				else {
					// kirim Email pemberitahuan login manual untuk firstMedia ID
					$this->load->library('email');
					$this->email->from('no-reply@sos1health.com', 'SOS 1Health');
					$this->email->to($getData['email']);
					$email = $getData['email'];
					$this->email->subject('FirstID Login - SOS 1Health ');
					$this->email->set_mailtype("html");
				   
					$content = "
						<html>
						<head></head>
						<p>Hai, $email
						<br><br>
						Thank you for registering with us using FirstID.<br/>
						If you wish to login manually using your email without FirstID, please use the credential below: <br/><br/>
						email : $email <br/>
						password : $generatedPassword <br/>
						<br><br>
						<br><br>
						<br><br>
						<p>Cheers,<br>SOS 1Health Team</p>
						</html>";
						
					$this->email->message($content);
					$this->email->send();
					
					$head_code	= 200;
					$result = array(
						'status' 	=> '200',
						'message' 	=> 'Insert success',
						'data' 		=> $data
					);
				}
			}
		}
		else {
			$head_code	= 200;
			$err_code 	= 401;
			$result 	= set_warning($err_code);
		}
		
		json($result, $head_code);
	}
	
	public function registration() {
		$getData = (array) json_decode(file_get_contents('php://input'));
		$x_token = md5('email'.'password'.'firstname'.'lastname'.'phone_number'.'age'.'gender'.'address'.'role');
		
		if(checking_header($x_token)) {
			if(($getData['email'] == null) || ($getData['password'] == null) || ($getData['firstname'] == null) || ($getData['lastname'] == null) || ($getData['role'] == null)) {
				$head_code	= 200;
				$err_code 	= 402;
				$result 	= set_warning($err_code);
			}
			else {
				$cekExistingEmail = $this->m_api->cekEmail($getData['email']);
				if ($cekExistingEmail['response'] == '1') {
					$head_code	= 200;
					$err_code 	= 409;
					$result 	= set_warning($err_code);
				} 
				else {
					$stringForToken = get_ymdhis() .'4ll4h';
					
					$data = array(
						'member_email' 		=> $getData['email'],
						'member_password' 	=> md5($getData['password']),
						'member_firstname' 	=> $getData['firstname'],
						'member_lastname'	=> $getData['lastname'],
						'member_age'		=> $getData['age'],
						'member_gender'		=> $getData['gender'],
						'member_address'	=> $getData['address'],
						'member_status' 	=> 1,
						'activation_token' 	=> md5($stringForToken),
						'member_role' 		=> 'user',
						'join_date' 		=> get_ymdhis()
					);
					
					$crud = $this->m_crud->insert_id('tm_member', $data);
					if($crud == 0) {
						$head_code	= 200;
						$err_code 	= 205;
						$result 	= set_warning($err_code);
					}
					else {
						// kirim Email pemberitahuan login manual untuk firstMedia ID
						$this->load->library('email');
						$this->email->from('no-reply@sos1health.com', 'SOS 1Health');
						$this->email->to($getData['email']);
						$email = $getData['email'];
						$this->email->subject('Account Activation - SOS 1Health ');
						$this->email->set_mailtype("html");
						
						$aktivasi = 'http://sos1health.com/api/v1/activation_account/'.md5($stringForToken);
						$content = "
						<html>
						<head>
							<script>
								function openApp() {
									window.location.href = 'MyApp://Ambulance Siloam 1Health';
								}
							</script>
						</head>
						<p>Hai, $email
						<br><br>
						Thank you for registering with us.  <br/>
						<a href='$aktivasi'>Please click here for your Account Activation.</a>
						<br><br>
						<br><br>
						<br><br>
						<p>Cheers,<br>SOS 1Health Team</p>
						</html>";
							
						$this->email->message($content);
						$this->email->send();
						
						$query = $this->m_api->getIdentityUserById($crud);
						
						$head_code	= 200;
						$result = array(
							'status' 	=> '200',
							'message' 	=> 'Insert success',
							'data' 		=> $query
						);
					}	
				}
			}
		}
		else {
			$head_code	= 200;
			$err_code 	= 401;
			$result 	= set_warning($err_code);
		}
		
		json($result, $head_code);
	}
	
	public function update_profile() {
		$getData = (array) json_decode(file_get_contents('php://input'));
		$x_token = md5('id'.'firstname'.'lastname'.'age'.'gender'.'address');
		
		if(checking_header($x_token)) {
			 $data = array(
				'member_firstname' 	=> $getData['firstname'],
				'member_lastname' 	=> $getData['lastname'],
				'member_age'		=> $getData['age'],
				'member_gender'		=> $getData['gender'],
				'member_address'	=> $getData['address']
			);
			
			// update image
			$head_code	= 200;
			$updateData = $this->m_crud->update('tm_member', 'member_id', $data, $getData['id']);
			if($updateData == 1) {
				$resultData = $this->m_api->getIdentityUserById($getData['id']);
				$result = array(
					'status' 	=> '200',
					'message' 	=> 'Update success',
					'data' 		=> $resultData
				);
			} 
			else {
				$result = array(
					'status' 	=> '207',
					'message' 	=> 'No Update ',
					'data' 		=> []
				);
			}
		}
		else {
			$head_code	= 200;
			$err_code 	= 401;
			$result 	= set_warning($err_code);
		}
		
		json($result, $head_code);
	}
	
	public function get_user_by_email() {
		$getData = (array) json_decode(file_get_contents('php://input'));
		$x_token = md5('email');
		
		if(checking_header($x_token)) {
			$query = $this->m_api->getUserByEmail($getData['email']);
			if ($query['response'] == '1') {
				$head_code	= 200;
				$result = array(
					'status' 	=> '200',
					'message' 	=> 'success',
					'data' 		=> $query['data']
				);
			} 
			else {
				$head_code	= 200;
				$err_code 	= 204;
				$result 	= set_warning($err_code);
			}
		}
		else {
			$head_code	= 200;
			$err_code 	= 401;
			$result 	= set_warning($err_code);
		}
		
		json($result, $head_code);
	}
	
	public function update_user_phone() {
		$getData = (array) json_decode(file_get_contents('php://input'));
		$x_token = md5('id'.'phone_number'.'activation_code');
		
		if(checking_header($x_token)) {
			 $data = array(
				'activation_code' 	=> $getData['activation_code'],
				'member_phone' 		=> $getData['phone_number'],
				'member_status'		=> 1
			);
			
			// update image
			$head_code	= 200;
			$updateData = $this->m_crud->update('tm_member', 'member_id', $data, $getData['id']);
			if($updateData == 1) {
				$resultData = $this->m_api->getIdentityUserById($getData['id']);
				$result = array(
					'status' 	=> '200',
					'message' 	=> 'Update success',
					'data' 		=> $resultData
				);
			} 
			else {
				$result = array(
					'status' 	=> '207',
					'message' 	=> 'No Update ',
					'data' 		=> []
				);
			}
		}
		else {
			$head_code	= 200;
			$err_code 	= 401;
			$result 	= set_warning($err_code);
		}
		
		json($result, $head_code);
	}
	
	public function create_emergency_contact() {
		$getData = (array) json_decode(file_get_contents('php://input'));
		$x_token = md5('user_id'.'firstname'.'lastname'.'email'.'relation'.'phone_number');
		
		if(checking_header($x_token)) {
			$data = array(
				'member_id' 		=> $getData['user_id'],
				'contact_firstname'	=> $getData['firstname'],
				'contact_lastname'	=> $getData['lastname'],
				'contact_email'		=> $getData['email'],
				'contact_relation'	=> $getData['relation'],
				'contact_phone'		=> $getData['phone_number']
			);
			
			$crud = $this->m_crud->insert_id('ti_contact', $data);
			if($crud == 0) {
				$head_code	= 200;
				$err_code 	= 205;
				$result 	= set_warning($err_code);
			}
			else {
				$member = $this->m_api->getIdentityUserById($getData['user_id']);
				$fullname = "";		$email = "";
				foreach($member as $row) {
					$fullname 	= $member['firstname'] .' '. $member['lastname'];
					$email 		= $member['email'];
				}
				
				//send email to emergency_contact
				$this->load->library('email');
				$this->email->from('no-reply@sos1health.com', 'SOS 1Health');
				$this->email->to($getData['email']);
				
				$this->email->subject('Emergency Contact - SOS 1Health ');
				$this->email->set_mailtype("html");
				
				$linkapps = 'https://appsto.re/id/WJtjdb.i';
				$content = "
				<html>
				<head></head>
				<p>Hai, $email
                <br><br>
                $fullname listed you as an Emergency Contact of SOS 1Health Application.  <br/>
                find more about application by download for iOS <a href='$linkapps'>here.</a> <br/>
                <br><br>
                <br><br>
                <br><br>
                <p>Cheers,<br>SOS 1Health Team</p>
                </html>";
					
				$this->email->message($content);
				$this->email->send();
				
				$head_code	= 200;
				
				$result = array(
					'status' 	=> '200',
					'message' 	=> 'Insert success',
					'data' 		=> $data
				);
			}	
		}
		else {
			$head_code	= 200;
			$err_code 	= 401;
			$result 	= set_warning($err_code);
		}
		
		json($result, $head_code);
	}
	
	public function update_emergency_contact() {
		$getData = (array) json_decode(file_get_contents('php://input'));
		$x_token = md5('user_id'.'firstname'.'lastname'.'email'.'relation'.'phone_number');
		
		if(checking_header($x_token)) {
			$data = array(
				'member_id' 		=> $getData['user_id'],
				'contact_firstname'	=> $getData['firstname'],
				'contact_lastname'	=> $getData['lastname'],
				'contact_email'		=> $getData['email'],
				'contact_relation'	=> $getData['relation'],
				'contact_phone'		=> $getData['phone_number']
			);
			
			// update image
			$head_code	= 200;
			$updateData = $this->m_crud->update('ti_contact', 'member_id', $data, $getData['user_id']);
			if($updateData == 1) {
				$result = array(
					'status' 	=> '200',
					'message' 	=> 'Update success',
					'data' 		=> $data
				);
			} 
			else {
				$result = array(
					'status' 	=> '207',
					'message' 	=> 'No Update ',
					'data' 		=> []
				);
			}
		}
		else {
			$head_code	= 200;
			$err_code 	= 401;
			$result 	= set_warning($err_code);
		}
		
		json($result, $head_code);
	}
	
	public function get_emergency_contact() {
		$getData = (array) json_decode(file_get_contents('php://input'));
		$x_token = md5('user_id');
		
		if(checking_header($x_token)) {
			$head_code	= 200;
			$resultData = $this->m_api->getEmergencyContact($getData['user_id']);
			if(!empty($resultData)) {
				$result = array(
					'status' 	=> '200',
					'message' 	=> 'Success',
					'data' 		=> $resultData
				);
			} else {
				$result = array(
					'status' 	=> '208',
					'message' 	=> 'No Update ',
					'data' 		=> []
				);
			}
		}
		else {
			$head_code	= 200;
			$err_code 	= 401;
			$result 	= set_warning($err_code);
		}
		
		json($result, $head_code);
	}
	
	/* new function */
	public function create_emergency_contact_other() {
		$getData = (array) json_decode(file_get_contents('php://input'));
		$x_token = md5('user_id'.'fullname'.'phone_number'.'age'.'gender'.'relation'.'address');
		
		if(checking_header($x_token)) {
			$data = array(
				'member_id' 		=> $getData['user_id'],
				'contact_name'		=> $getData['fullname'],
				'contact_phone'		=> $getData['phone_number'],
				'contact_age'		=> $getData['age'],
				'contact_gender'	=> $getData['gender'],
				'contact_relation'	=> $getData['relation'],
				'contact_address'	=> $getData['address']
			);
			
			$crud = $this->m_crud->insert_id('tp_contact', $data);
			if($crud == 0) {
				$head_code	= 200;
				$err_code 	= 205;
				$result 	= set_warning($err_code);
			}
			else {
				$head_code	= 200;
				$result = array(
					'status' 	=> '200',
					'message' 	=> 'Success',
					'data' 		=> $data
				);
			}	
		}
		else {
			$head_code	= 200;
			$err_code 	= 401;
			$result 	= set_warning($err_code);
		}
		
		json($result, $head_code);
	}
	
	public function get_hospitals() {
		$getData = (array) json_decode(file_get_contents('php://input'));
		$x_token = md5('id'.'latitude'.'longitude');
		
		if(checking_header($x_token)) {
			if (($getData['latitude'] == null) || ($getData['longitude'] == null)) {
				$head_code	= 200;
				$err_code 	= 400;
				$result 	= set_warning($err_code);
			} 
			else {
				$query = $this->m_api->getNearestHospitals($getData['latitude'], $getData['longitude']);
				if ($query['response'] == '1') {
					$head_code	= 200;
					$result = array(
						'status' 	=> '200',
						'message' 	=> 'We got an hospitals near you',
						'data' 		=> $query['data']
					);
				} 
				else {
					$head_code	= 200;
					$err_code 	= 201;
					$result 	= set_warning($err_code);
				}
			}
		}
		else {
			$head_code	= 200;
			$err_code 	= 401;
			$result 	= set_warning($err_code);
		}
		
		json($result, $head_code);
	}
	
	/* new function */
	public function get_hospital_detail() {
		$getData = (array) json_decode(file_get_contents('php://input'));
		$x_token = md5('hospital_id');
		
		if(checking_header($x_token)) {
			$head_code	= 200;
			$resultData  = $this->m_api->getIdentityHospitalById($getData['hospital_id']);
			if(!empty($resultData)) {
				$result = array(
					'status' 			=> '200',
					'message' 			=> 'Success',
					'data_specialist' 	=> set_hospital_specialist($getData['hospital_id']),
					'data_facility' 	=> set_hospital_facility($getData['hospital_id']),
					'data' 				=> $resultData
				);
			} else {
				$result = array(
					'status' 			=> '208',
					'message' 			=> 'No Data ',
					'data_specialist' 	=> [],
					'data_facility' 	=> [],
					'data' 				=> []
				);
			}
		}
		else {
			$head_code	= 200;
			$err_code 	= 401;
			$result 	= set_warning($err_code);
		}
		
		json($result, $head_code);
	}
	
	/* new function */
	public function get_areas() {
		$getData = (array) json_decode(file_get_contents('php://input'));
		$x_token = md5('none');
		
		if(checking_header($x_token)) {
			$query = $this->m_api->getAreas();
			if (!empty($query)) {
				$head_code	= 200;
				$result = array(
					'status' 	=> '200',
					'message' 	=> 'We got an area near you',
					'data' 		=> $query
				);
			} 
			else {
				$head_code	= 200;
				$err_code 	= 301;
				$result 	= set_warning($err_code);
			}
		}
		else {
			$head_code	= 200;
			$err_code 	= 401;
			$result 	= set_warning($err_code);
		}
		
		json($result, $head_code);
	}
	
	/* new function */
	public function create_emergency() {
		$getData = (array) json_decode(file_get_contents('php://input'));
		$x_token = md5('user_id'.'patient_name'.'fullname'.'phone_number'.'latitude'.'longitude'.'address'.'category'.'sub_category');
		
		if(checking_header($x_token)) {
			if(($getData['user_id'] == null) || ($getData['patient_name'] == null) || ($getData['fullname'] == null) || ($getData['phone_number'] == null) || ($getData['latitude'] == null) || ($getData['longitude'] == null) || ($getData['address'] == null) || ($getData['category'] == null) || ($getData['sub_category'] == null)) {
				$head_code	= 200;
				$err_code 	= 402;
				$result 	= set_warning($err_code);
			}
			else {
				$data = array(
					'emergency_status'			=> 0,
					'emergency_callreference'	=> generate_call_reference(),
					'emergency_date'			=> get_ymd(),
					'emergency_time'			=> get_his(),
					'emergency_callername' 		=> $getData['fullname'],
					'emergency_callerphone' 	=> $getData['phone_number'],
					'emergency_patientname' 	=> $getData['patient_name'],
					'emergency_infolatitude' 	=> $getData['latitude'],
					'emergency_infolongitude' 	=> $getData['longitude'],
					'emergency_infostreet' 		=> $getData['address'],
					'emergency_infosearch' 		=> $getData['address'],
					'category_id' 				=> $getData['category'],
					'subcategory_id' 			=> $getData['sub_category'],
					'member_id' 				=> $getData['user_id']
				);
				
				$crud = $this->m_crud->insert_id('tp_emergency', $data);
				if($crud == 0) {
					$head_code	= 200;
					$err_code 	= 205;
					$result 	= set_warning($err_code);
				}
				else {
					$head_code	= 200;
					$resultData = $this->m_api->getTrackEmergencyById($crud);
					if(!empty($resultData)) {
						$result = array(
							'status' 	=> '200',
							'message' 	=> 'Success',
							'data' 		=> $resultData
						);
					} else {
						$result = array(
							'status' 	=> '208',
							'message' 	=> 'No Data ',
							'data' 		=> []
						);
					}
				}
			}
		}
		else {
			$head_code	= 200;
			$err_code 	= 401;
			$result 	= set_warning($err_code);
		}
		
		json($result, $head_code);
	}
	
	/* new function */
	public function cancel_emergency() {
		$getData = (array) json_decode(file_get_contents('php://input'));
		$x_token = md5('order_id'.'reason');
		
		if(checking_header($x_token)) {
			$gekStatusOrder = $this->m_api->get_status_emergency($getData['order_id']);
			if ($gekStatusOrder == 5) {
				$head_code	= 200;
				$err_code 	= 506;
				$result 	= set_warning($err_code);
			} 
			else {
				// update data
				$data = array(
					'reason_cancel'		=> $getData['reason'],
					'time_cancel'		=> get_ymdhis(),
					'emergency_status' 	=> 2
				);
					
				$head_code	= 200;
				$crud = $this->m_crud->update('tp_emergency', 'emergency_id', $data, $getData['order_id']);
				if($crud != 0) {
					$resultData = $this->m_api->getTrackEmergencyById($getData['order_id']);
					$result = array(
						'status' 	=> '200',
						'message' 	=> 'Update success',
						'data' 		=> $resultData
					);
				} 
				else {
					$result = array(
						'status' 	=> '207',
						'message' 	=> 'No Update ',
						'data' 		=> []
					);
				}
			}
		}
		else {
			$head_code	= 200;
			$err_code 	= 401;
			$result 	= set_warning($err_code);
		}
		
		json($result, $head_code);
	}
	
	/* new function */
	public function create_emergency_rating() {
		$getData = (array) json_decode(file_get_contents('php://input'));
		$x_token = md5('order_id'.'rating'.'comment');
		
		if(checking_header($x_token)) {
			$data = array(
				'emergency_rating'	=> $getData['rating'],
				'emergency_comment'	=> $getData['comment'],
				'time_rating'		=> get_ymdhis()
			);
			
			$crud = $this->m_crud->update('tp_emergency', 'emergency_id', $data, $getData['order_id']);
			if($crud == 0) {
				$head_code	= 200;
				$err_code 	= 205;
				$result 	= set_warning($err_code);
			}
			else {
				$head_code	= 200;
				$result = array(
					'status' 	=> '200',
					'message' 	=> 'Success',
					'data' 		=> $data
				);
			}	
		}
		else {
			$head_code	= 200;
			$err_code 	= 401;
			$result 	= set_warning($err_code);
		}
		
		json($result, $head_code);
	}
	
	/* new function */
	public function get_emergency_track() {
		$getData = (array) json_decode(file_get_contents('php://input'));
		$x_token = md5('order_id');
		
		if(checking_header($x_token)) {
			$head_code	= 200;
			
			$resultData = $this->m_api->getTrackEmergencyById($getData['order_id']);
			if(!empty($resultData)) {
				$result = array(
					'status' 	=> '200',
					'message' 	=> 'Success',
					'data' 		=> $resultData
				);
			} else {
				$result = array(
					'status' 	=> '208',
					'message' 	=> 'No Data ',
					'data' 		=> []
				);
			}
		}
		else {
			$head_code	= 200;
			$err_code 	= 401;
			$result 	= set_warning($err_code);
		}
		
		json($result, $head_code);
	}
	
	/* new function */
	public function get_emergency_track_detail() {
		$getData = (array) json_decode(file_get_contents('php://input'));
		$x_token = md5('order_id');
		
		if(checking_header($x_token)) {
			$head_code	= 200;
			$resultData  = $this->m_api->getIdentityTrackEmergencyById($getData['order_id']);
			if(!empty($resultData)) {
				$result = array(
					'status' 		=> '200',
					'message' 		=> 'Success',
					'data_driver' 	=> set_emergency_driver($getData['order_id']),
					'data_doctor' 	=> set_emergency_doctor($getData['order_id']),
					'data_nurse' 	=> set_emergency_nurse($getData['order_id']),
					'data' 			=> $resultData
				);
			} else {
				$result = array(
					'status' 		=> '208',
					'message' 		=> 'No Data ',
					'data_driver' 	=> [],
					'data_doctor' 	=> [],
					'data_nurse' 	=> [],
					'data' 			=> []
				);
			}
		}
		else {
			$head_code	= 200;
			$err_code 	= 401;
			$result 	= set_warning($err_code);
		}
		
		json($result, $head_code);
	}
	
	/* new function */
	public function get_emergency_tracking() {
		$getData = (array) json_decode(file_get_contents('php://input'));
		$x_token = md5('order_id');
		
		if(checking_header($x_token)) {
			$head_code	= 200;
			
			$resultData = $this->m_api->getTrackingEmergencyById($getData['order_id']);
			if(!empty($resultData)) {
				$result = array(
					'status' 	=> '200',
					'message' 	=> 'Success',
					'data' 		=> $resultData
				);
			} else {
				$result = array(
					'status' 	=> '208',
					'message' 	=> 'No Data ',
					'data' 		=> []
				);
			}
		}
		else {
			$head_code	= 200;
			$err_code 	= 401;
			$result 	= set_warning($err_code);
		}
		
		json($result, $head_code);
	}
	
	/* new function */
	public function get_emergency_detail() {
		$getData = (array) json_decode(file_get_contents('php://input'));
		$x_token = md5('order_id');
		
		if(checking_header($x_token)) {
			$head_code	= 200;
			$resultData  = $this->m_api->getIdentityEmergencyById($getData['order_id']);
			if(!empty($resultData)) {
				$result = array(
					'status' 		=> '200',
					'message' 		=> 'Success',
					'data_driver' 	=> set_emergency_driver($getData['order_id']),
					'data_doctor' 	=> set_emergency_doctor($getData['order_id']),
					'data_nurse' 	=> set_emergency_nurse($getData['order_id']),
					'data' 			=> $resultData
				);
			} else {
				$result = array(
					'status' 		=> '208',
					'message' 		=> 'No Data ',
					'data_driver' 	=> [],
					'data_doctor' 	=> [],
					'data_nurse' 	=> [],
					'data' 			=> []
				);
			}
		}
		else {
			$head_code	= 200;
			$err_code 	= 401;
			$result 	= set_warning($err_code);
		}
		
		json($result, $head_code);
	}
	
	/* new function */
	public function get_emergency_history() {
		$getData = (array) json_decode(file_get_contents('php://input'));
		$x_token = md5('user_id');
		
		if(checking_header($x_token)) {
			$head_code	= 200;
			
			$result1 = $this->m_api->getHistoryEmergencyByUserId($getData['user_id']);
			$result2 = $this->m_api->getHistoryNonEmergencyByUserId($getData['user_id']);
			
			$arr_status = array('Completed');
			$temp = array();
			if(!empty($result1)) {
				for($i=0; $i<count($result1); $i++) {
					if(in_array($result1[$i]['status'], $arr_status)) {
						$temp[] = array(
							'id' 					=> $result1[$i]['id'],
							'callreference' 		=> $result1[$i]['callreference'],
							'date'					=> $result1[$i]['date'],
							'time'					=> $result1[$i]['time'],
							'callername'			=> $result1[$i]['callername'],
							'callerphone'			=> $result1[$i]['callerphone'],
							'latitude'				=> $result1[$i]['latitude'],
							'longitude'				=> $result1[$i]['longitude'],
							'address'				=> $result1[$i]['address'],
							'patientname'			=> $result1[$i]['patientname'],
							'time_confirmed'		=> $result1[$i]['time_confirmed'],
							'time_waiting'			=> $result1[$i]['time_waiting'],
							'time_set_crew'			=> $result1[$i]['time_set_crew'],
							'time_to_patient'		=> $result1[$i]['time_to_patient'],
							'time_call_patient'		=> $result1[$i]['time_call_patient'],
							'time_arrived_patient'	=> $result1[$i]['time_arrived_patient'],
							'time_to_hospital'		=> $result1[$i]['time_to_hospital'],
							'time_arrived_hospital'	=> $result1[$i]['time_arrived_hospital'],
							'time_back_hospital'	=> $result1[$i]['time_back_hospital'],
							'time_complete'			=> $result1[$i]['time_complete'],
							'time_cancel'			=> $result1[$i]['time_cancel'],
							'reason_cancel'			=> $result1[$i]['reason_cancel'],
							'time_reject'			=> $result1[$i]['time_reject'],
							'reason_reject'			=> $result1[$i]['reason_reject'],
							'case_type'				=> $result1[$i]['case_type'],
							'ambulance'				=> $result1[$i]['ambulance'],
							'hospital'				=> $result1[$i]['hospital'],
							'status'				=> $result1[$i]['status'],
							'member_name'			=> $result1[$i]['member_name'],
							'member_phone'			=> $result1[$i]['member_phone'],
							'member_image'			=> $result1[$i]['member_image']
						);
					}
				}
			}
			
			if(!empty($result2)) {
				for($i=0; $i<count($result2); $i++) {
					if(in_array($result2[$i]['status'], $arr_status)) {
						$temp[] = array(
							'id' 					=> $result2[$i]['id'],
							'callreference' 		=> $result2[$i]['callreference'],
							'date'					=> $result2[$i]['date'],
							'time'					=> $result2[$i]['time'],
							'callername'			=> $result2[$i]['infoname'],
							'callerphone'			=> $result2[$i]['infophone'],
							'latitude'				=> $result2[$i]['from_latitude'],
							'longitude'				=> $result2[$i]['from_longitude'],
							'address'				=> $result2[$i]['from_address'],
							'patientname'			=> $result2[$i]['infoname'],
							'time_confirmed'		=> $result2[$i]['time_confirmed'],
							'time_waiting'			=> $result2[$i]['time_waiting'],
							'time_set_crew'			=> $result2[$i]['time_set_crew'],
							'time_to_patient'		=> $result2[$i]['time_to_patient'],
							'time_call_patient'		=> $result2[$i]['time_call_patient'],
							'time_arrived_patient'	=> $result2[$i]['time_arrived_patient'],
							'time_to_hospital'		=> $result2[$i]['time_to_hospital'],
							'time_arrived_hospital'	=> $result2[$i]['time_arrived_hospital'],
							'time_back_hospital'	=> $result2[$i]['time_back_hospital'],
							'time_complete'			=> $result2[$i]['time_complete'],
							'time_cancel'			=> $result2[$i]['time_cancel'],
							'reason_cancel'			=> $result2[$i]['reason_cancel'],
							'time_reject'			=> $result2[$i]['time_reject'],
							'reason_reject'			=> $result2[$i]['reason_reject'],
							'case_type'				=> $result2[$i]['case_type'],
							'ambulance'				=> $result2[$i]['ambulance'],
							'hospital'				=> $this->load->model('m_api')->get_name_hospital_by_id($this->load->model('m_api')->get_from_hospital_by_id($result2[$i]['id'])),
							'status'				=> $result2[$i]['status'],
							'member_name'			=> $result2[$i]['member_name'],
							'member_phone'			=> $result2[$i]['member_phone'],
							'member_image'			=> $result2[$i]['member_image']
						);
					}
				}
			}
			
			if(!empty($temp)) {
				// sort by array
				usort($temp, make_comparer(
					['date', SORT_ASC]
				));
				
				$rst = $temp;
				
				$result = array(
					'status' 	=> '200',
					'message' 	=> 'Success',
					'data' 		=> $rst
				);
			} else {
				$result = array(
					'status' 	=> '208',
					'message' 	=> 'No Data ',
					'data' 		=> []
				);
			}
		}
		else {
			$head_code	= 200;
			$err_code 	= 401;
			$result 	= set_warning($err_code);
		}
		
		json($result, $head_code);
	}
	
	/* new function */
	public function create_nonemergency() {
		$getData = (array) json_decode(file_get_contents('php://input'));
		$x_token = md5('user_id'.'booking_date'.'booking_time'.'patient_name'.'phone_number'.'latitude_from'.'longitude_from'.'address_from'.'latitude_to'.'longitude_to'.'address_to'.'category'.'sub_category'.'area');
		
		if(checking_header($x_token)) {
			if(($getData['user_id'] == null) || ($getData['booking_date'] == null) || ($getData['booking_time'] == null) || ($getData['patient_name'] == null) || ($getData['phone_number'] == null) || ($getData['latitude_from'] == null) || ($getData['longitude_from'] == null) || ($getData['address_from'] == null) || ($getData['latitude_to'] == null) || ($getData['longitude_to'] == null) || ($getData['address_to'] == null) || ($getData['category'] == null) || ($getData['sub_category'] == null) || ($getData['area'] == null)) {
				$head_code	= 200;
				$err_code 	= 402;
				$result 	= set_warning($err_code);
			}
			else {
				$date_booking  	= convert_to_ymd($getData['booking_date']);
				$time_booking  	= convert_to_h($getData['booking_time']);
				
				$time_booking  	= $time_booking .":00:00";
				$next_time 	= next_time($time_booking, 2);
				$prev_time 	= prev_time($time_booking, 2);
				
				$arr_booking = array();
				$booking_ambulance = $this->load->model('master/m_ambulance')->get_booking_by_area_date_time($getData['area'], $date_booking, $next_time, $prev_time);
				foreach($booking_ambulance as $row) {
					$arr_booking[] = $row->ambulance_id;
				}
				
				$arr_available = array();
				$result = $this->m_global->get_by_triple_id_order('tm_ambulance', 'ambulance_status', 0, 'is_login', 1, 'area_id', $getData['area'], 'ambulance_id', 'ASC');
				foreach($result as $row) {
					if (!in_array($row->ambulance_id, $arr_booking)) {
						$arr_available[] = array(
							'ambulance_id'		=> $row->ambulance_id,
							'hospital_code' 	=> $this->load->model('master/m_hospital')->get_code_by_id($row->hospital_id),
							'police_number'		=> $row->ambulance_police,
							'ambulance_status'	=> $row->ambulance_status
						);
					}
				}
				
				if(count($arr_available) > 0) {
					$data = array(
						'nonemergency_status'			=> 0,
						'nonemergency_callreference'	=> generate_call_references(),
						'nonemergency_date'				=> get_ymd(),
						'nonemergency_time'				=> get_his(),
						'nonemergency_infoname' 		=> $getData['patient_name'],
						'nonemergency_infophone' 		=> $getData['phone_number'],
						'nonemergency_infodate' 		=> convert_to_ymd($getData['booking_date']),
						'nonemergency_infotime' 		=> convert_to_hi($getData['booking_time']).":00",
						'nonemergency_fromlatitude' 	=> $getData['latitude_from'],
						'nonemergency_fromlongitude'	=> $getData['longitude_from'],
						'nonemergency_fromstreet' 		=> $getData['address_from'],
						'nonemergency_fromsearch' 		=> $getData['address_from'],
						'nonemergency_tolatitude' 		=> $getData['latitude_to'],
						'nonemergency_tolongitude'		=> $getData['longitude_to'],
						'nonemergency_tostreet' 		=> $getData['address_to'],
						'nonemergency_tosearch' 		=> $getData['address_to'],
						'category_id' 					=> $getData['category'],
						'subcategory_id' 				=> $getData['sub_category'],
						'nonemergency_from' 			=> 1,
						'nonemergency_to' 				=> 1,
						'nonemergency_fromarea' 		=> $getData['area'],
						'member_id' 					=> $getData['user_id']
					);
					
					$crud = $this->m_crud->insert_id('tp_nonemergency', $data);
					if($crud == 0) {
						$head_code	= 200;
						$err_code 	= 205;
						$result 	= set_warning($err_code);
					}
					else {
						$head_code	= 200;
						$resultData = $this->m_api->getTrackNonEmergencyById($crud);
						if(!empty($resultData)) {
							$result = array(
								'status' 	=> '200',
								'message' 	=> 'Success',
								'data' 		=> $resultData
							);
						} else {
							$result = array(
								'status' 	=> '208',
								'message' 	=> 'No Data ',
								'data' 		=> []
							);
						}
					}
				}
				else {
					$head_code	= 200;
					$err_code 	= 202;
					$result 	= set_warning($err_code);	
				}
			}
		}
		else {
			$head_code	= 200;
			$err_code 	= 401;
			$result 	= set_warning($err_code);
		}
		
		json($result, $head_code);
	}
	
	/* new function */
	public function update_nonemergency() {
		$getData = (array) json_decode(file_get_contents('php://input'));
		$x_token = md5('order_id'.'booking_date'.'booking_time'.'latitude_from'.'longitude_from'.'address_from'.'latitude_to'.'longitude_to'.'address_to');
		
		if(checking_header($x_token)) {
			if(($getData['order_id'] == null) || ($getData['booking_date'] == null) || ($getData['booking_time'] == null) || ($getData['latitude_from'] == null) || ($getData['longitude_from'] == null) || ($getData['address_from'] == null) || ($getData['latitude_to'] == null) || ($getData['longitude_to'] == null) || ($getData['address_to'] == null)) {
				$head_code	= 200;
				$err_code 	= 402;
				$result 	= set_warning($err_code);
			}
			else {
				$area_id = $this->m_api->get_area_from_by_nonemergency($getData['order_id']);
				
				$date_booking  	= convert_to_ymd($getData['booking_date']);
				$time_booking  	= convert_to_h($getData['booking_time']);
				
				$time_booking  	= $time_booking .":00:00";
				$next_time 	= next_time($time_booking, 2);
				$prev_time 	= prev_time($time_booking, 2);
				
				$arr_booking = array();
				$booking_ambulance = $this->load->model('master/m_ambulance')->get_booking_by_area_date_time($area_id, $date_booking, $next_time, $prev_time);
				foreach($booking_ambulance as $row) {
					$arr_booking[] = $row->ambulance_id;
				}
				
				$arr_available = array();
				$result = $this->m_global->get_by_triple_id_order('tm_ambulance', 'ambulance_status', 0, 'is_login', 1, 'area_id', $area_id, 'ambulance_id', 'ASC');
				foreach($result as $row) {
					if (!in_array($row->ambulance_id, $arr_booking)) {
						$arr_available[] = array(
							'ambulance_id'		=> $row->ambulance_id,
							'hospital_code' 	=> $this->load->model('master/m_hospital')->get_code_by_id($row->hospital_id),
							'police_number'		=> $row->ambulance_police,
							'ambulance_status'	=> $row->ambulance_status
						);
					}
				}
				
				if(count($arr_available) > 0) {
					// delete booking ambulance
					$booking_ambulance_id = $this->load->model('master/m_ambulance')->get_booking_by_nonemergency($getData['order_id']);
					$this->m_crud->delete('tp_bookingambulance', 'nonemergency_id', $booking_ambulance_id);
					
					$data = array(
						'nonemergency_infodate' 		=> convert_to_ymd($getData['booking_date']),
						'nonemergency_infotime' 		=> convert_to_hi($getData['booking_time']).":00",
						'nonemergency_fromlatitude' 	=> $getData['latitude_from'],
						'nonemergency_fromlongitude'	=> $getData['longitude_from'],
						'nonemergency_fromstreet' 		=> $getData['address_from'],
						'nonemergency_fromsearch' 		=> $getData['address_from'],
						'nonemergency_tolatitude' 		=> $getData['latitude_to'],
						'nonemergency_tolongitude'		=> $getData['longitude_to'],
						'nonemergency_tostreet' 		=> $getData['address_to'],
						'nonemergency_tosearch' 		=> $getData['address_to'],
						'nonemergency_from' 			=> 1,
						'nonemergency_to' 				=> 1
					);
					
					$crud = $this->m_crud->update('tp_nonemergency', 'nonemergency_id', $data, $getData['order_id']);
					if($crud == 0) {
						$head_code	= 200;
						$err_code 	= 205;
						$result 	= set_warning($err_code);
					}
					else {
						$head_code	= 200;
						$resultData = $this->m_api->getTrackNonEmergencyById($getData['order_id']);
						if(!empty($resultData)) {
							$result = array(
								'status' 	=> '200',
								'message' 	=> 'Success',
								'data' 		=> $resultData
							);
						} else {
							$result = array(
								'status' 	=> '208',
								'message' 	=> 'No Data ',
								'data' 		=> []
							);
						}
					}
				}
				else {
					$head_code	= 200;
					$err_code 	= 202;
					$result 	= set_warning($err_code);	
				}
			}
		}
		else {
			$head_code	= 200;
			$err_code 	= 401;
			$result 	= set_warning($err_code);
		}
		
		json($result, $head_code);
	}
	
	/* new function */
	public function cancel_nonemergency() {
		$getData = (array) json_decode(file_get_contents('php://input'));
		$x_token = md5('order_id'.'reason');
		
		if(checking_header($x_token)) {
			$gekStatusOrder = $this->m_api->get_status_nonemergency($getData['order_id']);
			if ($gekStatusOrder == 5) {
				$head_code	= 200;
				$err_code 	= 506;
				$result 	= set_warning($err_code);
			} 
			else {
				// update data
				$data = array(
					'reason_cancel'			=> $getData['reason'],
					'time_cancel'			=> get_ymdhis(),
					'nonemergency_status' 	=> 2
				);
					
				$head_code	= 200;
				$crud = $this->m_crud->update('tp_nonemergency', 'nonemergency_id', $data, $getData['order_id']);
				if($crud != 0) {
					$resultData = $this->m_api->getTrackNonEmergencyById($getData['order_id']);
					$result = array(
						'status' 	=> '200',
						'message' 	=> 'Update success',
						'data' 		=> $resultData
					);
				} 
				else {
					$result = array(
						'status' 	=> '207',
						'message' 	=> 'No Update ',
						'data' 		=> []
					);
				}
			}
		}
		else {
			$head_code	= 200;
			$err_code 	= 401;
			$result 	= set_warning($err_code);
		}
		
		json($result, $head_code);
	}
	
	/* new function */
	public function create_nonemergency_rating() {
		$getData = (array) json_decode(file_get_contents('php://input'));
		$x_token = md5('order_id'.'rating'.'comment');
		
		if(checking_header($x_token)) {
			$data = array(
				'nonemergency_rating'	=> $getData['rating'],
				'nonemergency_comment'	=> $getData['comment'],
				'time_rating'			=> get_ymdhis()
			);
			
			$crud = $this->m_crud->update('tp_nonemergency', 'nonemergency_id', $data, $getData['order_id']);
			if($crud == 0) {
				$head_code	= 200;
				$err_code 	= 205;
				$result 	= set_warning($err_code);
			}
			else {
				$head_code	= 200;
				$result = array(
					'status' 	=> '200',
					'message' 	=> 'Success',
					'data' 		=> $data
				);
			}	
		}
		else {
			$head_code	= 200;
			$err_code 	= 401;
			$result 	= set_warning($err_code);
		}
		
		json($result, $head_code);
	}
	
	/* new function */
	public function get_nonemergency_track() {
		$getData = (array) json_decode(file_get_contents('php://input'));
		$x_token = md5('order_id');
		
		if(checking_header($x_token)) {
			$head_code	= 200;
			
			$resultData = $this->m_api->getTrackNonEmergencyById($getData['order_id']);
			if(!empty($resultData)) {
				$result = array(
					'status' 	=> '200',
					'message' 	=> 'Success',
					'data' 		=> $resultData
				);
			} else {
				$result = array(
					'status' 	=> '208',
					'message' 	=> 'No Data ',
					'data' 		=> []
				);
			}
		}
		else {
			$head_code	= 200;
			$err_code 	= 401;
			$result 	= set_warning($err_code);
		}
		
		json($result, $head_code);
	}
	
	/* new function */
	public function get_nonemergency_track_detail() {
		$getData = (array) json_decode(file_get_contents('php://input'));
		$x_token = md5('order_id');
		
		if(checking_header($x_token)) {
			$head_code	= 200;
			$resultData  = $this->m_api->getTrackNonEmergencyById($getData['order_id']);
			if(!empty($resultData)) {
				$result = array(
					'status' 		=> '200',
					'message' 		=> 'Success',
					'data_driver' 	=> set_nonemergency_driver($getData['order_id']),
					'data_doctor' 	=> set_nonemergency_doctor($getData['order_id']),
					'data_nurse' 	=> set_nonemergency_nurse($getData['order_id']),
					'data' 			=> $resultData
				);
			} else {
				$result = array(
					'status' 		=> '208',
					'message' 		=> 'No Data ',
					'data_driver' 	=> [],
					'data_doctor' 	=> [],
					'data_nurse' 	=> [],
					'data' 			=> []
				);
			}
		}
		else {
			$head_code	= 200;
			$err_code 	= 401;
			$result 	= set_warning($err_code);
		}
		
		json($result, $head_code);
	}
	
	/* new function */
	public function get_nonemergency_tracking() {
		$getData = (array) json_decode(file_get_contents('php://input'));
		$x_token = md5('order_id');
		
		if(checking_header($x_token)) {
			$head_code	= 200;
			
			$resultData = $this->m_api->getTrackingNonEmergencyById($getData['order_id']);
			if(!empty($resultData)) {
				$result = array(
					'status' 	=> '200',
					'message' 	=> 'Success',
					'data' 		=> $resultData
				);
			} else {
				$result = array(
					'status' 	=> '208',
					'message' 	=> 'No Data ',
					'data' 		=> []
				);
			}
		}
		else {
			$head_code	= 200;
			$err_code 	= 401;
			$result 	= set_warning($err_code);
		}
		
		json($result, $head_code);
	}
	
	/* new function */
	public function get_nonemergency_detail() {
		$getData = (array) json_decode(file_get_contents('php://input'));
		$x_token = md5('order_id');
		
		if(checking_header($x_token)) {
			$head_code	= 200;
			$resultData  = $this->m_api->getIdentityNonEmergencyById($getData['order_id']);
			if(!empty($resultData)) {
				$result = array(
					'status' 		=> '200',
					'message' 		=> 'Success',
					'data_driver' 	=> set_nonemergency_driver($getData['order_id']),
					'data_doctor' 	=> set_nonemergency_doctor($getData['order_id']),
					'data_nurse' 	=> set_nonemergency_nurse($getData['order_id']),
					'data' 			=> $resultData
				);
			} else {
				$result = array(
					'status' 		=> '208',
					'message' 		=> 'No Data ',
					'data_driver' 	=> [],
					'data_doctor' 	=> [],
					'data_nurse' 	=> [],
					'data' 			=> []
				);
			}
		}
		else {
			$head_code	= 200;
			$err_code 	= 401;
			$result 	= set_warning($err_code);
		}
		
		json($result, $head_code);
	}
	
	/* new function */
	public function get_nonemergency_history() {
		$getData = (array) json_decode(file_get_contents('php://input'));
		$x_token = md5('user_id');
		
		if(checking_header($x_token)) {
			$head_code	= 200;
			
			$rst = $this->m_api->getHistoryNonEmergencyByUserId($getData['user_id']);
			
			$arr_status = array('Booked', 'Confirmed', 'Already', 'Accept order', 'Set Crew', 'Go to patient', 'Call patient', 'Arrive at location', 'Go to hospitals');
			$temp = array();
			if(!empty($rst)) {
				for($i=0; $i<count($rst); $i++) {
					if(in_array($rst[$i]['status'], $arr_status)) {
						$temp[] = array(
							'id' 					=> $rst[$i]['id'],
							'callreference' 		=> $rst[$i]['callreference'],
							'date'					=> $rst[$i]['date'],
							'time'					=> $rst[$i]['time'],
							'infoname'				=> $rst[$i]['infoname'],
							'infophone'				=> $rst[$i]['infophone'],
							'infodate'				=> $rst[$i]['infodate'],
							'infotime'				=> $rst[$i]['infotime'],
							'infodiagnosis'			=> $rst[$i]['infodiagnosis'],
							'infoconsultant'		=> $rst[$i]['infoconsultant'],
							'inforeason'			=> $rst[$i]['inforeason'],	
							'requestname'			=> $rst[$i]['requestname'],
							'requestdepartment'		=> $rst[$i]['requestdepartment'],
							'requesttittle'			=> $rst[$i]['requesttittle'],
							'from_latitude'			=> $rst[$i]['from_latitude'],
							'from_longitude'		=> $rst[$i]['from_longitude'],
							'from_address'			=> $rst[$i]['from_address'],
							'to_latitude'			=> $rst[$i]['to_latitude'],
							'to_longitude'			=> $rst[$i]['to_longitude'],
							'to_address'			=> $rst[$i]['to_address'],
							'time_confirmed'		=> $rst[$i]['time_confirmed'],
							'time_waiting'			=> $rst[$i]['time_waiting'],
							'time_set_crew'			=> $rst[$i]['time_set_crew'],
							'time_to_patient'		=> $rst[$i]['time_to_patient'],
							'time_call_patient'		=> $rst[$i]['time_call_patient'],
							'time_arrived_patient'	=> $rst[$i]['time_arrived_patient'],
							'time_to_hospital'		=> $rst[$i]['time_to_hospital'],
							'time_arrived_hospital'	=> $rst[$i]['time_arrived_hospital'],
							'time_back_hospital'	=> $rst[$i]['time_back_hospital'],
							'time_complete'			=> $rst[$i]['time_complete'],
							'time_cancel'			=> $rst[$i]['time_cancel'],
							'reason_cancel'			=> $rst[$i]['reason_cancel'],
							'time_reject'			=> $rst[$i]['time_reject'],
							'reason_reject'			=> $rst[$i]['reason_reject'],
							'case_noncategory'		=> $rst[$i]['case_noncategory'],
							'case_type'				=> $rst[$i]['case_type'],
							'ambulance'				=> $rst[$i]['ambulance'],
							'status'				=> $rst[$i]['status'],
							'member_name'			=> $rst[$i]['member_name'],
							'member_phone'			=> $rst[$i]['member_phone'],
							'member_image'			=> $rst[$i]['member_image']
						);
					}
				}
			}
			
			if(!empty($rst)) {
				// sort by array
				usort($temp, make_comparer(
					['date', SORT_ASC]
				));
				
				$rst = $temp;
				
				$result = array(
					'status' 	=> '200',
					'message' 	=> 'Success',
					'data' 		=> $rst
				);
			} else {
				$result = array(
					'status' 	=> '208',
					'message' 	=> 'No Data ',
					'data' 		=> []
				);
			}
		}
		else {
			$head_code	= 200;
			$err_code 	= 401;
			$result 	= set_warning($err_code);
		}
		
		json($result, $head_code);
	}
	
	/* new function */
	public function get_nonemergency_history_by_id() {
		$getData = (array) json_decode(file_get_contents('php://input'));
		$x_token = md5('order_id');
		
		if(checking_header($x_token)) {
			$head_code	= 200;
			
			$rst = $this->m_api->getHistoryNonEmergencyByOrderId($getData['order_id']);
			
			$arr_status = array('Booked', 'Confirmed', 'Already', 'Accept order', 'Set Crew', 'Go to patient', 'Call patient', 'Arrive at location', 'Go to hospitals');
			$temp = array();
			if(!empty($rst)) {
				for($i=0; $i<count($rst); $i++) {
					if(in_array($rst[$i]['status'], $arr_status)) {
						$temp[] = array(
							'id' 					=> $rst[$i]['id'],
							'callreference' 		=> $rst[$i]['callreference'],
							'date'					=> $rst[$i]['date'],
							'time'					=> $rst[$i]['time'],
							'infoname'				=> $rst[$i]['infoname'],
							'infophone'				=> $rst[$i]['infophone'],
							'infodate'				=> $rst[$i]['infodate'],
							'infotime'				=> $rst[$i]['infotime'],
							'infodiagnosis'			=> $rst[$i]['infodiagnosis'],
							'infoconsultant'		=> $rst[$i]['infoconsultant'],
							'inforeason'			=> $rst[$i]['inforeason'],	
							'requestname'			=> $rst[$i]['requestname'],
							'requestdepartment'		=> $rst[$i]['requestdepartment'],
							'requesttittle'			=> $rst[$i]['requesttittle'],
							'from_latitude'			=> $rst[$i]['from_latitude'],
							'from_longitude'		=> $rst[$i]['from_longitude'],
							'from_address'			=> $rst[$i]['from_address'],
							'to_latitude'			=> $rst[$i]['to_latitude'],
							'to_longitude'			=> $rst[$i]['to_longitude'],
							'to_address'			=> $rst[$i]['to_address'],
							'time_confirmed'		=> $rst[$i]['time_confirmed'],
							'time_waiting'			=> $rst[$i]['time_waiting'],
							'time_set_crew'			=> $rst[$i]['time_set_crew'],
							'time_to_patient'		=> $rst[$i]['time_to_patient'],
							'time_call_patient'		=> $rst[$i]['time_call_patient'],
							'time_arrived_patient'	=> $rst[$i]['time_arrived_patient'],
							'time_to_hospital'		=> $rst[$i]['time_to_hospital'],
							'time_arrived_hospital'	=> $rst[$i]['time_arrived_hospital'],
							'time_back_hospital'	=> $rst[$i]['time_back_hospital'],
							'time_complete'			=> $rst[$i]['time_complete'],
							'time_cancel'			=> $rst[$i]['time_cancel'],
							'reason_cancel'			=> $rst[$i]['reason_cancel'],
							'time_reject'			=> $rst[$i]['time_reject'],
							'reason_reject'			=> $rst[$i]['reason_reject'],
							'case_noncategory'		=> $rst[$i]['case_noncategory'],
							'case_type'				=> $rst[$i]['case_type'],
							'ambulance'				=> $rst[$i]['ambulance'],
							'status'				=> $rst[$i]['status'],
							'member_name'			=> $rst[$i]['member_name'],
							'member_phone'			=> $rst[$i]['member_phone'],
							'member_image'			=> $rst[$i]['member_image']
						);
					}
				}
			}
			
			if(!empty($rst)) {
				// sort by array
				usort($temp, make_comparer(
					['date', SORT_ASC]
				));
				
				$rst = $temp;
				
				$result = array(
					'status' 	=> '200',
					'message' 	=> 'Success',
					'data' 		=> $rst
				);
			} else {
				$result = array(
					'status' 	=> '208',
					'message' 	=> 'No Data ',
					'data' 		=> []
				);
			}
		}
		else {
			$head_code	= 200;
			$err_code 	= 401;
			$result 	= set_warning($err_code);
		}
		
		json($result, $head_code);
	}
	
	/* new function */
	public function login_ambulance() {
		$getData = (array) json_decode(file_get_contents('php://input'));
		$x_token = md5('username'.'password'.'device_token');
		
		if(checking_header($x_token)) {
			// update device
			$this->m_global->set_status('tm_ambulance', 'ambulance_username', $getData['username'], 'device_token', $getData['device_token']);
				
			// update is login
			$this->m_global->set_status('tm_ambulance', 'ambulance_username', $getData['username'], 'is_login', 1);
			$query = $this->m_api->login_ambulance($getData['username'], $getData['password']);
			if ($query['response'] == '1') {
				$head_code	= 200;
				$result = array(
					'status' 		=> '200',
					'message' 		=> 'success',
					'device_token' 	=> $getData['device_token'],
					'data' 			=> $query['data']
				);
			} 
			else {
				$head_code	= 200;
				$err_code 	= 209;
				$result 	= set_warning($err_code);
			}
		}
		else {
			$head_code	= 200;
			$err_code 	= 401;
			$result 	= set_warning($err_code);
		}
		
		json($result, $head_code);
	}
	
	/* new function */
	public function logout_ambulance() {
		$getData = (array) json_decode(file_get_contents('php://input'));
		$x_token = md5('ambulance_id');
		
		if(checking_header($x_token)) {
			// update is login
			$head_code	= 200;
			$updateData = $this->m_global->set_status('tm_ambulance', 'ambulance_id', $getData['ambulance_id'], 'is_login', 0);
			if($updateData == 1) {
				// update device
				$this->m_global->set_status('tm_ambulance', 'ambulance_id', $getData['ambulance_id'], 'device_token', "");
				
				$head_code	= 200;
				$err_code 	= 300;
				$result 	= set_warning($err_code);
			} 
			else {
				$head_code	= 200;
				$err_code 	= 306;
				$result 	= set_warning($err_code);
			}
		}
		else {
			$head_code	= 200;
			$err_code 	= 401;
			$result 	= set_warning($err_code);
		}
		
		json($result, $head_code);
	}
	
	public function update_ambulance_status() {
		$getData = (array) json_decode(file_get_contents('php://input'));
		$x_token = md5('ambulance_id'.'status');
		
		if(checking_header($x_token)) {
			$head_code	= 200;
			$updateData = $this->m_global->set_status('tm_ambulance', 'ambulance_id', $getData['ambulance_id'], 'ambulance_status', $getData['status']);
			if($updateData == 1) {
				$resultData = $this->m_api->getIdentityAmbulanceById($getData['ambulance_id']);
				$result = array(
					'status' 	=> '200',
					'message' 	=> 'Update success',
					'data' 		=> $resultData
				);
			} 
			else {
				$result = array(
					'status' 	=> '207',
					'message' 	=> 'No Update ',
					'data' 		=> []
				);
			}
		}
		else {
			$head_code	= 200;
			$err_code 	= 401;
			$result 	= set_warning($err_code);
		}
		
		json($result, $head_code);
	}
	
	/* new function */
	public function get_crew() {
		$getData = (array) json_decode(file_get_contents('php://input'));
		$x_token = md5('ambulance_id'.'date');
		
		if(checking_header($x_token)) {
			$head_code	= 200;
			
			$time = get_his();
			$hospital = $this->m_api->get_hospital_by_ambulance($getData['ambulance_id']);
			$resultData = $this->m_global->get_by_triple_id_order('tp_workday', 'workday_status', 1, 'hospital_id', $hospital, 'workday_date', convert_to_ymd($getData['date']), 'workday_id', 'DESC');
			if(!empty($resultData)) {
				$arr_driver = array();
				$arr_doctor = array();
				$arr_nurse = array();
				
				foreach($resultData as $row) {
					$detail_roster = $this->m_global->get_by_id('tm_workroster', 'workroster_id', $row->workroster_id);
					foreach($detail_roster as $rws) {
						$start 	= $rws->workroster_start;
						$end 	= $rws->workroster_end;
						
						if((strtotime($time ) > strtotime($start )) && (strtotime($time ) < strtotime($end ))) {
							$ls_driver = $this->m_global->get_by_id_order('td_workdriver', 'workday_id', $row->workday_id, 'id', 'ASC');
							foreach($ls_driver as $rows) {
								$arr_driver[] = array(
									'driver_id' => $rows->driver_id,
									'driver' => $this->m_api->get_driver_name_by_id($rows->driver_id)
								);
							}
							
							$ls_doctor = $this->m_global->get_by_id_order('td_workdoctor', 'workday_id', $row->workday_id, 'id', 'ASC');
							foreach($ls_doctor as $rows) {
								$arr_doctor[] = array(
									'doctor_id' => $rows->doctor_id,
									'doctor' => $this->m_api->get_doctor_name_by_id($rows->doctor_id)
								);
							}
							
							$ls_nurse = $this->m_global->get_by_id_order('td_worknurse', 'workday_id', $row->workday_id, 'id', 'ASC');
							foreach($ls_nurse as $rows) {
								$arr_nurse[] = array(
									'nurse_id' => $rows->nurse_id,
									'nurse' => $this->m_api->get_nurse_name_by_id($rows->nurse_id)
								);
							}
						}
					}
				}
				
				$result = array(
					'status' 		=> '200',
					'message' 		=> 'Success',
					'data_driver' 	=> $arr_driver,
					'data_doctor' 	=> $arr_doctor,
					'data_nurse' 	=> $arr_nurse,
					'data' 			=> $resultData
				);
			} 
			else {
				$result = array(
					'status' 		=> '208',
					'message' 		=> 'No Data ',
					'data_driver' 	=> [],
					'data_doctor' 	=> [],
					'data_nurse' 	=> [],
					'data' 			=> []
				);
			}
		}
		else {
			$head_code	= 200;
			$err_code 	= 401;
			$result 	= set_warning($err_code);
		}
		
		json($result, $head_code);
	}
	
	/* new function */
	public function accept_emergency() {
		$getData = (array) json_decode(file_get_contents('php://input'));
		$x_token = md5('order_id'.'ambulance_id'.'latitude'.'longitude'.'marker_rotation');
		
		if(checking_header($x_token)) {
			$status = $this->m_api->get_status_emergency($getData['order_id']);
			if($status == 3) {
				$head_code	= 200;
				$err_code 	= 302;
				$result 	= set_warning($err_code);
			}	
			else {
				$data = array(
					'time_waiting' 		=> get_ymdhis(),
					'emergency_status' 	=> 5
				);
				
				$updateData = $this->m_crud->update('tp_emergency', 'emergency_id', $data, $getData['order_id']);
				if($updateData == 1) {
					// update ambulance
					$data_ambulance = array(
						'ambulance_tracklatitude' 	=> $getData['latitude'],
						'ambulance_tracklongitude' 	=> $getData['longitude'],
						'ambulance_trackrotation' 	=> $getData['marker_rotation'],
						'ambulance_trackdatetime' 	=> get_ymdhis()
					);
					
					$this->m_crud->update('tm_ambulance', 'ambulance_id', $data_ambulance, $getData['ambulance_id']);
					
					// current location ambulance
					$from_latitude 	= $getData['latitude'];
					$from_longitude = $getData['longitude'];
					
					// update distance eta to patient
					$to_latitude 	= $this->m_api->get_latitude_emergeny_by_id($getData['order_id']);
					$to_longitude 	= $this->m_api->get_longitude_emergeny_by_id($getData['order_id']); 
					
					$distance_eta = get_distance_eta($from_latitude, $from_longitude, $to_latitude, $to_longitude);
					update_distance_eta_ambulance($getData['ambulance_id'], $distance_eta);
					
					// update distance eta to forward
					$forward_id					= $this->m_api->get_forward_by_emergency($getData['order_id']);
					$hospital_forward			= $this->m_api->get_hospital_by_forward($forward_id);
					$hospital_forward_latitude 	= $this->m_api->get_latitude_hospital_by_id($hospital_forward);
					$hospital_forward_longitude = $this->m_api->get_longitude_hospital_by_id($hospital_forward); 
					
					$distance_forward = get_distance_eta($to_latitude, $to_longitude, $hospital_forward_latitude, $hospital_forward_longitude);
					
					// update distance eta to hospital
					$hospital_back				= $this->m_api->get_hospital_by_ambulance($getData['ambulance_id']);		
					$hospital_back_latitude 	= $this->m_api->get_latitude_hospital_by_id($hospital_back);
					$hospital_back_longitude 	= $this->m_api->get_longitude_hospital_by_id($hospital_back); 
					
					$distance_back = get_distance_eta($hospital_forward_latitude, $hospital_forward_longitude, $hospital_back_latitude, $hospital_back_longitude);
					update_distance_eta_hospital_ambulance($getData['ambulance_id'], $distance_eta, $distance_forward, $distance_back);
					
					$head_code	= 200;
					$resultData = $this->m_api->getAcceptEmergencyByOrderId($getData['order_id']);
					$result = array(
						'status' 	=> '200',
						'message' 	=> 'Update success',
						'data' 		=> $resultData
					);
					
					// send FCM
					$member_id = $this->m_api->get_member_by_emergency($getData['order_id']);
					$device = $this->load->model('member/m_member')->get_device_by_id($member_id);
					if($device != "") {
						$token[] = array();
						$token[] = $device;
						
						$title 		= "";
						$message 	= get_notify(5);
						
						// send notif
						send_firebase_datanotification($token, $title, $message, $getData['order_id'], NULL, 0, '.activity.OrderActivity');
					}
				} 
				else {
					$result = array(
						'status' 	=> '207',
						'message' 	=> 'No Update ',
						'data' 		=> []
					);
				}		
			}
		}
		else {
			$head_code	= 200;
			$err_code 	= 401;
			$result 	= set_warning($err_code);
		}
		
		json($result, $head_code);
	}
	
	/* new function */
	public function set_emergency_crew() {
		$id 	= $this->input->post('order_id');
		$driver = $this->input->post('driver');
		$doctor = $this->input->post('doctor');
		$nurse 	= $this->input->post('nurse');
		
		// insert driver
		$data_driver = array();
		if(!empty($driver)) {
			foreach($driver as $row) {
				if($row != "") {
					$data_driver = array(
						'driver_id'		=> $row,
						'emergency_id' 	=> $id
					);
					
					$this->m_crud->insert('td_emergencydriver', $data_driver);
				}
			}
		}
			
		// insert doctor
		$data_doctor= array();
		if(!empty($doctor)) {
			foreach($doctor as $row) {
				if($row != "") {
					$data_doctor = array(
						'doctor_id'		=> $row,
						'emergency_id' 	=> $id
					);
					
					$this->m_crud->insert('td_emergencydoctor', $data_doctor);
				}
			}
		}

		// insert nurse
		$data_nurse = array();
		if(!empty($nurse)) {
			foreach($nurse as $row) {
				if($row != "") {
					$data_nurse = array(
						'nurse_id'		=> $row,
						'emergency_id' 	=> $id
					);
					
					$this->m_crud->insert('td_emergencynurse', $data_nurse);
				}
			}
		}	
				
		$data = array(
			'time_set_crew' 	=> get_ymdhis(),
			'emergency_status' 	=> 4
		);
                
                
					
		$updateData = $this->m_crud->update('tp_emergency', 'emergency_id', $data, $id);
		$head_code	= 200;
		if($updateData == 1) {
			$resultData = $this->m_api->getIdentityEmergencyById($id);
			$result = array(
				'status' 		=> '200',
				'message' 		=> 'Update success',
				'data_driver' 	=> set_emergency_driver($id),
				'data_doctor' 	=> set_emergency_doctor($id),
				'data_nurse' 	=> set_emergency_nurse($id),
				'data' 			=> $resultData
			);
		} 
		else {
			$result = array(
				'status' 		=> '207',
				'message' 		=> 'No Update ',
				'data_driver' 	=> [],
				'data_doctor' 	=> [],
				'data_nurse' 	=> [],
				'data' 			=> []
			);
		}

		json($result, $head_code);
	}
	
	/* new function */
	public function update_emergency_ambulance_location() {
		$getData = (array) json_decode(file_get_contents('php://input'));
		$x_token = md5('order_id'.'ambulance_id'.'latitude'.'longitude'.'marker_rotation');
		
		if(checking_header($x_token)) {
			if(($getData['ambulance_id'] == null) || ($getData['latitude'] == null) || ($getData['longitude'] == null) || ($getData['marker_rotation'] == null)) {
				$head_code	= 200;
				$err_code 	= 402;
				$result 	= set_warning($err_code);
			}
			else {
				$data = array(
					'ambulance_tracklatitude' 	=> $getData['latitude'],
					'ambulance_tracklongitude' 	=> $getData['longitude'],
					'ambulance_trackrotation' 	=> $getData['marker_rotation'],
					'ambulance_trackdatetime' 	=> get_ymdhis()
				);
				
				$crud = $this->m_crud->update('tm_ambulance', 'ambulance_id', $data, $getData['ambulance_id']);
				if($crud == 0) {
					$head_code	= 200;
					$err_code 	= 205;
					$result 	= set_warning($err_code);
				}
				else {
					// current location ambulance
					$from_latitude 	= $getData['latitude'];
					$from_longitude = $getData['longitude'];
					
					$forward_id			= $this->m_api->get_forward_by_emergency($getData['order_id']);
					$hospital_forward	= $this->m_api->get_hospital_by_forward($forward_id);
					$hospital_back		= $this->m_api->get_hospital_by_ambulance($getData['ambulance_id']);	
					
					$status = $this->m_api->get_emergeny_status_by_id($getData['order_id']);
					if($status == 6) {
						$to_latitude 	= $this->m_api->get_latitude_emergeny_by_id($getData['order_id']);
						$to_longitude 	= $this->m_api->get_longitude_emergeny_by_id($getData['order_id']); 
					}
					else if($status == 4) {
						$to_latitude 	= $this->m_api->get_latitude_emergeny_by_id($getData['order_id']);
						$to_longitude 	= $this->m_api->get_longitude_emergeny_by_id($getData['order_id']); 
					}
					else if($status == 11) {
						$to_latitude 	= $this->m_api->get_latitude_emergeny_by_id($getData['order_id']);
						$to_longitude 	= $this->m_api->get_longitude_emergeny_by_id($getData['order_id']); 
					}
					else if($status == 12) {
						$to_latitude 	= $this->m_api->get_latitude_emergeny_by_id($getData['order_id']);
						$to_longitude 	= $this->m_api->get_longitude_emergeny_by_id($getData['order_id']); 
					}
					else if($status == 7) {
						$to_latitude 	= $this->m_api->get_latitude_hospital_by_id($hospital_forward);
						$to_longitude 	= $this->m_api->get_longitude_hospital_by_id($hospital_forward); 
					}
					else if($status == 13) {
						$to_latitude 	= $this->m_api->get_latitude_hospital_by_id($hospital_forward);
						$to_longitude 	= $this->m_api->get_longitude_hospital_by_id($hospital_forward); 
					}
					else {
						$to_latitude 	= $this->m_api->get_latitude_hospital_by_id($hospital_back);
						$to_longitude 	= $this->m_api->get_longitude_hospital_by_id($hospital_back); 
					}
					
					$distance_eta = get_distance_eta($from_latitude, $from_longitude, $to_latitude, $to_longitude);
					update_distance_eta_ambulance($getData['ambulance_id'], $distance_eta);
					
					// update distance eta to forward
					$hospital_forward_latitude 	= $this->m_api->get_latitude_hospital_by_id($hospital_forward);
					$hospital_forward_longitude = $this->m_api->get_longitude_hospital_by_id($hospital_forward); 
					
					$distance_forward = get_distance_eta($to_latitude, $to_longitude, $hospital_forward_latitude, $hospital_forward_longitude);
					
					// update distance eta to hospital	
					$hospital_back_latitude 	= $this->m_api->get_latitude_hospital_by_id($hospital_back);
					$hospital_back_longitude 	= $this->m_api->get_longitude_hospital_by_id($hospital_back); 
					
					$distance_back = get_distance_eta($hospital_forward_latitude, $hospital_forward_longitude, $hospital_back_latitude, $hospital_back_longitude);
					update_distance_eta_hospital_ambulance($getData['ambulance_id'], $distance_eta, $distance_forward, $distance_back);
					
					$head_code	= 200;
					$resultData = $this->m_api->getIdentityAmbulanceById($getData['ambulance_id']);
					
					// push array
					$rst = array();
					foreach($resultData as $row) {
						$rst = array(
							"id" 							=> $resultData['id'],
							"no" 							=> $resultData['no'],
							"plat" 							=> $resultData['plat'],
							"datetime" 						=> $resultData['datetime'],
							"latitude" 						=> $resultData['latitude'],
							"longitude" 					=> $resultData['longitude'],
							"marker_rotation" 				=> $resultData['marker_rotation'],
							"distance"  					=> $resultData['distance'],
							"eta" 							=> $resultData['eta'],
							"distancehospital" 				=> $resultData['distancehospital'],
							"etahospital" 					=> $resultData['etahospital'],
							"username" 						=> $resultData['username'],
							"password" 						=> $resultData['password'],
							"device_token" 					=> $resultData['device_token'],
							"is_login" 						=> $resultData['is_login'],
							"active"			 			=> $resultData['active'],
							"photo" 						=> $resultData['photo'],
							"order_id" 						=> $getData['order_id'],
							"order_status" 					=> get_transaction($this->m_api->get_status_emergency($getData['order_id'])),
							"to_latitude" 					=> $to_latitude,
							"to_longitude" 					=> $to_longitude,
							"hospital_forward_latitude" 	=> $hospital_forward_latitude,
							"hospital_forward_longitude" 	=> $hospital_forward_longitude,
							"hospital_back_latitude" 		=> $hospital_back_latitude,
							"hospital_back_longitude"  		=> $hospital_back_longitude
						);
					}
					
					$result = array(
						'status' 	=> '200',
						'message' 	=> 'Update success',
						'data' 		=> $rst
					);
				}	
			}
		}
		else {
			$head_code	= 200;
			$err_code 	= 401;
			$result 	= set_warning($err_code);
		}
		
		json($result, $head_code);
	}
	
	/* new function */
	public function update_emergency_status() {
		$getData = (array) json_decode(file_get_contents('php://input'));
		$x_token = md5('ambulance_id'.'order_id'.'status');
		
		if(checking_header($x_token)) {
			$datetime = get_ymdhis();
				
			// update ambulance
			$kirim_fcm = 0;
			switch($getData['status']) {
				// go to patient
				case 6 :
					$data = array(
						'time_to_patient' 	=> $datetime,
						'emergency_status' 	=> $getData['status']
					);
					
					// current location ambulance
					$from_latitude 	= $this->m_api->get_latitude_ambulance_by_id($getData['ambulance_id']);
					$from_longitude = $this->m_api->get_longitude_ambulance_by_id($getData['ambulance_id']);
					
					// update distance eta to patient
					$to_latitude 	= $this->m_api->get_latitude_emergeny_by_id($getData['order_id']);
					$to_longitude 	= $this->m_api->get_longitude_emergeny_by_id($getData['order_id']); 
					
					$distance_eta = get_distance_eta($from_latitude, $from_longitude, $to_latitude, $to_longitude);
					update_distance_eta_ambulance($getData['ambulance_id'], $distance_eta);
					
					// update distance eta to forward
					$hospital_forward			= $this->m_api->get_hospital_by_emergency($getData['order_id']);
					$hospital_forward_latitude 	= $this->m_api->get_latitude_hospital_by_id($hospital_forward);
					$hospital_forward_longitude = $this->m_api->get_longitude_hospital_by_id($hospital_forward); 
					
					$distance_forward = get_distance_eta($to_latitude, $to_longitude, $hospital_forward_latitude, $hospital_forward_longitude);
					
					// update distance eta to hospital
					$hospital_back				= $this->m_api->get_hospital_by_ambulance($getData['ambulance_id']);		
					$hospital_back_latitude 	= $this->m_api->get_latitude_hospital_by_id($hospital_back);
					$hospital_back_longitude 	= $this->m_api->get_longitude_hospital_by_id($hospital_back); 
					
					$distance_back = get_distance_eta($hospital_forward_latitude, $hospital_forward_longitude, $hospital_back_latitude, $hospital_back_longitude);
					update_distance_eta_hospital_ambulance($getData['ambulance_id'], $distance_eta, $distance_forward, $distance_back);
				
					$kirim_fcm = 1;
				break;
				// call patient
				case 11 :
					$data = array(
						'time_call_patient' => $datetime,
						'emergency_status' 	=> $getData['status']
					);
					
					// current location ambulance
					$from_latitude 	= $this->m_api->get_latitude_ambulance_by_id($getData['ambulance_id']);
					$from_longitude = $this->m_api->get_longitude_ambulance_by_id($getData['ambulance_id']);
					
					// update distance eta to patient
					$to_latitude 	= $this->m_api->get_latitude_emergeny_by_id($getData['order_id']);
					$to_longitude 	= $this->m_api->get_longitude_emergeny_by_id($getData['order_id']); 
					
					$distance_eta = get_distance_eta($from_latitude, $from_longitude, $to_latitude, $to_longitude);
					update_distance_eta_ambulance($getData['ambulance_id'], $distance_eta);
					
					// update distance eta to forward
					$hospital_forward			= $this->m_api->get_hospital_by_emergency($getData['order_id']);
					$hospital_forward_latitude 	= $this->m_api->get_latitude_hospital_by_id($hospital_forward);
					$hospital_forward_longitude = $this->m_api->get_longitude_hospital_by_id($hospital_forward); 
					
					$distance_forward = get_distance_eta($to_latitude, $to_longitude, $hospital_forward_latitude, $hospital_forward_longitude);
					
					// update distance eta to hospital
					$hospital_back				= $this->m_api->get_hospital_by_ambulance($getData['ambulance_id']);		
					$hospital_back_latitude 	= $this->m_api->get_latitude_hospital_by_id($hospital_back);
					$hospital_back_longitude 	= $this->m_api->get_longitude_hospital_by_id($hospital_back); 
					
					$distance_back = get_distance_eta($hospital_forward_latitude, $hospital_forward_longitude, $hospital_back_latitude, $hospital_back_longitude);
					update_distance_eta_hospital_ambulance($getData['ambulance_id'], $distance_eta, $distance_forward, $distance_back);
				break;
				// arrived patient
				case 12 :
					$data = array(
						'time_arrived_patient' 	=> $datetime,
						'emergency_status' 		=> $getData['status']
					);
					
					// current location ambulance
					$from_latitude 	= $this->m_api->get_latitude_ambulance_by_id($getData['ambulance_id']);
					$from_longitude = $this->m_api->get_longitude_ambulance_by_id($getData['ambulance_id']);
					
					// update distance eta to patient
					$to_latitude 	= $this->m_api->get_latitude_emergeny_by_id($getData['order_id']);
					$to_longitude 	= $this->m_api->get_longitude_emergeny_by_id($getData['order_id']); 
					
					$distance_eta = get_distance_eta($from_latitude, $from_longitude, $to_latitude, $to_longitude);
					update_distance_eta_ambulance($getData['ambulance_id'], $distance_eta);
					
					// update distance eta to forward
					$hospital_forward			= $this->m_api->get_hospital_by_emergency($getData['order_id']);
					$hospital_forward_latitude 	= $this->m_api->get_latitude_hospital_by_id($hospital_forward);
					$hospital_forward_longitude = $this->m_api->get_longitude_hospital_by_id($hospital_forward); 
					
					$distance_forward = get_distance_eta($to_latitude, $to_longitude, $hospital_forward_latitude, $hospital_forward_longitude);
					
					// update distance eta to hospital
					$hospital_back				= $this->m_api->get_hospital_by_ambulance($getData['ambulance_id']);		
					$hospital_back_latitude 	= $this->m_api->get_latitude_hospital_by_id($hospital_back);
					$hospital_back_longitude 	= $this->m_api->get_longitude_hospital_by_id($hospital_back); 
					
					$distance_back = get_distance_eta($hospital_forward_latitude, $hospital_forward_longitude, $hospital_back_latitude, $hospital_back_longitude);
					update_distance_eta_hospital_ambulance($getData['ambulance_id'], $distance_eta, $distance_forward, $distance_back);
				
					$kirim_fcm = 1;
				break;
				// go to hospital
				case 7 :
					$data = array(
						'time_to_hospital' 	=> $datetime,
						'emergency_status' 	=> $getData['status']
					);
					
					// current location ambulance
					$from_latitude 	= $this->m_api->get_latitude_ambulance_by_id($getData['ambulance_id']);
					$from_longitude = $this->m_api->get_longitude_ambulance_by_id($getData['ambulance_id']);
					
					$distance_eta = "";
					
					// update distance eta to forward
					$hospital_forward			= $this->m_api->get_hospital_by_emergency($getData['order_id']);
					$hospital_forward_latitude 	= $this->m_api->get_latitude_hospital_by_id($hospital_forward);
					$hospital_forward_longitude = $this->m_api->get_longitude_hospital_by_id($hospital_forward); 
					
					$distance_forward = get_distance_eta($from_latitude, $from_longitude, $hospital_forward_latitude, $hospital_forward_longitude);
					update_distance_eta_ambulance($getData['ambulance_id'], $distance_forward);
					
					// update distance eta to hospital
					$hospital_back				= $this->m_api->get_hospital_by_ambulance($getData['ambulance_id']);		
					$hospital_back_latitude 	= $this->m_api->get_latitude_hospital_by_id($hospital_back);
					$hospital_back_longitude 	= $this->m_api->get_longitude_hospital_by_id($hospital_back); 
					
					$distance_back = get_distance_eta($hospital_forward_latitude, $hospital_forward_longitude, $hospital_back_latitude, $hospital_back_longitude);
					update_distance_eta_hospital_ambulance($getData['ambulance_id'], $distance_eta, $distance_forward, $distance_back);
				
					$kirim_fcm = 1;
				break;
				// arrived hospital
				case 13 :
					$data = array(
						'time_arrived_hospital' => $datetime,
						'emergency_status' 		=> $getData['status']
					);
					
					// current location ambulance
					$from_latitude 	= $this->m_api->get_latitude_ambulance_by_id($getData['ambulance_id']);
					$from_longitude = $this->m_api->get_longitude_ambulance_by_id($getData['ambulance_id']);
					
					$distance_eta = "";
					
					// update distance eta to forward
					$hospital_forward			= $this->m_api->get_hospital_by_emergency($getData['order_id']);
					$hospital_forward_latitude 	= $this->m_api->get_latitude_hospital_by_id($hospital_forward);
					$hospital_forward_longitude = $this->m_api->get_longitude_hospital_by_id($hospital_forward); 
					
					$distance_forward = get_distance_eta($from_latitude, $from_longitude, $hospital_forward_latitude, $hospital_forward_longitude);
					update_distance_eta_ambulance($getData['ambulance_id'], $distance_forward);
					
					// update distance eta to hospital
					$hospital_back				= $this->m_api->get_hospital_by_ambulance($getData['ambulance_id']);		
					$hospital_back_latitude 	= $this->m_api->get_latitude_hospital_by_id($hospital_back);
					$hospital_back_longitude 	= $this->m_api->get_longitude_hospital_by_id($hospital_back); 
					
					$distance_back = get_distance_eta($hospital_forward_latitude, $hospital_forward_longitude, $hospital_back_latitude, $hospital_back_longitude);
					update_distance_eta_hospital_ambulance($getData['ambulance_id'], $distance_eta, $distance_forward, $distance_back);
				
					$kirim_fcm = 1;
				break;
				// back to hospital
				case 8 :
					$data = array(
						'time_back_hospital'	=> $datetime,
						'emergency_status' 		=> $getData['status']
					);
					
					// current location ambulance
					$from_latitude 	= $this->m_api->get_latitude_ambulance_by_id($getData['ambulance_id']);
					$from_longitude = $this->m_api->get_longitude_ambulance_by_id($getData['ambulance_id']);
					
					$distance_eta = "";
					
					// update distance eta to forward
					$distance_forward = "";
					update_distance_eta_ambulance($getData['ambulance_id'], $distance_forward);
					
					// update distance eta to hospital
					$hospital_back				= $this->m_api->get_hospital_by_ambulance($getData['ambulance_id']);		
					$hospital_back_latitude 	= $this->m_api->get_latitude_hospital_by_id($hospital_back);
					$hospital_back_longitude 	= $this->m_api->get_longitude_hospital_by_id($hospital_back); 
					
					$distance_back = get_distance_eta($from_latitude, $from_longitude, $hospital_back_latitude, $hospital_back_longitude);
					update_distance_eta_hospital_ambulance($getData['ambulance_id'], $distance_eta, $distance_forward, $distance_back);
				break;
				// complete
				case 9 :
					$data = array(
						'time_complete'		=> $datetime,
						'emergency_status' 	=> $getData['status']
					);
					
					// update ambulance
					$data_ambulance = array(
						'ambulance_distance'		 => "",
						'ambulance_eta' 			 => "",
						'ambulance_distancehospital' => "",
						'ambulance_etahospital' 	 => "",
						'ambulance_status' 			 => 0,
					);
					
					$this->m_crud->update('tm_ambulance', 'ambulance_id', $data_ambulance, $getData['ambulance_id']);
				break;
			}
			
			// update data
			$head_code	= 200;
			$updateData = $this->m_crud->update('tp_emergency', 'emergency_id', $data, $getData['order_id']);
			if($updateData == 1) {
				if($getData['status'] == 9) {
					$resultData[] = $this->m_api->getIdentityAmbulanceById($getData['ambulance_id']);
				}
				else {
					$resultData = $this->m_api->getAcceptEmergencyByOrderId($getData['order_id']);
				}
				
				$result = array(
					'status' 	=> '200',
					'message' 	=> 'Update success',
					'data' 		=> $resultData
				);
				
				// send FCM
				if($kirim_fcm == 1) {
					$member_id = $this->m_api->get_member_by_emergency($getData['order_id']);
					$device = $this->load->model('member/m_member')->get_device_by_id($member_id);
					if($device != "") {
						$token[] = array();
						$token[] = $device;
						
						$title 		= "";
						$message 	= get_notify($getData['status']);
						
						// send notif
						
						if($getData['status'] == 13) {
							send_firebase_datanotification($token, $title, $message, $getData['order_id'], NULL, 50, '.activity.FeedbackActivity');
						}
						else {
							send_firebase_datanotification($token, $title, $message, $getData['order_id'], NULL, 0, '.activity.OrderActivity');
						}
					}
				}
			} 
			else {
				$result = array(
					'status' 	=> '207',
					'message' 	=> 'No Update ',
					'data' 		=> []
				);
			}
		}
		else {
			$head_code	= 200;
			$err_code 	= 401;
			$result 	= set_warning($err_code);
		}
		
		json($result, $head_code);
	}
	
	/* new function */
	public function get_emergency_list() {
		$getData = (array) json_decode(file_get_contents('php://input'));
		$x_token = md5('ambulance_id');
		
		if(checking_header($x_token)) {
			$head_code	= 200;
			
			$resultData = $this->m_api->getHistoryEmergencyByAmbulanceId($getData['ambulance_id']);
			if(!empty($resultData)) {
				$result = array(
					'status' 	=> '200',
					'message' 	=> 'Success',
					'data' 		=> $resultData
				);
			} else {
				$result = array(
					'status' 	=> '208',
					'message' 	=> 'No Data ',
					'data' 		=> []
				);
			}
		}
		else {
			$head_code	= 200;
			$err_code 	= 401;
			$result 	= set_warning($err_code);
		}
		
		json($result, $head_code);
	}
	
	/* new function */
	public function get_emergency_order() {
		$getData = (array) json_decode(file_get_contents('php://input'));
		$x_token = md5('ambulance_id');
		
		if(checking_header($x_token)) {
			$head_code	= 200;
			
			$resultData = $this->m_api->getOrderEmergencyByAmbulanceId($getData['ambulance_id']);
			if(!empty($resultData)) {
				$result = array(
					'status' 	=> '200',
					'message' 	=> 'Success',
					'data' 		=> $resultData
				);
			} else {
				$result = array(
					'status' 	=> '208',
					'message' 	=> 'No Data ',
					'data' 		=> []
				);
			}
		}
		else {
			$head_code	= 200;
			$err_code 	= 401;
			$result 	= set_warning($err_code);
		}
		
		json($result, $head_code);
	}
	
	/* new function */
	public function accept_nonemergency() {
		$getData = (array) json_decode(file_get_contents('php://input'));
		$x_token = md5('order_id'.'ambulance_id'.'latitude'.'longitude'.'marker_rotation');
		
		if(checking_header($x_token)) {
			$status = $this->m_api->get_status_nonemergency($getData['order_id']);
			if($status == 3) {
				$head_code	= 200;
				$err_code 	= 302;
				$result 	= set_warning($err_code);
			}	
			else {
				$data = array(
					'time_waiting' 			=> get_ymdhis(),
					'nonemergency_status' 	=> 5
				);
				
				$updateData = $this->m_crud->update('tp_nonemergency', 'nonemergency_id', $data, $getData['order_id']);
				if($updateData == 1) {
					// update ambulance
					$data_ambulance = array(
						'ambulance_tracklatitude' 	=> $getData['latitude'],
						'ambulance_tracklongitude' 	=> $getData['longitude'],
						'ambulance_trackrotation' 	=> $getData['marker_rotation'],
						'ambulance_trackdatetime' 	=> get_ymdhis(),
						'ambulance_status'		 	=> 1
					);
					
					$this->m_crud->update('tm_ambulance', 'ambulance_id', $data_ambulance, $getData['ambulance_id']);
					
					// current location ambulance
					$from_latitude 	= $getData['latitude'];
					$from_longitude = $getData['longitude'];
					
					// update distance eta to patient
					$to_latitude 	= $this->m_api->get_latitude_from_nonemergeny_by_id($getData['order_id']);
					$to_longitude 	= $this->m_api->get_longitude_from_nonemergeny_by_id($getData['order_id']); 
					
					$distance_eta = get_distance_eta($from_latitude, $from_longitude, $to_latitude, $to_longitude);
					update_distance_eta_ambulance($getData['ambulance_id'], $distance_eta);
					
					// update distance eta to forward
					$hospital_forward_latitude 	= $this->m_api->get_latitude_to_nonemergeny_by_id($getData['order_id']);
					$hospital_forward_longitude = $this->m_api->get_longitude_to_nonemergeny_by_id($getData['order_id']); 
					
					$distance_forward = get_distance_eta($to_latitude, $to_longitude, $hospital_forward_latitude, $hospital_forward_longitude);
					
					// update distance eta to hospital
					$hospital_back				= $this->m_api->get_hospital_by_ambulance($getData['ambulance_id']);		
					$hospital_back_latitude 	= $this->m_api->get_latitude_hospital_by_id($hospital_back);
					$hospital_back_longitude 	= $this->m_api->get_longitude_hospital_by_id($hospital_back); 
					
					$distance_back = get_distance_eta($hospital_forward_latitude, $hospital_forward_longitude, $hospital_back_latitude, $hospital_back_longitude);
					update_distance_eta_hospital_ambulance($getData['ambulance_id'], $distance_eta, $distance_forward, $distance_back);
					
					$head_code	= 200;
					$resultData = $this->m_api->getAcceptNonEmergencyByOrderId($getData['order_id']);
					$result = array(
						'status' 	=> '200',
						'message' 	=> 'Update success',
						'data' 		=> $resultData
					);
					
					// send FCM
					$member_id = $this->m_api->get_member_by_nonemergency($getData['order_id']);
					$device = $this->load->model('member/m_member')->get_device_by_id($member_id);
					if($device != "") {
						$token[] = array();
						$token[] = $device;
						
						$title 		= "";
						$message 	= get_notify(5);
						
						// send notif
						send_firebase_datanotification($token, $title, $message, $getData['order_id'], NULL, 1, '.activity.OrderNonEmergencyActivity');
					}
				} 
				else {
					$result = array(
						'status' 	=> '207',
						'message' 	=> 'No Update ',
						'data' 		=> []
					);
				}
			}
		}
		else {
			$head_code	= 200;
			$err_code 	= 401;
			$result 	= set_warning($err_code);
		}
		
		json($result, $head_code);
	}
	
	/* new function */
	public function set_nonemergency_crew() {
		$id 	= $this->input->post('order_id');
		$driver = $this->input->post('driver');
		$doctor = $this->input->post('doctor');
		$nurse 	= $this->input->post('nurse');
		
		// insert driver
		$data_driver = array();
		if(!empty($driver)) {
			foreach($driver as $row) {
				if($row != "") {
					$data_driver = array(
						'driver_id'			=> $row,
						'nonemergency_id' 	=> $id
					);
					
					$this->m_crud->insert('td_nonemergencydriver', $data_driver);
				}
			}
		}
			
		// insert doctor
		$data_doctor= array();
		if(!empty($doctor)) {
			foreach($doctor as $row) {
				if($row != "") {
					$data_doctor = array(
						'doctor_id'			=> $row,
						'nonemergency_id' 	=> $id
					);
					
					$this->m_crud->insert('td_nonemergencydoctor', $data_doctor);
				}
			}
		}

		// insert nurse
		$data_nurse = array();
		if(!empty($nurse)) {
			foreach($nurse as $row) {
				if($row != "") {
					$data_nurse = array(
						'nurse_id'			=> $row,
						'nonemergency_id' 	=> $id
					);
					
					$this->m_crud->insert('td_nonemergencynurse', $data_nurse);
				}
			}
		}	
				
		$data = array(
			'time_to_patient' 		=> get_ymdhis(),
			'nonemergency_status' 	=> 6
		);
		
		$updateData = $this->m_crud->update('tp_nonemergency', 'nonemergency_id', $data, $id);
		$head_code	= 200;
		if($updateData == 1) {
			$resultData = $this->m_api->getIdentityNonEmergencyById($id);
			$result = array(
				'status' 		=> '200',
				'message' 		=> 'Update success',
				'data_driver' 	=> set_nonemergency_driver($id),
				'data_doctor' 	=> set_nonemergency_doctor($id),
				'data_nurse' 	=> set_nonemergency_nurse($id),
				'data' 			=> $resultData
			);
		} 
		else {
			$result = array(
				'status' 		=> '207',
				'message' 		=> 'No Update ',
				'data_driver' 	=> [],
				'data_doctor' 	=> [],
				'data_nurse' 	=> [],
				'data' 			=> []
			);
		}

		json($result, $head_code);
	}
	
	/* new function */
	public function update_nonemergency_ambulance_location() {
		$getData = (array) json_decode(file_get_contents('php://input'));
		$x_token = md5('order_id'.'ambulance_id'.'latitude'.'longitude'.'marker_rotation');
		
		if(checking_header($x_token)) {
			if(($getData['ambulance_id'] == null) || ($getData['latitude'] == null) || ($getData['longitude'] == null) || ($getData['marker_rotation'] == null)) {
				$head_code	= 200;
				$err_code 	= 402;
				$result 	= set_warning($err_code);
			}
			else {
				$data = array(
					'ambulance_tracklatitude' 	=> $getData['latitude'],
					'ambulance_tracklongitude' 	=> $getData['longitude'],
					'ambulance_trackrotation' 	=> $getData['marker_rotation'],
					'ambulance_trackdatetime' 	=> get_ymdhis()
				);
				
				$crud = $this->m_crud->update('tm_ambulance', 'ambulance_id', $data, $getData['ambulance_id']);
				if($crud == 0) {
					$head_code	= 200;
					$err_code 	= 205;
					$result 	= set_warning($err_code);
				}
				else {
					// current location ambulance
					$from_latitude 	= $getData['latitude'];
					$from_longitude = $getData['longitude'];
					
					$hospital_forward	= $this->m_api->get_hospital_to_by_nonemergency($getData['order_id']);
					$hospital_back		= $this->m_api->get_hospital_by_ambulance($getData['ambulance_id']);	
					
					$status = $this->m_api->get_emergeny_status_by_id($getData['order_id']);
					if($status == 6) {
						$to_latitude 	= $this->m_api->get_latitude_to_nonemergeny_by_id($getData['order_id']);
						$to_longitude 	= $this->m_api->get_longitude_to_nonemergeny_by_id($getData['order_id']); 
					}
					else if($status == 11) {
						$to_latitude 	= $this->m_api->get_latitude_to_nonemergeny_by_id($getData['order_id']);
						$to_longitude 	= $this->m_api->get_longitude_to_nonemergeny_by_id($getData['order_id']); 
					}
					else if($status == 12) {
						$to_latitude 	= $this->m_api->get_latitude_to_nonemergeny_by_id($getData['order_id']);
						$to_longitude 	= $this->m_api->get_longitude_to_nonemergeny_by_id($getData['order_id']); 
					}
					else if($status == 7) {
						$to_latitude 	= $this->m_api->get_latitude_hospital_by_id($hospital_forward);
						$to_longitude 	= $this->m_api->get_longitude_hospital_by_id($hospital_forward); 
					}
					else if($status == 13) {
						$to_latitude 	= $this->m_api->get_latitude_hospital_by_id($hospital_forward);
						$to_longitude 	= $this->m_api->get_longitude_hospital_by_id($hospital_forward); 
					}
					else {
						$to_latitude 	= $this->m_api->get_latitude_hospital_by_id($hospital_back);
						$to_longitude 	= $this->m_api->get_longitude_hospital_by_id($hospital_back); 
					}
					
					$distance_eta = get_distance_eta($from_latitude, $from_longitude, $to_latitude, $to_longitude);
					update_distance_eta_ambulance($getData['ambulance_id'], $distance_eta);
					
					// update distance eta to forward
					$hospital_forward_latitude 	= $this->m_api->get_latitude_hospital_by_id($hospital_forward);
					$hospital_forward_longitude = $this->m_api->get_longitude_hospital_by_id($hospital_forward); 
				
					$distance_forward = get_distance_eta($to_latitude, $to_longitude, $hospital_forward_latitude, $hospital_forward_longitude);
					
					// update distance eta to hospital	
					$hospital_back_latitude 	= $this->m_api->get_latitude_hospital_by_id($hospital_back);
					$hospital_back_longitude 	= $this->m_api->get_longitude_hospital_by_id($hospital_back); 
					
					$distance_back = get_distance_eta($hospital_forward_latitude, $hospital_forward_longitude, $hospital_back_latitude, $hospital_back_longitude);
					update_distance_eta_hospital_ambulance($getData['ambulance_id'], $distance_eta, $distance_forward, $distance_back);
					
					$head_code	= 200;
					$resultData = $this->m_api->getIdentityAmbulanceById($getData['ambulance_id']);
					
					// push array
					$rst = array();
					foreach($resultData as $row) {
						$rst = array(
							"id" 							=> $resultData['id'],
							"no" 							=> $resultData['no'],
							"plat" 							=> $resultData['plat'],
							"datetime" 						=> $resultData['datetime'],
							"latitude" 						=> $resultData['latitude'],
							"longitude" 					=> $resultData['longitude'],
							"marker_rotation" 				=> $resultData['marker_rotation'],
							"distance"  					=> $resultData['distance'],
							"eta" 							=> $resultData['eta'],
							"distancehospital" 				=> $resultData['distancehospital'],
							"etahospital" 					=> $resultData['etahospital'],
							"username" 						=> $resultData['username'],
							"password" 						=> $resultData['password'],
							"device_token" 					=> $resultData['device_token'],
							"is_login" 						=> $resultData['is_login'],
							"active"			 			=> $resultData['active'],
							"photo" 						=> $resultData['photo'],
							"order_id" 						=> $getData['order_id'],
							"order_status" 					=> get_transaction($this->m_api->get_status_emergency($getData['order_id'])),
							"to_latitude" 					=> $to_latitude,
							"to_longitude" 					=> $to_longitude,
							"hospital_forward_latitude" 	=> $hospital_forward_latitude,
							"hospital_forward_longitude" 	=> $hospital_forward_longitude,
							"hospital_back_latitude" 		=> $hospital_back_latitude,
							"hospital_back_longitude"  		=> $hospital_back_longitude
						);
					}
					
					$result = array(
						'status' 	=> '200',
						'message' 	=> 'Update success',
						'data' 		=> $rst
					);
				}	
			}
		}
		else {
			$head_code	= 200;
			$err_code 	= 401;
			$result 	= set_warning($err_code);
		}
		
		json($result, $head_code);
	}
	
	/* new function */
	public function update_nonemergency_status() {
		$getData = (array) json_decode(file_get_contents('php://input'));
		$x_token = md5('ambulance_id'.'order_id'.'status');
		
		if(checking_header($x_token)) {
			$datetime = get_ymdhis();
				
			// update ambulance
			$kirim_fcm = 0;
			switch($getData['status']) {
				// go to patient
				case 6 :
					$data = array(
						'time_to_patient' 		=> $datetime,
						'nonemergency_status' 	=> $getData['status']
					);
					
					// current location ambulance
					$from_latitude 	= $this->m_api->get_latitude_ambulance_by_id($getData['ambulance_id']);
					$from_longitude = $this->m_api->get_longitude_ambulance_by_id($getData['ambulance_id']);
					
					// update distance eta to patient
					$to_latitude 	= $this->m_api->get_latitude_from_nonemergeny_by_id($getData['order_id']);
					$to_longitude 	= $this->m_api->get_longitude_from_nonemergeny_by_id($getData['order_id']); 
					
					$distance_eta = get_distance_eta($from_latitude, $from_longitude, $to_latitude, $to_longitude);
					update_distance_eta_ambulance($getData['ambulance_id'], $distance_eta);
					
					// update distance eta to forward
					$hospital_forward_latitude 	= $this->m_api->get_latitude_to_nonemergeny_by_id($getData['order_id']);
					$hospital_forward_longitude = $this->m_api->get_longitude_to_nonemergeny_by_id($getData['order_id']); 
					
					$distance_forward = get_distance_eta($to_latitude, $to_longitude, $hospital_forward_latitude, $hospital_forward_longitude);
					
					// update distance eta to hospital
					$hospital_back				= $this->m_api->get_hospital_by_ambulance($getData['ambulance_id']);		
					$hospital_back_latitude 	= $this->m_api->get_latitude_hospital_by_id($hospital_back);
					$hospital_back_longitude 	= $this->m_api->get_longitude_hospital_by_id($hospital_back); 
					
					$distance_back = get_distance_eta($hospital_forward_latitude, $hospital_forward_longitude, $hospital_back_latitude, $hospital_back_longitude);
					update_distance_eta_hospital_ambulance($getData['ambulance_id'], $distance_eta, $distance_forward, $distance_back);
				
					$kirim_fcm = 1;
				break;
				// set crew
				case 4 :
					$data = array(
						'time_call_patient' 	=> $datetime,
						'nonemergency_status' 	=> $getData['status']
					);
					
					// current location ambulance
					$from_latitude 	= $this->m_api->get_latitude_ambulance_by_id($getData['ambulance_id']);
					$from_longitude = $this->m_api->get_longitude_ambulance_by_id($getData['ambulance_id']);
					
					// update distance eta to patient
					$to_latitude 	= $this->m_api->get_latitude_from_nonemergeny_by_id($getData['order_id']);
					$to_longitude 	= $this->m_api->get_longitude_from_nonemergeny_by_id($getData['order_id']); 
					
					$distance_eta = get_distance_eta($from_latitude, $from_longitude, $to_latitude, $to_longitude);
					update_distance_eta_ambulance($getData['ambulance_id'], $distance_eta);
					
					// update distance eta to forward
					$hospital_forward_latitude 	= $this->m_api->get_latitude_to_nonemergeny_by_id($getData['order_id']);
					$hospital_forward_longitude = $this->m_api->get_longitude_to_nonemergeny_by_id($getData['order_id']); 
					
					$distance_forward = get_distance_eta($to_latitude, $to_longitude, $hospital_forward_latitude, $hospital_forward_longitude);
					
					// update distance eta to hospital
					$hospital_back				= $this->m_api->get_hospital_by_ambulance($getData['ambulance_id']);		
					$hospital_back_latitude 	= $this->m_api->get_latitude_hospital_by_id($hospital_back);
					$hospital_back_longitude 	= $this->m_api->get_longitude_hospital_by_id($hospital_back); 
					
					$distance_back = get_distance_eta($hospital_forward_latitude, $hospital_forward_longitude, $hospital_back_latitude, $hospital_back_longitude);
					update_distance_eta_hospital_ambulance($getData['ambulance_id'], $distance_eta, $distance_forward, $distance_back);
				break;
				// go to patient
				case 11 :
					$data = array(
						'time_call_patient' 	=> $datetime,
						'nonemergency_status' 	=> $getData['status']
					);
					
					// current location ambulance
					$from_latitude 	= $this->m_api->get_latitude_ambulance_by_id($getData['ambulance_id']);
					$from_longitude = $this->m_api->get_longitude_ambulance_by_id($getData['ambulance_id']);
					
					// update distance eta to patient
					$to_latitude 	= $this->m_api->get_latitude_from_nonemergeny_by_id($getData['order_id']);
					$to_longitude 	= $this->m_api->get_longitude_from_nonemergeny_by_id($getData['order_id']); 
					
					$distance_eta = get_distance_eta($from_latitude, $from_longitude, $to_latitude, $to_longitude);
					update_distance_eta_ambulance($getData['ambulance_id'], $distance_eta);
					
					// update distance eta to forward
					$hospital_forward_latitude 	= $this->m_api->get_latitude_to_nonemergeny_by_id($getData['order_id']);
					$hospital_forward_longitude = $this->m_api->get_longitude_to_nonemergeny_by_id($getData['order_id']); 
					
					$distance_forward = get_distance_eta($to_latitude, $to_longitude, $hospital_forward_latitude, $hospital_forward_longitude);
					
					// update distance eta to hospital
					$hospital_back				= $this->m_api->get_hospital_by_ambulance($getData['ambulance_id']);		
					$hospital_back_latitude 	= $this->m_api->get_latitude_hospital_by_id($hospital_back);
					$hospital_back_longitude 	= $this->m_api->get_longitude_hospital_by_id($hospital_back); 
					
					$distance_back = get_distance_eta($hospital_forward_latitude, $hospital_forward_longitude, $hospital_back_latitude, $hospital_back_longitude);
					update_distance_eta_hospital_ambulance($getData['ambulance_id'], $distance_eta, $distance_forward, $distance_back);
				break;
				// call patient
				case 12 :
					$data = array(
						'time_arrived_patient' 	=> $datetime,
						'nonemergency_status' 	=> $getData['status']
					);
					
					// current location ambulance
					$from_latitude 	= $this->m_api->get_latitude_ambulance_by_id($getData['ambulance_id']);
					$from_longitude = $this->m_api->get_longitude_ambulance_by_id($getData['ambulance_id']);
					
					// update distance eta to patient
					$to_latitude 	= $this->m_api->get_latitude_from_nonemergeny_by_id($getData['order_id']);
					$to_longitude 	= $this->m_api->get_longitude_from_nonemergeny_by_id($getData['order_id']); 
					
					$distance_eta = get_distance_eta($from_latitude, $from_longitude, $to_latitude, $to_longitude);
					update_distance_eta_ambulance($getData['ambulance_id'], $distance_eta);
					
					// update distance eta to forward
					$hospital_forward_latitude 	= $this->m_api->get_latitude_to_nonemergeny_by_id($getData['order_id']);
					$hospital_forward_longitude = $this->m_api->get_longitude_to_nonemergeny_by_id($getData['order_id']); 
					
					$distance_forward = get_distance_eta($to_latitude, $to_longitude, $hospital_forward_latitude, $hospital_forward_longitude);
					
					// update distance eta to hospital
					$hospital_back				= $this->m_api->get_hospital_by_ambulance($getData['ambulance_id']);		
					$hospital_back_latitude 	= $this->m_api->get_latitude_hospital_by_id($hospital_back);
					$hospital_back_longitude 	= $this->m_api->get_longitude_hospital_by_id($hospital_back); 
					
					$distance_back = get_distance_eta($hospital_forward_latitude, $hospital_forward_longitude, $hospital_back_latitude, $hospital_back_longitude);
					update_distance_eta_hospital_ambulance($getData['ambulance_id'], $distance_eta, $distance_forward, $distance_back);
				
					$kirim_fcm = 1;
				break;
				// go to hospital
				case 7 :
					$data = array(
						'time_to_hospital' 		=> $datetime,
						'nonemergency_status' 	=> $getData['status']
					);
					
					// current location ambulance
					$from_latitude 	= $this->m_api->get_latitude_ambulance_by_id($getData['ambulance_id']);
					$from_longitude = $this->m_api->get_longitude_ambulance_by_id($getData['ambulance_id']);
					
					$distance_eta = "";
					
					// update distance eta to forward
					$hospital_forward			= $this->m_api->get_hospital_to_by_nonemergency($getData['order_id']);
					$hospital_forward_latitude 	= $this->m_api->get_latitude_hospital_by_id($hospital_forward);
					$hospital_forward_longitude = $this->m_api->get_longitude_hospital_by_id($hospital_forward); 
						
					$distance_forward = get_distance_eta($from_latitude, $from_longitude, $hospital_forward_latitude, $hospital_forward_longitude);
					update_distance_eta_ambulance($getData['ambulance_id'], $distance_forward);
					
					// update distance eta to hospital
					$hospital_back				= $this->m_api->get_hospital_by_ambulance($getData['ambulance_id']);		
					$hospital_back_latitude 	= $this->m_api->get_latitude_hospital_by_id($hospital_back);
					$hospital_back_longitude 	= $this->m_api->get_longitude_hospital_by_id($hospital_back); 
					
					$distance_back = get_distance_eta($hospital_forward_latitude, $hospital_forward_longitude, $hospital_back_latitude, $hospital_back_longitude);
					update_distance_eta_hospital_ambulance($getData['ambulance_id'], $distance_eta, $distance_forward, $distance_back);
				
					$kirim_fcm = 1;
				break;
				// arrived hospital
				case 13 :
					$data = array(
						'time_arrived_hospital' => $datetime,
						'nonemergency_status' 	=> $getData['status']
					);
					
					// current location ambulance
					$from_latitude 	= $this->m_api->get_latitude_ambulance_by_id($getData['ambulance_id']);
					$from_longitude = $this->m_api->get_longitude_ambulance_by_id($getData['ambulance_id']);
					
					$distance_eta = "";
					
					// update distance eta to forward
					$hospital_forward			= $this->m_api->get_hospital_to_by_nonemergency($getData['order_id']);
					$hospital_forward_latitude 	= $this->m_api->get_latitude_hospital_by_id($hospital_forward);
					$hospital_forward_longitude = $this->m_api->get_longitude_hospital_by_id($hospital_forward); 
						
					$distance_forward = get_distance_eta($from_latitude, $from_longitude, $hospital_forward_latitude, $hospital_forward_longitude);
					update_distance_eta_ambulance($getData['ambulance_id'], $distance_forward);
					
					// update distance eta to hospital
					$hospital_back				= $this->m_api->get_hospital_by_ambulance($getData['ambulance_id']);		
					$hospital_back_latitude 	= $this->m_api->get_latitude_hospital_by_id($hospital_back);
					$hospital_back_longitude 	= $this->m_api->get_longitude_hospital_by_id($hospital_back); 
					
					$distance_back = get_distance_eta($hospital_forward_latitude, $hospital_forward_longitude, $hospital_back_latitude, $hospital_back_longitude);
					update_distance_eta_hospital_ambulance($getData['ambulance_id'], $distance_eta, $distance_forward, $distance_back);
				
					$kirim_fcm = 1;
				break;
				// back to hospital
				case 8 :
					$data = array(
						'time_back_hospital'	=> $datetime,
						'nonemergency_status' 	=> $getData['status']
					);
					
					// current location ambulance
					$from_latitude 	= $this->m_api->get_latitude_ambulance_by_id($getData['ambulance_id']);
					$from_longitude = $this->m_api->get_longitude_ambulance_by_id($getData['ambulance_id']);
					
					$distance_eta = "";
					
					// update distance eta to forward
					$distance_forward = "";
					update_distance_eta_ambulance($getData['ambulance_id'], $distance_forward);
					
					// update distance eta to hospital
					$hospital_back				= $this->m_api->get_hospital_by_ambulance($getData['ambulance_id']);		
					$hospital_back_latitude 	= $this->m_api->get_latitude_hospital_by_id($hospital_back);
					$hospital_back_longitude 	= $this->m_api->get_longitude_hospital_by_id($hospital_back); 
					
					$distance_back = get_distance_eta($from_latitude, $from_longitude, $hospital_back_latitude, $hospital_back_longitude);
					update_distance_eta_hospital_ambulance($getData['ambulance_id'], $distance_eta, $distance_forward, $distance_back);
				break;
				// complete
				case 9 :
					$data = array(
						'time_complete'			=> $datetime,
						'nonemergency_status' 	=> $getData['status']
					);
					
					// update ambulance
					$data_ambulance = array(
						'ambulance_distance'		 => "",
						'ambulance_eta' 			 => "",
						'ambulance_distancehospital' => "",
						'ambulance_etahospital' 	 => "",
						'ambulance_status' 	 		 => 0,
					);
					
					$this->m_crud->update('tm_ambulance', 'ambulance_id', $data_ambulance, $getData['ambulance_id']);
					
					// reset booking
					$this->m_global->set_status('tp_bookingambulance', 'nonemergency_id', $id, 'bookingambulance_status', 0);
				break;
			}
			
			// update data
			$head_code	= 200;
			$updateData = $this->m_crud->update('tp_nonemergency', 'nonemergency_id', $data, $getData['order_id']);
			if($updateData == 1) {
				if($getData['status'] == 9) {
					$resultData[] = $this->m_api->getIdentityAmbulanceById($getData['ambulance_id']);
				}
				else {
					$resultData = $this->m_api->getAcceptNonEmergencyByOrderId($getData['order_id']);
				}
				
				$result = array(
					'status' 	=> '200',
					'message' 	=> 'Update success',
					'data' 		=> $resultData
				);
				
				// send FCM
				if($kirim_fcm == 1) {
					$member_id = $this->m_api->get_member_by_nonemergency($getData['order_id']);
					$device = $this->load->model('member/m_member')->get_device_by_id($member_id);
					if($device != "") {
						$token[] = array();
						$token[] = $device;
						
						$title 		= "";
						$message 	= get_notify($getData['status']);
						
						// send notif
						if($getData['status'] == 13) {
							send_firebase_datanotification($token, $title, $message, $getData['order_id'], NULL, 51, '.activity.FeedbackActivity');
						}
						else {
							send_firebase_datanotification($token, $title, $message, $getData['order_id'], NULL, 1, '.activity.OrderNonEmergencyActivity');
						}
					}
				}
			} 
			else {
				$result = array(
					'status' 	=> '207',
					'message' 	=> 'No Update ',
					'data' 		=> []
				);
			}
		}
		else {
			$head_code	= 200;
			$err_code 	= 401;
			$result 	= set_warning($err_code);
		}
		
		json($result, $head_code);
	}
	
	/* new function */
	public function get_nonemergency_list() {
		$getData = (array) json_decode(file_get_contents('php://input'));
		$x_token = md5('ambulance_id');
		
		if(checking_header($x_token)) {
			$head_code	= 200;
			
			$resultData = $this->m_api->getHistoryNonEmergencyByAmbulanceId($getData['ambulance_id']);
			if(!empty($resultData)) {
				$result = array(
					'status' 	=> '200',
					'message' 	=> 'Success',
					'data' 		=> $resultData
				);
			} else {
				$result = array(
					'status' 	=> '208',
					'message' 	=> 'No Data ',
					'data' 		=> []
				);
			}
		}
		else {
			$head_code	= 200;
			$err_code 	= 401;
			$result 	= set_warning($err_code);
		}
		
		json($result, $head_code);
	}
	
	/* new function */
	public function get_nonemergency_order() {
		$getData = (array) json_decode(file_get_contents('php://input'));
		$x_token = md5('ambulance_id');
		
		if(checking_header($x_token)) {
			$head_code	= 200;
			
			$resultData = $this->m_api->getOrderNonEmergencyByAmbulanceId($getData['ambulance_id']);
			if(!empty($resultData)) {
				$result = array(
					'status' 	=> '200',
					'message' 	=> 'Success',
					'data' 		=> $resultData
				);
			} else {
				$result = array(
					'status' 	=> '208',
					'message' 	=> 'No Data ',
					'data' 		=> []
				);
			}
		}
		else {
			$head_code	= 200;
			$err_code 	= 401;
			$result 	= set_warning($err_code);
		}
		
		json($result, $head_code);
	}
	
	/* new function */
	public function get_nonemergency_call() {
		$getData = (array) json_decode(file_get_contents('php://input'));
		$x_token = md5('ambulance_id');
		
		if(checking_header($x_token)) {
			$head_code	= 200;
			
			$resultData = $this->m_api->getCallNonEmergencyByAmbulanceId($getData['ambulance_id']);
			if(!empty($resultData)) {
				$result = array(
					'status' 	=> '200',
					'message' 	=> 'Success',
					'data' 		=> $resultData
				);
			} else {
				$result = array(
					'status' 	=> '208',
					'message' 	=> 'No Data ',
					'data' 		=> []
				);
			}
		}
		else {
			$head_code	= 200;
			$err_code 	= 401;
			$result 	= set_warning($err_code);
		}
		
		json($result, $head_code);
	}
	
	public function nexmo_sms(){
		$getData = (array) json_decode(file_get_contents('php://input'));
		$x_token = md5('nexmosms_phone');
		$temp="";
		if(checking_header($x_token)) {
				for ($i = 0; $i < 4; $i++) {
				    $temp .= rand(0, 9);
				}
				$string = $getData['phone'];
				if($string[0]==0){
					$string = preg_replace("/^0/", "+62", $string); $string = "+62".$string; //die($string." 1");
				}
				else{
					$string = "+62".$string; //die($string ." 2");	
				}
				

				$url = 'https://rest.nexmo.com/sms/json?' . http_build_query(
					    [
					      'api_key' =>  '9a995c32',
					      'api_secret' => '4e3700afae524091',
					      'to' => $string,
					      'from' => 'SOS1Health',
					      'text' => 'Activation code AMBULANCE SILOAM 1HEALTH anda adalah '.$temp
					    ]
					);

				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$response = curl_exec($ch);
				$stringForToken = get_ymdhis() .'4ll4h';
				$decoded_response = json_decode($response, true);
				$checking="";
				foreach ( $decoded_response['messages'] as $message ) {
				      $checking = $message['status'];
				 }

				if ($checking == 0) {
					$head_code	= 200;
					$result = array(
						'status' 		=> '200',
						'message' 		=> 'success',
						'token' 		=> md5($stringForToken),
						'smscode' 	    => $temp,
						'data' 			=> $decoded_response
					);
				} 
				else {
					$head_code	= 200;
					$err_code 	= 204;
					$result 	= set_warning($err_code);
				}
			
		}
		else {
			$head_code	= 200;
			$err_code 	= 401;
			$result 	= set_warning($err_code);
		}
		
		json($result, $head_code);

	}


	//batas
	function save_token_mobile_app() {
            $json = file_get_contents('php://input');
            $obj = json_decode($json,true);
            $this->db->where('ambulance_id',$obj['ambulance_id']);
            $dataHospital = $this->db->get('tm_ambulance')->row();
          
            $ret['status']=0;
            $this->db->where('token_id', $obj['token_id']);
            $dataServ = $this->db->get('tm_historytoken')->row();
            if(empty($dataServ)){
                $data = array(
                    'token_id' => $obj['token_id'],
                    'hospital_id' => $dataHospital->hospital_id,
                    'platform'=> $obj['platform'],
                    'ambulance_id' => $obj['ambulance_id']
                );
                $this->m_crud->insert('tm_historytoken',$data);
                $ret['status'] = 1;
            }else{
                $data = array(
                    'hospital_id' => $dataHospital->hospital_id,
                    'platform'=> $obj['platform']
                );
                $this->m_crud->update('tm_historytoken','token_id',$data, $obj['token_id']); 
                $ret['status'] = 1;
            }
            echo json_encode($ret);
            //$this->db->insert('tm_historytoken',$data);
        }

        function test_notifikasi($value='')
        {
        	$this->load->library('fcm');
        	$data = array(
			    "id" => "id",
			    "type"=>" Emergency",
			    "hospitalId"=>"hospitalId",
			    "ambulanceId"=>"ambulanceId",
			    "patientName"=>"patientName"
		    );
		    $this->fcm->sendNotif(16, $data);
        }

        function insert_to_firebase($value='')
        {
        	$data['data'] = $this->db->get('tm_ambulance')->result_array();
        	$this->load->view('test',$data);
        }
        
        public function get_emergency_order2() {
		$getData = (array) json_decode(file_get_contents('php://input'));
		$x_token = md5('ambulance_id');
		
		if(checking_header($x_token)) {
			$head_code	= 200;
			
			$resultData = $this->m_api->getOrderEmergencyByAmbulanceId2($getData['ambulance_id']);
			if(!empty($resultData)) {
				$result = array(
					'status' 	=> '200',
					'message' 	=> 'Success',
					'data' 		=> $resultData
				);
			} else {
				$result = array(
					'status' 	=> '208',
					'message' 	=> 'No Data ',
					'data' 		=> []
				);
			}
		}
		else {
			$head_code	= 200;
			$err_code 	= 401;
			$result 	= set_warning($err_code);
		}
		
		json($result, $head_code);
	}
}