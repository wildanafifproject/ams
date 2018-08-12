<?php
	function increment($count) {
		$str = "000";
		$count = $count + 1;
		$len = strlen($count);
		
		switch($len) {
			case 1 : 
				$result = "00". $count;
			break;
			case 2 : 
				$result = "0". $count;
			break;
			case 3 : 
				$result = $count;
			break;
		}
		
		return $result;
	}
	
	function generate_code($status) {
		$CI =& get_instance();
		
		// cari kode transaksi
		if($status == 0) {
			$KB = "ER";
			$tabel = "tp_emergency";
			$field = "emergency_id";
			$finds = "emergency_callreference";
		}
		else {
			$KB = "NONER";
			$tabel = "tp_nonemergency";
			$field = "nonemergency_id";
			$finds = "nonemergency_callreference";
		}
	
		$KA = 17;
		$KT = $KB."-".$KA;
		
		// cari jumlah transaksi 
		$preq  	= 'SACC-'.$KT;
		$count 	= $CI->load->model('m_global')->count_by_preq($tabel, $field, $finds, $preq);
		if($count < 999) {
			$code = increment($count);
		}
		else {
			$mod = $count / 999;
			$mod = intval($mod); 
		
			$KA = $KA + $mod;
			$KT = $KB."-".$KA;
			
			// cari jumlah transaksi
			$preq  	= 'SACC-'.$KT;
			$count 	= $CI->load->model('m_global')->count_by_preq($tabel, $field, $finds, $preq);
		}
		
		$code 	= increment($count);
		$result = $preq.$code;
		
		return $result;
	}
	
	
	// old
	function increment_code($count) {
		$str = "000";
		$count = $count + 1;
		$len = strlen($count);
		
		switch($len) {
			case 1 : 
				$result = "00". $count;
			break;
			case 2 : 
				$result = "0". $count;
			break;
			case 3 : 
				$result = $count;
			break;
		}
		
		return $result;
	}
	
	function generate_call_reference() {
		$CI =& get_instance();
		
		// cari kode tahun 
		$KT = "17";//date('y');
		
		// cari jumlah member 
		$preq  	= 'SACC-'.$KT;
		$count 	= $CI->load->model('m_global')->count_by_preq('tp_emergency', 'emergency_id', 'emergency_callreference', $preq);
		
		//SACC-ER-17999	SACC-NONER-17999
		$code 	= increment_code($count);
		$result = $preq.$code;
		
		return $result;
	}
	
	function increment_codes($count) {
		$str = "000";
		$count = $count + 1;
		$len = strlen($count);
		
		switch($len) {
			case 1 : 
				$result = "00000". $count;
			break;
			case 2 : 
				$result = "0000". $count;
			break;
			case 3 : 
				$result = "000". $count;
			break;
			case 4 : 
				$result = "00". $count;
			break;
			case 5 : 
				$result = "0". $count;
			break;
			case 6 : 
				$result = $count;
			break;
		}
		
		return $result;
	}
	
	function generate_call_references() {
		$CI =& get_instance();
		
		// cari jumlah member 
		$preq  	= 'SACC-';
		$count 	= $CI->load->model('m_global')->count_by_preq('tp_nonemergency', 'nonemergency_id', 'nonemergency_callreference', $preq);
		
		$code 	= increment_codes($count);
		$result = $preq.$code;
		
		return $result;
	}
	function generate_code_v2($status) {
		$CI =& get_instance();
		$CI->load->model('m_global');
		// cari kode transaksi
		if($status == 0) {
			$KB = "ER";
			$tabel = "tp_emergency";
			$field = "emergency_id";
			$finds = "emergency_callreference";
		}
		else {
			$KB = "NONER";
			$tabel = "tp_nonemergency";
			$field = "nonemergency_id";
			$finds = "nonemergency_callreference";
		}
                $dtxField = $CI->m_global->getValueFieldHigh($tabel,$finds,$finds);
                //print_r($dtxField);
                $tmp = str_pad($dtxField->$finds, 5, '0', STR_PAD_LEFT); 
                echo $tmp;
                $numberCode = explode("-", $tmp);
                $numberCode = $numberCode[count($numberCode)-1];
                $numberCode++;
                $finalCode =  'SACC-'.$KB.'-'.$numberCode;
                return $finalCode;
	
	}
?>