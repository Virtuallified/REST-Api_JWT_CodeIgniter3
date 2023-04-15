<?php
defined('BASEPATH') or exit('No direct script access allowed');

require(APPPATH . '/libraries/REST_Controller.php');

use Restserver\Libraries\REST_Controller;

class Test_api extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('Authorization_Token');
	}

	public function verify_token_post()
	{
		$decodedToken = $this->authorization_token->validateToken();
		$this->response($decodedToken);
	}
}
