<?php

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Product extends REST_Controller
{

    /**
     * CONSTRUCTOR | LOAD MODEL
     *
     * @return Response
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library('Authorization_Token');
        $this->load->model('Product_model');
        $this->load->helper('api_helper');
        $this->load->library('form_validation');
    }

    /**
     * SHOW | GET method.
     *
     * @return Response
     */
    public function list_get()
    {
        check_authorization();

        $data = $this->Product_model->list();

        $this->response([
            'status' => TRUE,
            'data' => $data
        ], REST_Controller::HTTP_OK);
    }

    public function show_get($id = 0)
    {
        check_authorization();

        if (empty($id)) {
            $this->response([
                'status' => FALSE,
                'message' => 'Product id param not found.',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $data = $this->Product_model->show($id);

        if (empty($data)) {
            $this->response([
                'status' => FALSE,
                'message' => 'Product not found.',
            ], REST_Controller::HTTP_NOT_FOUND);
        }

        $this->response([
            'status' => TRUE,
            'data' => $data
        ], REST_Controller::HTTP_OK);
    }

    /**
     * INSERT | POST method.
     *
     * @return Response
     */
    public function insert_post()
    {
        check_authorization();

        $this->form_validation->set_rules('name', 'Name', 'required|trim|min_length[3]|max_length[20]');
        $this->form_validation->set_rules('price', 'Price', 'required|decimal');

        if (!$this->form_validation->run()) {
            $this->response([
                'status' => FALSE,
                'message' => 'Validation Error.',
                'errors' => $this->form_validation->error_array()
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $input = $this->input->post();
        $this->Product_model->insert($input);

        $this->response([
            'status' => TRUE,
            'message' => 'Product created successfully.'
        ], REST_Controller::HTTP_OK);
    }

    /**
     * UPDATE | PUT method.
     *
     * @return Response
     */
    public function update_post($id)
    {
        check_authorization();

        $this->form_validation->set_rules('name', 'Name', 'required|trim|min_length[3]|max_length[20]');
        $this->form_validation->set_rules('price', 'Price', 'required|decimal');

        if (!$this->form_validation->run()) {
            $this->response([
                'status' => FALSE,
                'message' => 'Validation Error.',
                'errors' => $this->form_validation->error_array()
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $input = $this->input->post();
        $response = $this->Product_model->update($input, $id);

        if (empty($response)) {
            $this->response([
                'status' => FALSE,
                'message' => 'Not updated'
            ], REST_Controller::HTTP_OK);
        }

        $this->response([
            'status' => TRUE,
            'message' => 'Product updated successfully.'
        ], REST_Controller::HTTP_OK);
    }

    /**
     * DELETE method.
     *
     * @return Response
     */
    public function delete_delete($id)
    {
        check_authorization();

        $response = $this->Product_model->delete($id);

        if (empty($response)) {
            $this->response([
                'status' => FALSE,
                'message' => 'Not deleted'
            ], REST_Controller::HTTP_NOT_FOUND);
        }

        $this->response([
            'status' => TRUE,
            'message' => 'Product deleted successfully.'
        ], REST_Controller::HTTP_OK);
    }
}
