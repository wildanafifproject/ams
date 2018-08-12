<?php
/**
* 
*/
class Daily extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (($this->session->userdata('login') == TRUE)&& ($this->session->userdata('user_authority') != 1)) {	
			
			
			// set sub active
			$this->session->set_userdata('sub_active', 'daily');
		}
		else {
			get_redirecting('login');
		}
	}

	function index()
	{
		if(isset($_POST['daily'])){
			$dataInput = $this->input->post();
			$dataHospital = $this->getHospital();
			$dt['from']=$dataInput['date_from'];
			$dt['to']=$dataInput['date_to'];
			$dataInput['date_from'] = date("Y-m-d", strtotime($dataInput['date_from']) );
			$dataInput['date_to'] = date("Y-m-d", strtotime($dataInput['date_to']) );
			//print_r($dataInput);
			$data = array();
			foreach ($dataHospital as $key => $value) {
				$data[$key]['unit']= $value->hospital_name;

				// ---
				$data[$key]['emergency_order_create_by_1'] = $this->getCount('tp_emergency',
					array(
						'hospital_id' => $value->hospital_id,
						'source_id'=>1,
						'emergency_status' => 9,
						'emergency_date >=' => $dataInput['date_from'], 
						'emergency_date <=' => $dataInput['date_to'], 
					));
				$data[$key]['emergency_order_cancel_by_1'] = $this->getCount('tp_emergency',
					array(
						'hospital_id' => $value->hospital_id,
						'source_id'=>1,
						'emergency_status !=' => 9,
						'emergency_date >=' => $dataInput['date_from'], 
						'emergency_date <=' => $dataInput['date_to'], 
					));
				$data[$key]['emergency_order_cancelation_by_1']= "-";

				// ---

				$data[$key]['emergency_order_create_by_4'] = $this->getCount('tp_emergency',
					array(
						'hospital_id' => $value->hospital_id,
						'source_id'=>4,
						'emergency_status' => 9,
						'emergency_date >=' => $dataInput['date_from'], 
						'emergency_date <=' => $dataInput['date_to'], 
					));
				$data[$key]['emergency_order_cancel_by_4'] = $this->getCount('tp_emergency',
					array(
						'hospital_id' => $value->hospital_id,
						'source_id'=>4,
						'emergency_status !=' => 9,
						'emergency_date >=' => $dataInput['date_from'], 
						'emergency_date <=' => $dataInput['date_to'], 
					));
				$data[$key]['emergency_order_cancelation_by_4']= "-";



				// TOtal 
				$total_emergency_succeses = $this->getCount('tp_nonemergency',
					array(
						'nonemergency_fromhospital' => $value->hospital_id,
						'nonemergency_status' => 9,
						'nonemergency_date >=' => $dataInput['date_from'], 
						'nonemergency_date <=' => $dataInput['date_to'], 
					));

				$total_emergency_cancel = $this->getCount('tp_nonemergency',
					array(
						'nonemergency_fromhospital' => $value->hospital_id,
						'nonemergency_status !=' => 9,
						'nonemergency_date >=' => $dataInput['date_from'], 
						'nonemergency_date <=' => $dataInput['date_to'], 
					));



				// --- Non Emergency
				$data[$key]['nonemergency_order_create_by_1'] = $this->getCount('tp_nonemergency',
					array(
						'nonemergency_fromhospital' => $value->hospital_id,
						'callcenter_id'=>1,
						'nonemergency_status' => 9,
						'nonemergency_date >=' => $dataInput['date_from'], 
						'nonemergency_date <=' => $dataInput['date_to'], 
					));
				$data[$key]['nonemergency_order_cancel_by_1'] = $this->getCount('tp_nonemergency',
					array(
						'nonemergency_fromhospital' => $value->hospital_id,
						'callcenter_id'=>1,
						'nonemergency_status !=' => 9,
						'nonemergency_date >=' => $dataInput['date_from'], 
						'nonemergency_date <=' => $dataInput['date_to'], 
					));
				$data[$key]['nonemergency_order_cancelation_by_1']= "-";

				// --- Non Emergency
				// $data[$key]['nonemergency_order_create_by_4'] = $this->getCount('tp_nonemergency',
				// 	array(
				// 		'nonemergency_fromhospital' => $value->hospital_id,
				// 		'nonemergency_status' => 9,
				// 		'callcenter_id'=>4,
				// 		'nonemergency_date >=' => $dataInput['date_from'], 
				// 		'nonemergency_date <=' => $dataInput['date_to'], 
				// 	));


				$data[$key]['nonemergency_order_create_by_4'] = $total_emergency_succeses - $data[$key]['nonemergency_order_create_by_1'];



				// $data[$key]['nonemergency_order_cancel_by_4'] = $this->getCount('tp_nonemergency',
				// 	array(
				// 		'nonemergency_fromhospital' => $value->hospital_id,
				// 		'callcenter_id'=>4,
				// 		'nonemergency_status !=' => 9,
				// 		'nonemergency_date >=' => $dataInput['date_from'], 
				// 		'nonemergency_date <=' => $dataInput['date_to'], 
				// 	));

				$data[$key]['nonemergency_order_cancel_by_4'] = $total_emergency_cancel - $data[$key]['nonemergency_order_cancel_by_1'];
				$data[$key]['nonemergency_order_cancelation_by_4']= "-";
			}
			$dt['data']=$data;
			$this->load->view('daily/v_excel',$dt);
		}else{
			$this->session->set_userdata('nav_active', 'report');
		// set view
			$this->load->view('../v_header');
			$this->load->view('../v_top');
			$this->load->view('daily/v_index');
			$this->load->view('../v_bottom');
			$this->load->view('../v_footer');
		}
		
	}

	function excel($value='')
	{
		$this->load->view('daily/v_excel');
	}
	function getHospital()
	{
		$this->db->where('hospital_status',1);
		$data = $this->db->get('tm_hospital')->result();
		return $data;
	}

	function getCount($table='',$where)
	{
		$this->db->where($where);
		$this->db->from($table);
        return $this->db->count_all_results();
	}
}