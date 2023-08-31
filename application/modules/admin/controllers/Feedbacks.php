<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Feedbacks extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        if(!$this->session->userdata('admin_logged_in'))
        {
            redirect(admin_url().'login');
        }
        $this->load->model('feedback_model');
    }

    public function index()
    {
        $data['feedbacks'] = $this->feedback_model->get_feedbacks();
        $this->load->view('feedbacks', $data);
    }
}