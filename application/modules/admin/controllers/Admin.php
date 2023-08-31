<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        if(!$this->session->userdata('admin_logged_in'))
        {
            redirect(admin_url().'login');
        }
    }

    public function index()
    {

        $this->load->view('dashboard');
    }

    public function dashboard()
    {
        $this->load->view('dashboard');
    }

    public function change_password()
    {
        $this->load->view('change_password');
    }

    public function update_password()
    {
        $data = $_POST;
        $this->form_validation->set_rules('old_password', 'Old Password', 'trim|required|xss_clean|callback_check_old_password');
        $this->form_validation->set_rules('new_password', 'New Password', 'trim|required|xss_clean|callback_check_new_password');
        $this->form_validation->set_rules('c_password', 'Confirm Password', 'trim|required|matches[new_password]|xss_clean');
        if ($this->form_validation->run($this) == FALSE)
        {
            $finalResult = array('msg' => 'error', 'response'=>validation_errors());
            echo json_encode($finalResult);
            exit;
        }else{
            $status = $this->admin_model->change_admin_password($data);
            if($status){
                $finalResult = array('msg' => 'success', 'response'=>'Your password successfully changed!');
                echo json_encode($finalResult);
                exit;
            }else{
                $finalResult = array('msg' => 'error', 'response'=>'Something went wrong!');
                echo json_encode($finalResult);
                exit;
            }
        }
    }

    public function check_old_password()
    {
        $data = $_POST;
        $status = $this->admin_model->check_old_password($data);
        if ($status > 0)
        {
            return TRUE;
        }
        else
        {
            $this->form_validation->set_message('check_old_password', 'Old password is wrong.');
            return FALSE;
        }
    }

    public function check_new_password()
    {
        $data = $_POST;
        $status = $this->admin_model->check_new_password($data);
        if ($status > 0)
        {
            $this->form_validation->set_message('check_new_password', 'Your new password must be different.');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

}