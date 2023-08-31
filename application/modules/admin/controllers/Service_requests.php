<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service_requests extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        if(!$this->session->userdata('admin_logged_in'))
        {
            redirect(admin_url().'login');
        }
        $this->load->model('service_request_model');
    }

    public function index()
    {
        $data['service_requests'] = $this->service_request_model->get_service_requests();
        $this->load->view('service_requests', $data);
    }

    public function get_details()
    {
        $id = $this->input->post('record_id');
        $data['request_detail'] = $this->service_request_model->get_request_detail($id);

        if($data['request_detail']['status']==0) {
            $data['employees'] = $this->service_request_model->get_employees();
        }

        $htmlresponse = $this->load->view('service_request_detail_modal', $data, TRUE);
        $response_arr = array(
            'msg'=> 'success',
            'response'=> $htmlresponse
        );
        echo json_encode($response_arr);
        exit;
    }

    public function assign_request() {

        $data = $this->input->post();

        $this->form_validation->set_rules('employee_id', 'Employee', 'trim|required|xss_clean');

        if ($this->form_validation->run($this) == FALSE)
        {
            $finalResult = array('msg' => 'error', 'response'=>validation_errors());
            echo json_encode($finalResult);
            exit;

        } else {

            if(empty($data['request_id'])) {
                $finalResult = array('msg' => 'error', 'response'=>'Something went wrong');
                echo json_encode($finalResult);
                exit;
            }

            $status = $this->service_request_model->assign_request($data);
            if($status){

                // $res = sendNotification(array('88C94AB72AA2DC44'), array(
                //     "title" => "Sample Message",
                //     "body" => "This is Test message body"
                // ));

                $finalResult = array('msg' => 'success', 'response'=>'Successfully assigned.');
                echo json_encode($finalResult);
                exit;
            }else{
                $finalResult = array('msg' => 'error', 'response'=>'Something went wrong');
                echo json_encode($finalResult);
                exit;
            }
        }

    }

}