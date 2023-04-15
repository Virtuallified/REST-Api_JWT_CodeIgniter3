<?php

/* Table structure for table `products` */
// CREATE TABLE `products` (
//   `id` int(10) UNSIGNED NOT NULL,
//   `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
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
    }

    /**
     * SHOW | GET method.
     *
     * @return Response
     */
    public function index_get($id = 0)
    {
        $decodedToken = $this->authorization_token->validateToken();
        if ($decodedToken['status']) {
            if (!empty($id)) {
                $data = $this->Product_model->show($id);
            } else {
                $data = $this->Product_model->show();
            }
            $this->response($data, REST_Controller::HTTP_OK);
        } else {
            $this->response($decodedToken);
        }
    }

    /**
     * INSERT | POST method.
     *
     * @return Response
     */
    public function index_post()
    {
        $decodedToken = $this->authorization_token->validateToken();
        if ($decodedToken['status']) {
            $input = $this->input->post();
            $data['name'] = @$input['name'];
            $data['price'] = @$input['price'];
            $data = $this->Product_model->insert($input);

            $this->response(['Product created successfully.'], REST_Controller::HTTP_OK);
        } else {
            $this->response($decodedToken);
        }
    }

    /**
     * UPDATE | PUT method.
     *
     * @return Response
     */
    public function update_post($id)
    {
        $decodedToken = $this->authorization_token->validateToken();
        if ($decodedToken['status']) {
            $input = $this->input->post();
            $data['name'] = @$input['name'];
            $data['price'] = @$input['price'];
            $response = $this->Product_model->update($data, $id);

            if ($response) {
                $this->response(['Product updated successfully.'], REST_Controller::HTTP_OK);
            } else {
                $this->response(['Not updated'], REST_Controller::HTTP_OK);
            }
        } else {
            $this->response($decodedToken);
        }
    }

    /**
     * DELETE method.
     *
     * @return Response
     */
    public function index_delete($id)
    {
        $decodedToken = $this->authorization_token->validateToken();
        if ($decodedToken['status']) {
            // ------- Main Logic part -------
            $response = $this->Product_model->delete($id);

            $response > 0 ? $this->response(['Product deleted successfully.'], REST_Controller::HTTP_OK) : $this->response(['Not deleted'], REST_Controller::HTTP_OK);
            // ------------- End -------------
        } else {
            $this->response($decodedToken);
        }
    }
}
