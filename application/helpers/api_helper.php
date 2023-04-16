<?php

use Restserver\Libraries\REST_Controller;

function check_authorization() {
    $ci = &get_instance();

    // verificando se token foi enviado
    $headers = $ci->input->request_headers();
    if (empty($headers['jwt-authorization'])) {
        $ci->response([
            'status' => FALSE,
            'message' => 'Token is not defined (header param "jwt-authorization" is missing).'
        ], REST_Controller::HTTP_UNAUTHORIZED);
    }

    // verificando se token é válido
    $token_validation = $ci->authorization_token->validateToken();
    if ($token_validation['status'] === FALSE) {
        $ci->response($token_validation, REST_Controller::HTTP_UNAUTHORIZED);
    }

    // verificando se usuário está ativo
    $user_id = $token_validation["data"]->uid;
    $ci->load->model('User_model');
    $user = $ci->User_model->get_user($user_id);
    if (@$user->username !== $token_validation["data"]->username) {
        $ci->response([
            'status' => FALSE,
            'message' => 'User in Token not found. Try login again.'
        ], REST_Controller::HTTP_UNAUTHORIZED);
    }
}

function format_validation_errors_for_api($validation_errors) {
    $validation_errors = explode("\n", strip_tags(validation_errors()));
    $validation_errors = array_filter($validation_errors);
    return $validation_errors;
}