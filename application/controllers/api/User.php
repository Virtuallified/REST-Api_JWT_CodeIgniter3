<?php
defined('BASEPATH') or exit('No direct script access allowed');

require(APPPATH . '/libraries/REST_Controller.php');

use Restserver\Libraries\REST_Controller;

class User extends REST_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Authorization_Token');
		$this->load->model('user_model');
	}

	public function register_post()
	{
		// set validation rules
		$this->form_validation->set_rules('username', 'Username', 'trim|required|alpha_numeric|min_length[4]|max_length[20]|is_unique[users.username]');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[100]|is_unique[users.email]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');

		// run validation rules on the fields
		if (!$this->form_validation->run()) {
			// return errors in case of validation error
			$this->response([
				'status' => FALSE,
				'message' => 'Validation Error.',
				'errors' => $this->form_validation->error_array()
			], REST_Controller::HTTP_BAD_REQUEST);
		}

		// set variables from the form
		$username = $this->input->post('username');
		$email = $this->input->post('email');
		$password = $this->input->post('password');

		// creating user
		$id = $this->user_model->create_user($username, $email, $password);

		if (!$id) {
			// user not created for some reason
			$this->response([
				'status' => FALSE,
				'message' => 'There was a problem creating your new account. Please try again.'
			], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
		}

		// success message
		$this->response([
			'status' => TRUE,
			'message' => 'Your account has been created. Please login.'
		], REST_Controller::HTTP_OK);
	}

	public function login_post()
	{

		// set validation rules
		$this->form_validation->set_rules('username', 'Username', 'required|alpha_numeric');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if (!$this->form_validation->run()) {
			$this->response([
				'status' => FALSE,
				'message' => 'Validation Error.',
				'errors' => $this->form_validation->error_array()
			], REST_Controller::HTTP_BAD_REQUEST);
		}

		// set variables from the form
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		// logging in
		if (!$this->user_model->resolve_user_login($username, $password)) {
			// wrong credentials
			$this->response([
				'status' => FALSE,
				'message' => 'Wrong username or password.',
			], REST_Controller::HTTP_BAD_REQUEST);
		}

		// user login ok
		$user_id = $this->user_model->get_user_id_from_username($username);
		$user = $this->user_model->get_user($user_id);

		// gethering data to generate token
		$token_data['uid'] = $user_id;
		$token_data['username'] = $user->username;

		// generate token
		$tokenData = $this->authorization_token->generateToken($token_data);

		// send token
		$this->response([
			'status' => TRUE,
			'message' => 'Login success!',
			'access_token' => $tokenData
		], REST_Controller::HTTP_OK);
	}
}
