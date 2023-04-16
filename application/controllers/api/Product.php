<?php

/* Table structure for table `products` */
// CREATE TABLE `products` (
//   `id` int(10) UNSIGNED NOT NULL,
//   `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
//   `price` double NOT NULL,
//   `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
//   `updated_at` datetime DEFAULT NULL
// ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
// ALTER TABLE `products` ADD PRIMARY KEY (`id`);
// ALTER TABLE `products` MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1; COMMIT;

/**
 * Product class.
 * 
 * @extends REST_Controller
 */
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
    public function index_get($id = 0)
    {
        check_authorization();

        if (!empty($id)) {
            $data = $this->Product_model->show($id);
        } else {
            $data = $this->Product_model->show();
        }
        $this->response($data, REST_Controller::HTTP_OK);
    }

    /**
     * INSERT | POST method.
     *
     * @return Response
     */
    public function index_post()
    {
        check_authorization();

        $this->form_validation->set_rules('name', 'Name', 'required|min_length[3]|max_length[20]');
        $this->form_validation->set_rules('price', 'Price', 'required|decimal');

        if (!$this->form_validation->run()) {
            $this->response([
                'status' => FALSE,
                'message' => 'Validation Error.',
                'errors' => $this->form_validation->error_array()
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $input = $this->input->post();
        $data['name'] = @$input['name'];
        $data['price'] = @$input['price'];
        $data = $this->Product_model->insert($input);

        $this->response(['Product created successfully.'], REST_Controller::HTTP_OK);
    }

    /**
     * UPDATE | PUT method.
     *
     * @return Response
     */
    public function update_post($id)
    {
        check_authorization();

        $this->form_validation->set_rules('name', 'Name', 'required|min_length[3]|max_length[20]');
        $this->form_validation->set_rules('price', 'Price', 'required|decimal');

        if (!$this->form_validation->run()) {
            $this->response([
                'status' => FALSE,
                'message' => 'Validation Error.',
                'errors' => $this->form_validation->error_array()
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $input = $this->input->post();
        $data['name'] = @$input['name'];
        $data['price'] = @$input['price'];
        $response = $this->Product_model->update($data, $id);

        if ($response) {
            $this->response(['Product updated successfully.'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['Not updated'], REST_Controller::HTTP_OK);
        }
    }

    /**
     * DELETE method.
     *
     * @return Response
     */
    public function index_delete($id)
    {
        check_authorization();

        $response = $this->Product_model->delete($id);

        if ($response) {
            $this->response(['Product deleted successfully.'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['Not deleted'], REST_Controller::HTTP_OK);
        }
    }
}
