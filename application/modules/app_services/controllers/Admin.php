<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin_model');
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

            $email = xss_clean(trim($_POST['email']));
            $password = xss_clean(trim($_POST['password']));

            if (!$this->isEmail($email)) {
                $finalResult = array('code' => 201, 'msg' => 'Please enter a valid email.');
                header('Content-Type: application/json');
                echo json_encode($finalResult);
                exit;
            }

            if ($email != '' && $password != '') {

                $user = $this->admin_model->get_login($email, $password);
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


    public function logout()
    {
        $finalResult = array();

        $_POST = json_decode($this->input->raw_input_stream, true);
        if($_POST) {

            $token = $this->input->get_request_header('auth-token', TRUE);
            if(authicate_admin($token)) {
                $result = $this->admin_model->logout($token);
                if($result) {
                    $finalResult = array('code' => 200, 'msg' => 'Success');
                } else {
                    $finalResult = array('code' => 200, 'msg' => 'Success');
                }
            } else {
                $finalResult = array('code' => 401, 'msg' => 'Authentication error');
            }

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
        if(authicate_admin($token)) {
            $data = array();
            $data['service_types'] = $this->admin_model->get_service_types();
            $finalResult = array('code' => 200, 'msg' => 'Success', 'data' => $data);
        } else {
            $finalResult = array('code' => 401, 'msg' => 'Authentication error');
        }

        header('Content-Type: application/json');
        echo json_encode($finalResult);
        exit;
    }

    public function getalldata()
    {
        $finalResult = array();
        $token = $this->input->get_request_header('auth-token', TRUE);
        if(authicate_admin($token)) {
            $data = array();
            $data['service_requests'] = $this->admin_model->get_service_requests();
            $data['feedbacks'] = $this->admin_model->get_feedbacks();
            $data['tickets'] = $this->admin_model->get_tickets();
            $finalResult = array('code' => 200, 'msg' => 'Success', 'data' => $data);
        } else {
            $finalResult = array('code' => 401, 'msg' => 'Authentication error');
        }

        header('Content-Type: application/json');
        echo json_encode($finalResult);
        exit;
    }

    public function getallrequests()
    {
        $finalResult = array();
        $token = $this->input->get_request_header('auth-token', TRUE);
        if(authicate_admin($token)) {
            $data = array();
            $data['service_requests'] = $this->admin_model->get_service_requests();
            $finalResult = array('code' => 200, 'msg' => 'Success', 'data' => $data);
        } else {
            $finalResult = array('code' => 401, 'msg' => 'Authentication error');
        }

        header('Content-Type: application/json');
        echo json_encode($finalResult);
        exit;
    }

    public function getallemployees()
    {
        $finalResult = array();
        $token = $this->input->get_request_header('auth-token', TRUE);
        if(authicate_admin($token)) {
            $data = array();
            $data['employees'] = $this->admin_model->get_employees();
            $finalResult = array('code' => 200, 'msg' => 'Success', 'data' => $data);
        } else {
            $finalResult = array('code' => 401, 'msg' => 'Authentication error');
        }

        header('Content-Type: application/json');
        echo json_encode($finalResult);
        exit;
    }

    public function getallrequestswithlazyload()
    {
        $finalResult = array();
        $token = $this->input->get_request_header('auth-token', TRUE);
        if(authicate_admin($token)) {
            $_POST = json_decode($this->input->raw_input_stream, true);
            if($_POST) {
                $page = 1;
                $page_size = 50;
                if(!empty($_POST['page'])) {
                    $page = xss_clean(trim($_POST['page']));
                }

                if(!empty($_POST['page_size'])) {
                    $page_size = xss_clean(trim($_POST['page_size']));
                }

                $data = array();
                $data['service_requests'] = $this->admin_model->getallrequestswithlazyload($page, $page_size);
                $finalResult = array('code' => 200, 'msg' => 'Success', 'data' => $data);
            } else {
                $finalResult = array('code' => 400, 'msg' => 'Invalid request.');
            }

        } else {
            $finalResult = array('code' => 401, 'msg' => 'Authentication error');
        }

        header('Content-Type: application/json');
        echo json_encode($finalResult);
        exit;
    }

    public function getrequestdetail($id)
    {
        $finalResult = array();
        $token = $this->input->get_request_header('auth-token', TRUE);
        if(authicate_admin($token)) {
            if(!empty($id)) {
                $data = array();
                $data['request_detail'] = $this->admin_model->get_request_detail($id);
                if(empty($data['request_detail'])) {
                    $finalResult = array('code' => 201, 'msg' => 'Record not found');
                } else {
                    $finalResult = array('code' => 200, 'msg' => 'Success', 'data' => $data);
                }
            } else {
                $finalResult = array('code' => 400, 'msg' => 'Invalid request.');
            }

        } else {
            $finalResult = array('code' => 401, 'msg' => 'Authentication error');
        }

        header('Content-Type: application/json');
        echo json_encode($finalResult);
        exit;
    }

    public function getalltickes()
    {
        $finalResult = array();
        $token = $this->input->get_request_header('auth-token', TRUE);
        if(authicate_admin($token)) {
            $data = array();
            $data['tickets'] = $this->admin_model->get_tickets();
            $finalResult = array('code' => 200, 'msg' => 'Success', 'data' => $data);
        } else {
            $finalResult = array('code' => 401, 'msg' => 'Authentication error');
        }

        header('Content-Type: application/json');
        echo json_encode($finalResult);
        exit;
    }

    public function getallticketswithlazyload()
    {
        $finalResult = array();
        $token = $this->input->get_request_header('auth-token', TRUE);
        if(authicate_admin($token)) {
            $_POST = json_decode($this->input->raw_input_stream, true);
            if($_POST) {
                $page = 1;
                $page_size = 50;
                if(!empty($_POST['page'])) {
                    $page = xss_clean(trim($_POST['page']));
                }

                if(!empty($_POST['page_size'])) {
                    $page_size = xss_clean(trim($_POST['page_size']));
                }

                $data = array();
                $data['tickets'] = $this->admin_model->getallticketswithlazyload($page, $page_size);
                $finalResult = array('code' => 200, 'msg' => 'Success', 'data' => $data);
            } else {
                $finalResult = array('code' => 400, 'msg' => 'Invalid request.');
            }

        } else {
            $finalResult = array('code' => 401, 'msg' => 'Authentication error');
        }

        header('Content-Type: application/json');
        echo json_encode($finalResult);
        exit;
    }

    public function getticketdetail($id)
    {
        $finalResult = array();
        $token = $this->input->get_request_header('auth-token', TRUE);
        if(authicate_admin($token)) {
            if(!empty($id)) {
                $data = array();
                $data['ticket_detail'] = $this->admin_model->get_ticket_detail($id);
                if(empty($data['ticket_detail'])) {
                    $finalResult = array('code' => 201, 'msg' => 'Record not found');
                } else {
                    $finalResult = array('code' => 200, 'msg' => 'Success', 'data' => $data);
                }
            } else {
                $finalResult = array('code' => 400, 'msg' => 'Invalid request.');
            }

        } else {
            $finalResult = array('code' => 401, 'msg' => 'Authentication error');
        }

        header('Content-Type: application/json');
        echo json_encode($finalResult);
        exit;
    }

    public function getallfeedbacks()
    {
        $finalResult = array();
        $token = $this->input->get_request_header('auth-token', TRUE);
        if(authicate_admin($token)) {
            $data = array();
            $data['feedbacks'] = $this->admin_model->get_feedbacks();
            $finalResult = array('code' => 200, 'msg' => 'Success', 'data' => $data);
        } else {
            $finalResult = array('code' => 401, 'msg' => 'Authentication error');
        }

        header('Content-Type: application/json');
        echo json_encode($finalResult);
        exit;
    }


    public function getallfeedbackswithlazyload()
    {
        $finalResult = array();
        $token = $this->input->get_request_header('auth-token', TRUE);
        if(authicate_admin($token)) {
            $_POST = json_decode($this->input->raw_input_stream, true);
            if($_POST) {
                $page = 1;
                $page_size = 50;
                if(!empty($_POST['page'])) {
                    $page = xss_clean(trim($_POST['page']));
                }

                if(!empty($_POST['page_size'])) {
                    $page_size = xss_clean(trim($_POST['page_size']));
                }

                $data = array();
                $data['feedbacks'] = $this->admin_model->getallfeedbackswithlazyload($page, $page_size);
                $finalResult = array('code' => 200, 'msg' => 'Success', 'data' => $data);
            } else {
                $finalResult = array('code' => 400, 'msg' => 'Invalid request.');
            }

        } else {
            $finalResult = array('code' => 401, 'msg' => 'Authentication error');
        }

        header('Content-Type: application/json');
        echo json_encode($finalResult);
        exit;
    }

    public function getfeedbackdetail($id)
    {
        $finalResult = array();
        $token = $this->input->get_request_header('auth-token', TRUE);
        if(authicate_admin($token)) {
            if(!empty($id)) {
                $data = array();
                $data['feedback_detail'] = $this->admin_model->get_feedback_detail($id);
                if(empty($data['feedback_detail'])) {
                    $finalResult = array('code' => 201, 'msg' => 'Record not found');
                } else {
                    $finalResult = array('code' => 200, 'msg' => 'Success', 'data' => $data);
                }
            } else {
                $finalResult = array('code' => 400, 'msg' => 'Invalid request.');
            }

        } else {
            $finalResult = array('code' => 401, 'msg' => 'Authentication error');
        }

        header('Content-Type: application/json');
        echo json_encode($finalResult);
        exit;
    }

}