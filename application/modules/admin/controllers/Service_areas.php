<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service_areas extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        if(!$this->session->userdata('admin_logged_in'))
        {
            redirect(admin_url().'login');
        }
        $this->load->model('service_areas_model');
    }

    public function index()
    {
        $data['service_areas'] = $this->service_areas_model->get_service_areas();
        $this->load->view('service_areas', $data);
    }

    public function add() {
        $this->load->view('add_service_areas');
    }

    public function submit_service_areas()
    {
        $data = $_POST;
        $this->form_validation->set_rules('area_title', 'Area Title', 'trim|required|xss_clean');
        $this->form_validation->set_rules('vertices', 'vertices', 'trim|xss_clean');

        if ($this->form_validation->run($this) == FALSE)
        {
            $finalResult = array('msg' => 'error', 'response'=>validation_errors());
            echo json_encode($finalResult);
            exit;

        } else {

            $status = $this->service_areas_model->create_service_areas($data);

            if($status){
                $finalResult = array('msg' => 'success', 'response'=>'<p>Successfully created.</p>');
                echo json_encode($finalResult);
                exit;
            }else{
                $finalResult = array('msg' => 'error', 'response'=>'<p>Something went wrong!</p>');
                echo json_encode($finalResult);
                exit;
            }
        }
    }

    public function edit($id)
    {
        $data['area_detail'] = $this->service_areas_model->get_service_areas_detail($id);
        if(empty($data['area_detail'])) {
            show_admin404();
        }
        $this->load->view('edit_service_areas', $data);
    }


    public function update_service_areas()
    {
        $data = $_POST;
        $this->form_validation->set_rules('area_title', 'Area Title', 'trim|required|xss_clean');
        $this->form_validation->set_rules('vertices', 'vertices', 'trim|xss_clean');

        if ($this->form_validation->run($this) == FALSE)
        {
            $finalResult = array('msg' => 'error', 'response'=>validation_errors());
            echo json_encode($finalResult);
            exit;

        } else {

            if(empty($data['area_id'])) {
                $finalResult = array('msg' => 'error', 'response'=>'<p>Something went wrong fsdfsdf!</p>');
                echo json_encode($finalResult);
                exit;
            }

            $status = $this->service_areas_model->update_service_areas($data);

            if($status){
                $finalResult = array('msg' => 'success', 'response'=>'<p>Successfully updated.</p>');
                echo json_encode($finalResult);
                exit;
            }else{
                $finalResult = array('msg' => 'error', 'response'=>'<p>Something went wrong fdfdf!</p>');
                echo json_encode($finalResult);
                exit;
            }
        }
    }


    public function delete_record() {

        if($_POST){
            $service_areas_id = $_POST['record_id'];
            $status = $this->service_areas_model->delete_service_areas($service_areas_id);
            if($status > 0){
                $finalResult = array('msg' => 'success', 'response'=>"Service area successfully deleted.");
                echo json_encode($finalResult);
                exit;
            } else {
                $finalResult = array('msg' => 'error', 'response'=>"Something went wrong please try again.");
                echo json_encode($finalResult);
                exit;
            }
        }else{
            show_admin404();
        }
    }

}