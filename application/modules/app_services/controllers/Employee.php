<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('employee_model');
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

            if (!$this->isEmail($email)) {
                $finalResult = array('code' => 201, 'msg' => 'Please enter a valid email.');
                header('Content-Type: application/json');
                echo json_encode($finalResult);
                exit;
            }

            if ($email != '' && $password != '') {

                $user = $this->employee_model->get_login($data);
                if(!empty($user['auth_token'])) {
                    $finalResult = array('code' => 200, 'msg' => 'Successfully loggedin.', 'data' => $user);
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
        if(authicate_user($token, 2)) {
            $user = $this->employee_model->getuserdetail($token);
            $finalResult = array('code' => 200, 'msg' => 'Success', 'data' => $user);
        } else {
            $finalResult = array('code' => 400, 'msg' => 'Invalid request.');
        }

        header('Content-Type: application/json');
        echo json_encode($finalResult);
        exit;
    }

    public function logout()
    {
        $finalResult = array();
        $token = $this->input->get_request_header('auth-token', TRUE);
        if(authicate_user($token, 2)) {
            $this->employee_model->logoutuser($token);
            $finalResult = array('code' => 200, 'msg' => 'Success');
        } else {
            $finalResult = array('code' => 400, 'msg' => 'Invalid request.');
        }

        header('Content-Type: application/json');
        echo json_encode($finalResult);
        exit;
    }

    public function getassignedjobs()
    {
        $finalResult = array();
        $token = $this->input->get_request_header('auth-token', TRUE);
        if(authicate_user($token, 2)) {
            $data['assignedJobs'] = $this->employee_model->getassignedjobs($token);
            $finalResult = array('code' => 200, 'msg' => 'Success' , 'data' => $data);
        } else {
            $finalResult = array('code' => 400, 'msg' => 'Invalid request.');
        }

        header('Content-Type: application/json');
        echo json_encode($finalResult);
        exit;
    }

}