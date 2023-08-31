<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('customer_model');
    }

    public function isEmail($email) {
        if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        else {
            return false;
        }
    }

    public function login() {

        $finalResult = array();

        $_POST = json_decode($this->input->raw_input_stream, true);
        if($_POST) {

            $data['email'] = xss_clean(trim($_POST['email']));
            $data['password'] = xss_clean(trim($_POST['password']));

            $data['platform'] = xss_clean(trim($_POST['platform']));
            $data['device_reg_id'] = xss_clean(trim($_POST['device_reg_id']));

            if (!$this->isEmail($data['email'])) {
                $finalResult = array('code' => 201, 'msg' => 'Please enter a valid email.');
                header('Content-Type: application/json');
                echo json_encode($finalResult);
                exit;
            }

            if ($data['email'] != '' && $data['password'] != '') {

                $user = $this->customer_model->get_login($data);

                if(!empty($user['auth_token'])) {

                    $isGuest = $user['is_guest'] ? true: false;

                    $finalResult = array('code' => 200, 'msg' => 'Successfully loggedin.', 'isGuest' => $isGuest, 'data' => array("auth_token" => $user['auth_token']));
                } else {
                    $finalResult = array('code' => 500, 'msg' => 'Please enter valid username/password.');
                }

            } else {
                $finalResult = array('code' => 201, 'msg' => 'Please post all required parameters!');
            }

        } else {
            $finalResult = array('code' => 400, 'msg' => 'Invalid request.');
        }

        header('Content-Type: application/json');
        echo json_encode($finalResult);
        exit;
    }

    public function getuserdetail() {
        $finalResult = array();
        $token = $this->input->get_request_header('auth-token', TRUE);
        if(authicate_user($token)) {
            $user = $this->customer_model->getuserdetail($token);
            $finalResult = array('code' => 200, 'msg' => 'Success', 'data' => $user);
        } else {
            $finalResult = array('code' => 400, 'msg' => 'Invalid request.');
        }

        header('Content-Type: application/json');
        echo json_encode($finalResult);
        exit;
    }

    public function guestuser()
    {
        $finalResult = array();
        $token = $this->customer_model->guestuser();
        if(authicate_user($token)) {
            $data['auth_token'] = $token;
            $finalResult = array('code' => 200, 'msg' => 'Success', 'isGuest' => true, 'data' => $data);
        } else {
            $finalResult = array('code' => 400, 'msg' => 'Invalid request.');
        }

        header('Content-Type: application/json');
        echo json_encode($finalResult);
        exit;
    }

    public function logoutuser()
    {
        $finalResult = array();
        $token = $this->input->get_request_header('auth-token', TRUE);
        if(authicate_user($token)) {
            $this->customer_model->logoutuser($token);
            $finalResult = array('code' => 200, 'msg' => 'Success');
        } else {
            $finalResult = array('code' => 400, 'msg' => 'Invalid request.');
        }

        header('Content-Type: application/json');
        echo json_encode($finalResult);
        exit;
    }

    public function getservicetypes() {
        $finalResult = array();
        $token = $this->input->get_request_header('auth-token', TRUE);
        if(authicate_user($token)) {
            $data = array();
            $data['service_types'] = $this->customer_model->get_service_types();
            $finalResult = array('code' => 200, 'msg' => 'Success', 'data' => $data);
        } else {
            $finalResult = array('code' => 401, 'msg' => 'Authentication error');
        }

        header('Content-Type: application/json');
        echo json_encode($finalResult);
        exit;
    }

    public function check_services_area()
    {
        $finalResult = array();
        $_POST = json_decode($this->input->raw_input_stream, true);
        if($_POST) {
            $token = $this->input->get_request_header('auth-token', TRUE);
            if(!authicate_user($token)) {
                $finalResult = array('code' => 401, 'msg' => 'Authentication error');
                header('Content-Type: application/json');
                echo json_encode($finalResult);
                exit;
            }

            $latitude = $_POST["latitude"];
            $longitude = $_POST["longitude"];

            $areas = $this->customer_model->get_service_areas();
            foreach ($areas as $area) {

                $new_array = array();
                $vertices_x = array();
                $vertices_y = array();
                $new_value = str_replace("),",");",$area['lat_long']);
                $new_value = str_replace(");",";",$new_value);
                $new_value = str_replace("(","",$new_value);
                $new_value = str_replace(")","",$new_value);
                $new_array = explode(";",$new_value);

                foreach ($new_array as $key => $value) {
                    $lat_long = explode(", ",$value);
                    $vertices_y[] = $lat_long[0];
                    $vertices_x[] = $lat_long[1];
                }

                // print_r($vertices_x);
                // echo "<br>";
                // print_r($vertices_y);

                $points_polygon = count($vertices_x);

                if ($this->is_in_polygon($points_polygon, $vertices_x, $vertices_y, $longitude, $latitude)) {

                    $finalResult = array('code' => 200, 'msg' => 'service available in this area.', 'serviceAvailable' => true);
                    header('Content-Type: application/json');
                    echo json_encode($finalResult);
                    exit;

                }
            }

            $finalResult = array('code' => 201, 'msg' => 'Not in service area.', 'serviceAvailable' => false);

        } else {
            $finalResult = array('code' => 400, 'msg' => 'Invalid request.');
        }

        header('Content-Type: application/json');
        echo json_encode($finalResult);
        exit;



    }

    function is_in_polygon($points_polygon, $vertices_x, $vertices_y, $longitude_x, $latitude_y)
    {
        $i = $j = $c = $point = 0;
        for ($i = 0, $j = $points_polygon-1; $i < $points_polygon; $j = $i++) {
            $point = $i;
            if($point == $points_polygon) { $point = 0; }

            if ( (($vertices_y[$point]  >  $latitude_y != ($vertices_y[$j] > $latitude_y)) && ($longitude_x < ($vertices_x[$j] - $vertices_x[$point]) * ($latitude_y - $vertices_y[$point]) / ($vertices_y[$j] - $vertices_y[$point]) + $vertices_x[$point]))) {
                $c = !$c;
            }
        }
        return $c;
    }

    public function submit_request()
    {
        $finalResult = array();
        $_POST = json_decode($this->input->raw_input_stream, true);
        if($_POST) {
            $token = $this->input->get_request_header('auth-token', TRUE);
            if(!authicate_user($token)) {
                $finalResult = array('code' => 401, 'msg' => 'Authentication error');
                header('Content-Type: application/json');
                echo json_encode($finalResult);
                exit;
            }

            $data['auth_token'] = xss_clean(trim($token));

            $data['full_name'] = xss_clean(trim($_POST['full_name']));
            $data['phone'] = xss_clean(trim($_POST['phone']));
            $data['email'] = xss_clean(trim($_POST['email']));
            $data['cnic'] = xss_clean(trim($_POST['cnic']));
            $data['address_line_1'] =xss_clean( trim($_POST['address_line_1']));
            $data['address_line_2'] =xss_clean( trim($_POST['address_line_2']));
            $data['service_type'] =xss_clean( trim($_POST['service_type']));
            $data['connection_type'] =xss_clean( trim($_POST['connection_type']));
            $data['tv_service_type'] =xss_clean( trim($_POST['tv_service_type']));
            $data['no_digital_boxes'] =xss_clean( trim($_POST['no_digital_boxes']));

            if ($data['full_name'] != '' && $data['phone'] != '' && $data['email'] != '' && $data['cnic'] != '' && $data['address_line_1'] != '' && $data['address_line_2'] != '' && $data['service_type'] != '' && $data['connection_type'] != ''&& $data['tv_service_type'] != ''&& $data['no_digital_boxes'] != '') {

                $result = $this->customer_model->submit_request($data);
                if($result) {
                    $finalResult = array('code' => 200, 'msg' => 'Request successfully submitted.');
                } else {
                    $finalResult = array('code' => 500, 'msg' => 'Internal server error.');
                }

            } else {
                $finalResult = array('code' => 201, 'msg' => 'Please post all required parameters!');
            }

        } else {
            $finalResult = array('code' => 400, 'msg' => 'Invalid request.');
        }

        header('Content-Type: application/json');
        echo json_encode($finalResult);
        exit;

    }

    public function submit_feedback() {

        $finalResult = array();

        $_POST = json_decode($this->input->raw_input_stream, true);
        if($_POST) {
            $token = $this->input->get_request_header('auth-token', TRUE);
            if(!authicate_user($token)) {
                $finalResult = array('code' => 401, 'msg' => 'Authentication error');
                header('Content-Type: application/json');
                echo json_encode($finalResult);
                exit;
            }

            $data['mobile'] = xss_clean(trim($_POST['mobile']));
            $data['message'] = xss_clean(trim($_POST['message']));

            if ($data['mobile'] != '' && $data['message'] != '') {

                $result = $this->customer_model->submit_feedback($data);
                if($result) {
                    $finalResult = array('code' => 200, 'msg' => 'Feedback successfully submitted.');
                } else {
                    $finalResult = array('code' => 500, 'msg' => 'Internal server error.');
                }

            } else {
                $finalResult = array('code' => 201, 'msg' => 'Please post all required parameters!');
            }

        } else {
            $finalResult = array('code' => 400, 'msg' => 'Invalid request.');
        }

        header('Content-Type: application/json');
        echo json_encode($finalResult);
        exit;
    }

    public function submit_ticket() {

        $finalResult = array();

        $_POST = json_decode($this->input->raw_input_stream, true);
        if($_POST) {
            $token = $this->input->get_request_header('auth-token', TRUE);
            if(!authicate_user($token)) {
                $finalResult = array('code' => 401, 'msg' => 'Authentication error');
                header('Content-Type: application/json');
                echo json_encode($finalResult);
                exit;
            }

            if(!is_registered_user($token)) {
                $finalResult = array('code' => 401, 'msg' => 'Assess denied.');
                header('Content-Type: application/json');
                echo json_encode($finalResult);
                exit;
            }

            $data['auth_token'] = xss_clean(trim($token));
            $data['service_type'] = xss_clean(trim($_POST['service_type']));
            $data['issue_type'] = xss_clean(trim($_POST['issue_type']));
            $data['description'] = xss_clean(trim($_POST['description']));
            $data['availablity_time'] = xss_clean(trim($_POST['availablity_time']));

            if ($data['service_type'] != '' && $data['issue_type'] != '' && $data['description'] != '' && $data['availablity_time'] != '') {

                $result = $this->customer_model->submit_ticket($data);
                if($result) {
                    $finalResult = array('code' => 200, 'msg' => 'Ticket successfully submitted.');
                } else {
                    $finalResult = array('code' => 500, 'msg' => 'Internal server error.');
                }

            } else {
                $finalResult = array('code' => 201, 'msg' => 'Please post all required parameters!');
            }

        } else {
            $finalResult = array('code' => 400, 'msg' => 'Invalid request.');
        }

        header('Content-Type: application/json');
        echo json_encode($finalResult);
        exit;
    }

}