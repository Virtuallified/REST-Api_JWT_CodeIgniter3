<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User class.
 * 
 * @extends REST_Controller
 */
    require(APPPATH.'/libraries/REST_Controller.php');
    use Restserver\Libraries\REST_Controller;

class Token extends REST_Controller {

	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
        $this->load->library('Authorization_Token');
		$this->load->model('user_model');
	}

	/**
	 * register function.
	 * 
	 * @access public
	 * @return void
	 */
    
	 public function reGenToken_post() {

		// set variables from the form
		$username = $this->input->post('username');
		if(!empty($username)) {
			$user_id = $this->user_model->get_user_id_from_username($username);
			if (!empty($user_id)) {

				// token regeneration process
				$token_data['uid'] = $user_id;
				$token_data['username'] = $username; 
				$tokenData = $this->authorization_token->generateToken($token_data);
				$final = array();
				$final['access_token'] = $tokenData;
				$final['status'] = true;

				$this->response($final, REST_Controller::HTTP_OK); 
			}
			else
				$this->response(['username not valid'], REST_Controller::HTTP_OK);
		}
		else
			$this->response(['username is required to regenerate token.'], REST_Controller::HTTP_OK);

	 }
}