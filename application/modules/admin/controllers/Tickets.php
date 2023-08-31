<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tickets extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        if(!$this->session->userdata('admin_logged_in'))
        {
            redirect(admin_url().'login');
        }
        $this->load->model('tickets_model');
    }

    public function index()
    {
        $data['tickets'] = $this->tickets_model->get_tickets();
        $this->load->view('tickets', $data);
    }

    public function get_details()
    {
        $id = $this->input->post('record_id');
        $data['ticket_detail'] = $this->tickets_model->get_ticket_detail($id);

        if($data['ticket_detail']['status']==1) {
            $data['employees'] = $this->tickets_model->get_employees();
        }

        $htmlresponse = $this->load->view('ticket_detail_modal', $data, TRUE);
        $response_arr = array(
            'msg'=> 'success',
            'response'=> $htmlresponse
        );
        echo json_encode($response_arr);
        exit;
    }

    public function assign_ticket() {

        $data = $this->input->post();

        $this->form_validation->set_rules('employee_id', 'Employee', 'trim|required|xss_clean');

        if ($this->form_validation->run($this) == FALSE)
        {
            $finalResult = array('msg' => 'error', 'response'=>validation_errors());
            echo json_encode($finalResult);
            exit;

        } else {

            if(empty($data['ticket_id'])) {
                $finalResult = array('msg' => 'error', 'response'=>'Something went wrong');
                echo json_encode($finalResult);
                exit;
            }

            $status = $this->tickets_model->assign_ticket($data);
            if($status){

                // sendNotification(array($device_token1), array(
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