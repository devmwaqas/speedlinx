<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct()
	{
		parent::__construct();		
		$this->load->library(admin_controller().'login_lib');
		$this->load->model(admin_controller().'login_model');
		if($this->session->userdata('admin_logged_in'))
		{
			redirect(admin_url().'dashboard/');
		}
		
	}
	public function index()
	{
		$this->load->view('login');
	}
	public function login_verify()
	{
		if($_POST){
			$email=trim($this->input->post('email'));
			$password=trim($this->input->post('password'));
			if($this->login_lib->validate_login($email, $password)) {
				redirect(admin_url());
			} else {

				$this->session->set_flashdata('email',$this->input->post('email'));
				$this->session->set_flashdata('login_error','Incorrect Email/Password or Combination');
				redirect(admin_url().'login');
			}

		} else {
			$this->session->set_flashdata('email','');
			$this->session->set_flashdata('login_error','Incorrect Email/Password or Combination');
			redirect(admin_url().'login');
		}

	}


}
