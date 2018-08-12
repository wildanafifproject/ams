<?php
	function handling_characters($str) {
		$str = str_replace("@", "", $str);
		$str = str_replace("#", "", $str);
		$str = str_replace("$", "", $str);
		$str = str_replace("%", "", $str);
		$str = str_replace("^", "", $str);
		$str = str_replace("&", "", $str);
		$str = str_replace("*", "", $str);
		$str = str_replace("'", "", $str);
		$str = str_replace('"', '', $str);
		$str = str_replace(':', '', $str);
		
		return $str;
	}
	
	function labeling($str) {
		$str = str_replace(" ", "-", strip_tags($str));
		$str = handling_characters($str);
		$str = str_replace('"', '', $str);
		
		$str = substr($str, 0, 100);
		return $str;
	}
	
	function usernaming($str) {
		$str = str_replace(" ", "", strip_tags($str));
		$str = handling_characters($str);
		$str = str_replace('"', '', $str);
		
		$str = substr($str, 0, 100);
		return $str;
	}
	
	function convert_to_nomor($id) {
		$digit = "";
		$nomor = "";
		
		$id = intval($id);
		if($id < 10) {
			$digit = "000000";
		}
		else if($id >= 10 && $id < 99) {
			$digit = "00000";
		}
		else if($id >= 100 && $id < 999) {
			$digit = "0000";
		}	
		else if($id >= 1000 && $id < 9999) {
			$digit = "000";
		}
		else if($id >= 10000 && $id < 99999) {
			$digit = "00";
		}
		else if($id >= 100000 && $id < 999999) {
			$digit = "0";
		}
		else {
			$digit = "";
		}
		
		$nomor = $digit .''. $id;
		
		return $nomor;
	}
	
	function convert_to_star($len) {
		$encryp = "";
		
		for($i=0; $i<$len; $i++) {
			$encryp = $encryp."*";
		}
		
		return $encryp;
	}
	
	function format_rupiah($value) {
		return 'Rp. '. number_format($value, 2);
	}
	
	function pembulatan_rupiah($value) {
		$value = intval($value);
		if(strlen($value) >= 3) {
			$depan = substr($value, 0, (strlen($value) - 3));
			$ratusan = substr($value, (strlen($value) - 3), 3);
			if($ratusan >= 1 && $ratusan < 250) {
				$ratusan = '000';
			}
			else if($ratusan >= 250 && $ratusan < 500) {
				$ratusan = '250';
			}
			else if($ratusan >= 500 && $ratusan < 750) {
				$ratusan = '500';
			}
			else if($ratusan >= 750 && $ratusan < 1000) {
				if(strlen($value) == 3) {
					$depan = substr($value, 0, (strlen($value) - 2));
					$ratusan = substr($value, (strlen($value) - 2), 2);
					
					if($ratusan >= 1 && $ratusan < 50) {
						$ratusan = '00';
					}
					else {
						$ratusan = '50';
					}
				}
				else {
					$depan = substr($value, 0, (strlen($value) - 2));
					$ratusan = substr($value, (strlen($value) - 2), 2);
					
					if($ratusan >= 51 && $ratusan < 100) {
						$ratusan = '50';
					}
					else {
						$ratusan = '00';
					}
					
				}
			}
			
			$value = $depan.''.$ratusan;
		}
		
		return number_format($value, 2);
	}
	
	function depan_koma($string, $find) {
		$value = 0;
		if (strpos($string, '.') !== false) {
			$pos 	= strpos($string, $find);
			$value 	= substr($string, 0, $pos);	
		}
		
		return $value;
	}
	
	function belakang_koma($string, $find) {
		$value = 0;
		if (strpos($string, '.') !== false) {
			$pos 	= strpos($string, $find);
			$value 	= substr($string, ($pos + 1), (strlen($string) - $pos));	
		}
		
		return $value;
	}
	
	function make_comparer() {
		// Normalize criteria up front so that the comparer finds everything tidy
		$criteria = func_get_args();
		foreach ($criteria as $index => $criterion) {
			$criteria[$index] = is_array($criterion)
				? array_pad($criterion, 3, null)
				: array($criterion, SORT_ASC, null);
		}

		return function($first, $second) use (&$criteria) {
			foreach ($criteria as $criterion) {
				// How will we compare this round?
				list($column, $sortOrder, $projection) = $criterion;
				$sortOrder = $sortOrder === SORT_DESC ? -1 : 1;

				// If a projection was defined project the values now
				if ($projection) {
					$lhs = call_user_func($projection, $first[$column]);
					$rhs = call_user_func($projection, $second[$column]);
				}
				else {
					$lhs = $first[$column];
					$rhs = $second[$column];
				}

				// Do the actual comparison; do not return if equal
				if ($lhs < $rhs) {
					return -1 * $sortOrder;
				}
				else if ($lhs > $rhs) {
					return 1 * $sortOrder;
				}
			}

			return 0; // tiebreakers exhausted, so $first == $second
		};
	}

	function set_userdata($session, $value) {
		$CI =& get_instance();
		$CI->session->set_userdata($session, $value);
	}
	
	function unset_userdata($session) {
		$CI =& get_instance();
		$CI->session->unset_userdata($session);
	}
	
	function set_flashdata($session, $value) {
		$CI =& get_instance();
		$CI->session->set_flashdata($session, $value);
	}
	
	function unset_flashdata($session) {
		$CI =& get_instance();
		$CI->session->unset_flashdata($session);
	}
	
	function last_query() {
		$CI =& get_instance();
		echo $CI->db->last_query(); die();
	}
	
	function cetak($var) {
		echo $var; die();
	}
	
	function json($arr, $status) {
		if($status == "") { $status = 200; }
		
		$CI =& get_instance();
		$response = array('status' => 'OK');

		$CI->output
        ->set_status_header($status)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($arr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
        ->_display();
		
		exit;
		die();
	}
	
	function set_json($arr) {
		$CI =& get_instance();
		
		$CI->output->set_header("HTTP/1.0 200 OK");
		$CI->output->set_header("HTTP/1.1 200 OK");
		$CI->output->set_header('Expires: '.gmdate('D, d M Y H:i:s'));
		$CI->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
		$CI->output->set_header("Cache-Control: post-check=0, pre-check=0");
		$CI->output->set_header("Pragma: no-cache"); 
		
		$CI->output->set_header('Content-Type: application/json'); 
		return json_encode($arr, TRUE);
	}
?>