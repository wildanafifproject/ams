<?php

class M_api extends CI_Model {

    public function getIdentityUserById($id) {
        $query = $this->db->get_where('tm_member', array('member_id' => $id), 1, 0);
        $query = $query->result();
        $result = set_member($query);

        return $result;
    }

    public function cekEmail($email) {
        $query = $this->db->get_where('tm_member', array('member_email' => $email), 1, 0);
        $query = $query->result();

        $response = set_response($query);
        $data = set_member($query);
        $result = set_return($response, $data);

        return $result;
    }

    public function getUserByEmail($email) {
        $query = $this->db->get_where('tm_member', array('member_email' => $email), 1, 0);
        $query = $query->result();

        $response = set_response($query);
        $data = set_member($query);
        $result = set_return($response, $data);

        return $result;
    }

    public function login($email, $password) {
        $pwd = md5($password);

        $query = $this->db->get_where('tm_member', array('member_email' => $email, 'member_password' => $pwd), 1, 0);
        $query = $query->result();

        $response = set_response($query);
        $data = set_member($query);
        $result = set_return($response, $data);

        return $result;
    }

    public function loginSocmed($email) {
        $query = $this->db->get_where('tm_member', array('member_email' => $email), 1, 0);
        $query = $query->result();

        $response = set_response($query);
        $data = set_member($query);
        $result = set_return($response, $data);

        return $result;
    }

    public function getEmergencyContact($id) {
        $query = $this->db->get_where('ti_contact', array('member_id' => $id), 1, 0);
        $query = $query->result();
        $result = set_contact($query);

        return $result;
    }

    public function getIdentityHospitalById($id) {
        $query = $this->db->get_where('tm_hospital', array('hospital_id' => $id), 1, 0);
        $query = $query->result();
        $result = set_hospital_detail($query);

        return $result;
    }

    public function getNearestHospitals($user_latitude, $user_longitude) {
        $query = $this->db->order_by('hospital_name', 'ASC')->get_where('tm_hospital', array('hospital_status' => 1));
        $query = $query->result();

        $km_data_temp = [];
        $m_data_temp = array();
        $direction_km_temp = [];
        $direction_m_temp = [];
        $result_data = [];

        if (!empty($query)) {
            foreach ($query as $row) {
                $directions = setDirections($user_latitude, $user_longitude, $row->hospital_latitude, $row->hospital_longitude);

                $distance_unit = preg_replace('/[0-9]+.+ /', '', $directions[0]["distance"]);
                $distance_value_temp = preg_replace('/ /', '', trim($directions[0]["distance"], "a..zA..Z"));
                $distance_value_result = floatval(preg_replace('/,/', '', $distance_value_temp));

                if ($distance_unit == "km") {
                    if ($distance_value_result <= 20) {
                        $direction_km_temp[] = $distance_value_result;
                        $row->hospital_distance = $distance_value_result;
                        $row->hospital_eta = $directions[0]["time"];
                        $data = set_hospital($row);

                        array_push($km_data_temp, $data);
                        array_multisort($direction_km_temp, $km_data_temp);
                    } else {
                        $direction_km_temp[] = $distance_value_result;
                        $row->hospital_distance = $distance_value_result;
                        $row->hospital_eta = $directions[0]["time"];
                        $data = set_hospital($row);

                        array_push($km_data_temp, $data);
                        array_multisort($direction_km_temp, $km_data_temp);
                    }
                } else {
                    $direction_m_temp[] = $distance_value_result;
                    $row->hospital_distance = $distance_value_result;
                    $row->hospital_eta = $directions[0]["time"];
                    $data = set_hospital($row);

                    array_push($m_data_temp, $data);
                    array_multisort($direction_m_temp, $m_data_temp);
                }
            }

            if (count($direction_m_temp) != 0) {
                foreach ($direction_m_temp as $m_row) {
                    $m_row["distance"] = strval(number_format($m_row["distance"], 1)) . " m";
                    array_push($result_data, $m_row);
                }
            }

            if (count($km_data_temp) != 0) {
                foreach ($km_data_temp as $km_row) {
                    $km_row["distance"] = strval(number_format($km_row["distance"], 1)) . " km";
                    array_push($result_data, $km_row);
                }
            }

            $response = 1;
        } else {
            $response = 0;
        }

        $result = set_return($response, $result_data);
        return $result;
    }

    public function getAreas() {
        $query = $this->db->order_by('area_name', 'ASC')->get_where('tm_area', array('area_status' => 1));
        $query = $query->result();
        $result = set_area($query);

        return $result;
    }

    public function getIdentityAmbulanceById($id) {
        $query = $this->db->get_where('tm_ambulance', array('ambulance_id' => $id), 1, 0);
        $query = $query->result();
        $result = set_ambulance($query);

        return $result;
    }

    public function login_ambulance($username, $password) {
        $query = $this->db->get_where('tm_ambulance', array('ambulance_username' => $username, 'ambulance_password' => $password), 1, 0);
        $query = $query->result();

        $response = set_response($query);
        $data = set_ambulance($query);
        $result = set_return($response, $data);

        return $result;
    }

    function get_plat_ambulance_by_id($id) {
        $this->db->select('ambulance_police');
        $this->db->from('tm_ambulance');
        $this->db->where('ambulance_id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $ambulance_police = $row->ambulance_police;
            }

            return $ambulance_police;
        } else {
            return "";
        }
    }

    function get_latitude_ambulance_by_id($id) {
        $this->db->select('ambulance_tracklatitude');
        $this->db->from('tm_ambulance');
        $this->db->where('ambulance_id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $ambulance_tracklatitude = $row->ambulance_tracklatitude;
            }

            return $ambulance_tracklatitude;
        } else {
            return "";
        }
    }

    function get_longitude_ambulance_by_id($id) {
        $this->db->select('ambulance_tracklongitude');
        $this->db->from('tm_ambulance');
        $this->db->where('ambulance_id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $ambulance_tracklongitude = $row->ambulance_tracklongitude;
            }

            return $ambulance_tracklongitude;
        } else {
            return "";
        }
    }

    function get_distance_ambulance_by_id($id) {
        $this->db->select('ambulance_distance');
        $this->db->from('tm_ambulance');
        $this->db->where('ambulance_id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $ambulance_distance = $row->ambulance_distance;
            }

            return $ambulance_distance;
        } else {
            return "";
        }
    }

    function get_eta_ambulance_by_id($id) {
        $this->db->select('ambulance_eta');
        $this->db->from('tm_ambulance');
        $this->db->where('ambulance_id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $ambulance_eta = $row->ambulance_eta;
            }

            return $ambulance_eta;
        } else {
            return "";
        }
    }

    function get_hospital_by_ambulance($id) {
        $this->db->select('hospital_id');
        $this->db->from('tm_ambulance');
        $this->db->where('ambulance_id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $hospital_id = $row->hospital_id;
            }

            return $hospital_id;
        } else {
            return 0;
        }
    }

    function get_hospital_from_by_nonemergency($id) {
        $this->db->select('nonemergency_fromhospital');
        $this->db->from('tp_nonemergency');
        $this->db->where('nonemergency_id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $nonemergency_fromhospital = $row->nonemergency_fromhospital;
            }

            return $nonemergency_fromhospital;
        } else {
            return 0;
        }
    }

    function get_hospital_to_by_nonemergency($id) {
        $this->db->select('nonemergency_tohospital');
        $this->db->from('tp_nonemergency');
        $this->db->where('nonemergency_id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $nonemergency_tohospital = $row->nonemergency_tohospital;
            }

            return $nonemergency_tohospital;
        } else {
            return 0;
        }
    }

    function get_latitude_hospital_by_id($id) {
        $this->db->select('hospital_latitude');
        $this->db->from('tm_hospital');
        $this->db->where('hospital_id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $hospital_latitude = $row->hospital_latitude;
            }

            return $hospital_latitude;
        } else {
            return "";
        }
    }

    function get_longitude_hospital_by_id($id) {
        $this->db->select('hospital_longitude');
        $this->db->from('tm_hospital');
        $this->db->where('hospital_id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $hospital_longitude = $row->hospital_longitude;
            }

            return $hospital_longitude;
        } else {
            return "";
        }
    }

    function get_area_from_by_nonemergency($id) {
        $this->db->select('nonemergency_fromarea');
        $this->db->from('tp_nonemergency');
        $this->db->where('nonemergency_id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $nonemergency_fromarea = $row->nonemergency_fromarea;
            }

            return $nonemergency_fromarea;
        } else {
            return 0;
        }
    }

    public function getIdentityTrackEmergencyById($id) {
        $query = $this->db->get_where('tp_emergency', array('emergency_id' => $id), 1, 0);
        $query = $query->result();
        $result = set_emergency_track_detail($query);

        return $result;
    }

    public function getIdentityEmergencyById($id) {
        $query = $this->db->get_where('tp_emergency', array('emergency_id' => $id), 1, 0);
        $query = $query->result();
        $result = set_emergency($query);

        return $result;
    }

    public function getTrackEmergencyById($id) {
        $query = $this->db->get_where('tp_emergency', array('emergency_id' => $id), 1, 0);
        $query = $query->result();
        $result = set_emergency_track($query);

        return $result;
    }

    public function getTrackingEmergencyById($id) {
        $query = $this->db->get_where('tp_emergency', array('emergency_id' => $id), 1, 0);
        $query = $query->result();
        $result = set_emergency_tracking($query);

        return $result;
    }

    public function getHistoryEmergencyByUserId($id) {
        $query = $this->db->get_where('tp_emergency', array('member_id' => $id));
        $query = $query->result();
        $result = set_emergency_list($query);

        return $result;
    }

    public function getAcceptEmergencyByOrderId($id) {
        $query = $this->db->get_where('tp_emergency', array('emergency_id' => $id));
        $query = $query->result();
        $result = set_emergency_list($query);

        return $result;
    }

    public function getHistoryEmergencyByAmbulanceId($id) {
        $query = $this->db->get_where('tp_emergency', array('ambulance_id' => $id));
        $query = $query->result();
        $result = set_emergency_list($query);

        return $result;
    }

    public function getOrderEmergencyByAmbulanceId($id) {
        $query = $this->db->get_where('tp_emergency', array('ambulance_id' => $id, 'emergency_status' => 1), 1, 0);
        $query = $query->result();

        $result = set_emergency_history($query);

        return $result;
    }

    function get_status_emergency($id) {
        $this->db->select('emergency_status');
        $this->db->from('tp_emergency');
        $this->db->where('emergency_id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $emergency_status = $row->emergency_status;
            }

            return $emergency_status;
        } else {
            return 0;
        }
    }

    function get_member_by_emergency($id) {
        $this->db->select('member_id');
        $this->db->from('tp_emergency');
        $this->db->where('emergency_id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $member_id = $row->member_id;
            }

            return $member_id;
        } else {
            return 0;
        }
    }

    function get_ambulance_by_emergency($id) {
        $this->db->select('ambulance_id');
        $this->db->from('tp_emergency');
        $this->db->where('emergency_id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $ambulance_id = $row->ambulance_id;
            }

            return $ambulance_id;
        } else {
            return 0;
        }
    }

    function get_latitude_emergeny_by_id($id) {
        $this->db->select('emergency_infolatitude');
        $this->db->from('tp_emergency');
        $this->db->where('emergency_id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $emergency_infolatitude = $row->emergency_infolatitude;
            }

            return $emergency_infolatitude;
        } else {
            return "";
        }
    }

    function get_longitude_emergeny_by_id($id) {
        $this->db->select('emergency_infolongitude');
        $this->db->from('tp_emergency');
        $this->db->where('emergency_id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $emergency_infolongitude = $row->emergency_infolongitude;
            }

            return $emergency_infolongitude;
        } else {
            return "";
        }
    }

    function get_emergeny_status_by_id($id) {
        $this->db->select('emergency_status');
        $this->db->from('tp_emergency');
        $this->db->where('emergency_id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $emergency_status = $row->emergency_status;
            }

            return $emergency_status;
        } else {
            return 0;
        }
    }

    function get_forward_by_emergency($id) {
        $this->db->select('forward_id');
        $this->db->from('tp_emergency');
        $this->db->where('emergency_id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $forward_id = $row->forward_id;
            }

            return $forward_id;
        } else {
            return 0;
        }
    }

    public function getIdentityNonEmergencyById($id) {
        $query = $this->db->get_where('tp_nonemergency', array('nonemergency_id' => $id), 1, 0);
        $query = $query->result();
        $result = set_nonemergency($query);

        return $result;
    }

    public function getTrackNonEmergencyById($id) {
        $query = $this->db->get_where('tp_nonemergency', array('nonemergency_id' => $id), 1, 0);
        $query = $query->result();
        $result = set_nonemergency_track($query);

        return $result;
    }

    public function getTrackingNonEmergencyById($id) {
        $query = $this->db->get_where('tp_nonemergency', array('nonemergency_id' => $id), 1, 0);
        $query = $query->result();
        $result = set_nonemergency_tracking($query);

        return $result;
    }

    public function getHistoryNonEmergencyByUserId($id) {
        $query = $this->db->get_where('tp_nonemergency', array('member_id' => $id));
        $query = $query->result();
        $result = set_nonemergency_list($query);

        return $result;
    }

    public function getHistoryNonEmergencyByOrderId($id) {
        $query = $this->db->get_where('tp_nonemergency', array('nonemergency_id' => $id));
        $query = $query->result();
        $result = set_nonemergency_list($query);

        return $result;
    }

    public function getAcceptNonEmergencyByOrderId($id) {
        $query = $this->db->get_where('tp_nonemergency', array('nonemergency_id' => $id));
        $query = $query->result();
        $result = set_nonemergency_list($query);

        return $result;
    }

    public function getHistoryNonEmergencyByAmbulanceId($id) {
        $query = $this->db->get_where('tp_nonemergency', array('ambulance_id' => $id));
        $query = $query->result();
        $result = set_nonemergency_list($query);

        return $result;
    }

    public function getOrderNonEmergencyByAmbulanceId($id) {
        $query = $this->db->get_where('tp_nonemergency', array('ambulance_id' => $id, 'nonemergency_status' => 1));
        $query = $query->result();
        $result = set_nonemergency_history($query);

        return $result;
    }

    public function getCallNonEmergencyByAmbulanceId($id) {
        $query = $this->db->get_where('tp_nonemergency', array('ambulance_id' => $id, 'nonemergency_status' => 14), 1, 0);
        $query = $query->result();
        $result = set_nonemergency_call($query);

        return $result;
    }

    function get_status_nonemergency($id) {
        $this->db->select('nonemergency_status');
        $this->db->from('tp_nonemergency');
        $this->db->where('nonemergency_id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $nonemergency_status = $row->nonemergency_status;
            }

            return $nonemergency_status;
        } else {
            return 0;
        }
    }

    function get_member_by_nonemergency($id) {
        $this->db->select('member_id');
        $this->db->from('tp_nonemergency');
        $this->db->where('nonemergency_id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $member_id = $row->member_id;
            }

            return $member_id;
        } else {
            return 0;
        }
    }

    function get_ambulance_by_nonemergency($id) {
        $this->db->select('ambulance_id');
        $this->db->from('tp_nonemergency');
        $this->db->where('nonemergency_id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $ambulance_id = $row->ambulance_id;
            }

            return $ambulance_id;
        } else {
            return 0;
        }
    }

    function get_from_hospital_by_id($id) {
        $this->db->select('nonemergency_fromhospital');
        $this->db->from('tp_nonemergency');
        $this->db->where('nonemergency_id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $nonemergency_fromhospital = $row->nonemergency_fromhospital;
            }

            return $nonemergency_fromhospital;
        } else {
            return 0;
        }
    }

    function get_to_hospital_by_id($id) {
        $this->db->select('nonemergency_tohospital');
        $this->db->from('tp_nonemergency');
        $this->db->where('nonemergency_id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $nonemergency_tohospital = $row->nonemergency_tohospital;
            }

            return $nonemergency_tohospital;
        } else {
            return 0;
        }
    }

    function get_latitude_from_nonemergeny_by_id($id) {
        $this->db->select('nonemergency_fromlatitude');
        $this->db->from('tp_nonemergency');
        $this->db->where('nonemergency_id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $nonemergency_fromlatitude = $row->nonemergency_fromlatitude;
            }

            return $nonemergency_fromlatitude;
        } else {
            return "";
        }
    }

    function get_longitude_from_nonemergeny_by_id($id) {
        $this->db->select('nonemergency_fromlongitude');
        $this->db->from('tp_nonemergency');
        $this->db->where('nonemergency_id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $nonemergency_fromlongitude = $row->nonemergency_fromlongitude;
            }

            return $nonemergency_fromlongitude;
        } else {
            return "";
        }
    }

    function get_latitude_to_nonemergeny_by_id($id) {
        $this->db->select('nonemergency_tolatitude');
        $this->db->from('tp_nonemergency');
        $this->db->where('nonemergency_id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $nonemergency_tolatitude = $row->nonemergency_tolatitude;
            }

            return $nonemergency_tolatitude;
        } else {
            return "";
        }
    }

    function get_longitude_to_nonemergeny_by_id($id) {
        $this->db->select('nonemergency_tolongitude');
        $this->db->from('tp_nonemergency');
        $this->db->where('nonemergency_id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $nonemergency_tolongitude = $row->nonemergency_tolongitude;
            }

            return $nonemergency_tolongitude;
        } else {
            return "";
        }
    }

    function get_nonemergeny_status_by_id($id) {
        $this->db->select('nonemergency_status');
        $this->db->from('tp_nonemergency');
        $this->db->where('nonemergency_id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $nonemergency_status = $row->nonemergency_status;
            }

            return $nonemergency_status;
        } else {
            return 0;
        }
    }

    function get_name_source_by_id($id) {
        $this->db->select('source_name');
        $this->db->from('tm_source');
        $this->db->where('source_id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $source_name = $row->source_name;
            }

            return $source_name;
        } else {
            return 0;
        }
    }

    function get_name_forward_by_id($id) {
        $this->db->select('forward_name');
        $this->db->from('tm_forward');
        $this->db->where('forward_id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $forward_name = $row->forward_name;
            }

            return $forward_name;
        } else {
            return 0;
        }
    }

    function get_name_hospital_by_id($id) {
        $this->db->select('hospital_name');
        $this->db->from('tm_hospital');
        $this->db->where('hospital_id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $hospital_name = $row->hospital_name;
            }

            return $hospital_name;
        } else {
            return "";
        }
    }

    function get_name_unit_by_id($id) {
        $this->db->select('unit_name');
        $this->db->from('tm_unit');
        $this->db->where('unit_id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $unit_name = $row->unit_name;
            }

            return $unit_name;
        } else {
            return "";
        }
    }

    function get_name_area_by_id($id) {
        $this->db->select('area_name');
        $this->db->from('tm_area');
        $this->db->where('area_id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $area_name = $row->area_name;
            }

            return $area_name;
        } else {
            return "";
        }
    }

    function get_name_location_by_id($id) {
        $this->db->select('location_name');
        $this->db->from('tm_location');
        $this->db->where('location_id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $location_name = $row->location_name;
            }

            return $location_name;
        } else {
            return "";
        }
    }

    function get_name_subcategory_by_id($id) {
        $this->db->select('subcategory_name');
        $this->db->from('tm_subcategory');
        $this->db->where('subcategory_id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $subcategory_name = $row->subcategory_name;
            }

            return $subcategory_name;
        } else {
            return "";
        }
    }

    function get_name_callcenter_by_id($id) {
        $this->db->select('callcenter_name');
        $this->db->from('tm_callcenter');
        $this->db->where('callcenter_id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $callcenter_name = $row->callcenter_name;
            }

            return $callcenter_name;
        } else {
            return "";
        }
    }

    function get_name_internalcall_by_id($id) {
        $this->db->select('internalcall_name');
        $this->db->from('tm_internalcall');
        $this->db->where('internalcall_id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $internalcall_name = $row->internalcall_name;
            }

            return $internalcall_name;
        } else {
            return "";
        }
    }

    function get_name_transfer_by_id($id) {
        $this->db->select('transfer_name');
        $this->db->from('tm_transfer');
        $this->db->where('transfer_id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $transfer_name = $row->transfer_name;
            }

            return $transfer_name;
        } else {
            return "";
        }
    }

    function get_hospital_by_emergency($id) {
        $this->db->select('hospital_id');
        $this->db->from('tp_emergency');
        $this->db->where('emergency_id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $hospital_id = $row->hospital_id;
            }

            return $hospital_id;
        } else {
            return 0;
        }
    }

    function get_hospital_by_forward($id) {
        $this->db->select('hospital_id');
        $this->db->from('tm_forward');
        $this->db->where('forward_id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $hospital_id = $row->hospital_id;
            }

            return $hospital_id;
        } else {
            return 0;
        }
    }

    function get_driver_name_by_id($id) {
        $this->db->select('driver_name');
        $this->db->from('tm_driver');
        $this->db->where('driver_id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $driver_name = $row->driver_name;
            }

            return $driver_name;
        } else {
            return "";
        }
    }

    function get_doctor_name_by_id($id) {
        $this->db->select('doctor_name');
        $this->db->from('tm_doctor');
        $this->db->where('doctor_id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $doctor_name = $row->doctor_name;
            }

            return $doctor_name;
        } else {
            return "";
        }
    }

    function get_nurse_name_by_id($id) {
        $this->db->select('nurse_name');
        $this->db->from('tm_nurse');
        $this->db->where('nurse_id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $nurse_name = $row->nurse_name;
            }

            return $nurse_name;
        } else {
            return "";
        }
    }

    function get_member_firstname_by_id($id) {
        $this->db->select('member_firstname');
        $this->db->from('tm_member');
        $this->db->where('member_id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $member_firstname = $row->member_firstname;
            }

            return $member_firstname;
        } else {
            return "";
        }
    }

    function get_member_lastname_by_id($id) {
        $this->db->select('member_lastname');
        $this->db->from('tm_member');
        $this->db->where('member_id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $member_lastname = $row->member_lastname;
            }

            return $member_lastname;
        } else {
            return "";
        }
    }

    function get_member_phone_by_id($id) {
        $this->db->select('member_phone');
        $this->db->from('tm_member');
        $this->db->where('member_id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $member_phone = $row->member_phone;
            }

            return $member_phone;
        } else {
            return "";
        }
    }

    function get_member_image_by_id($id) {
        $this->db->select('member_image');
        $this->db->from('tm_member');
        $this->db->where('member_id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $member_image = $row->member_image;
            }

            return $member_image;
        } else {
            return "";
        }
    }

    public function getOrderEmergencyByAmbulanceId2($id) {
        $status = array(0,2,3,9);
        $this->db->where(array('ambulance_id' => $id));
        $this->db->where_not_in('emergency_status',$status);
        $query = $this->db->get('tp_emergency');
        $query = $query->result();

        $result = set_emergency_history($query);

        return $result;
    }
     public function getOrderNonEmergencyByAmbulanceId2($id) {
        $status = array(0,2,3,9);
        $this->db->where(array(
            "ambulance_id" => $id,
            "CONCAT((nonemergency_infodate),(' '),(nonemergency_infotime)) <="=> get_ymdhis()
        ));
        $this->db->where_not_in('nonemergency_status',$status);
        $query = $this->db->get('tp_nonemergency');
        $query = $query->result();

        $result = set_nonemergency_history($query);

        return $result;
    }

}
