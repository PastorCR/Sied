<?php

/**
 * This class is responsible for sign up, sign in and logout.
 *
 * @copyright Copyright (c) 2014, Felipe Lunardi Farias <ffarias.dev@gmail.com>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
require '../database/departamentoData.php';

class departamentos extends Rest implements interfaceApi {

    /** @var string|null Should contain the name of this class. */
    public $class = null;

    /** @var string|null Should contain a method of this API (users). */
    public $method = null;

    public function __construct($class, $method) {

        parent::__construct();

        $this->class = $class;
        $this->method = $method;
    }

    /**
     * A simple response for this API
     * @param $status  status (error, success)
     * @param $message message/response
     * @param $code    HTTP status codes (200, 201, 204, 404, 406)
     * @param $data    
     * @return object array (for test) or json (for javascript response)
     */
    public function responseAPI($status, $message, $code, $data = array()) {

        $responseApi = json_encode(array(
            "status" => $status,
            "api" => "$this->class|$this->method",
            "message" => $message,
            "data" => $data
        ));

        if (!$this->is_test) {
            $this->response($responseApi, $code);
        } else {
            return $responseApi;
        }
    }

    public function all() {

        $data = departamentoData::getAll();

        if ($data == true) {
            return $this->responseAPI("success", "get success!", 200, $data);
        }
        return $this->responseAPI("error", "", 200);
    }

// todos los departamentos y sus usuarios
    public function allAndUsers() {

        $data = departamentoData::getDepartmentsAndUsers();

        if ($data == true) {
            return $this->responseAPI("success", "get success!", 200, $data);
        }
        return $this->responseAPI("error", "", 200);
    }

// todos los departamentos y sus usuarios (con metas aprobadas por el Jefe)
    public function allAndUsersMetasAprob() {

        $data = departamentoData::departmentsUsersMetasAprob();

        if ($data == true) {
            return $this->responseAPI("success", "get success!", 200, $data);
        }
        return $this->responseAPI("error", "", 200);
    }

    public function allUsersMetas() {
        if ($this->get_request_method() != "POST") {
            return $this->responseAPI("error", "Not allowed.", 406);
        }
        $body = json_decode(file_get_contents("php://input"), true);
        $id = $body['id'];
        if (array_key_exists("periodo", $body)) {
            $periodo = $body['periodo'];
            $data = departamentoData::departmentUsersMetas($id,$periodo);
            return $this->responseAPI("success", "get success!", 200, $data);
        }else{
            $data = departamentoData::departmentUsersMetasActual($id);
            return $this->responseAPI("success", "get success!", 200, $data);
        }
        return $this->responseAPI("error", "", 200);
    }

// Obtiene todos los departamentos (junto con los usuarios) de un jefe específico.
    public function getUsersDeJefe() {
        if ($this->get_request_method() != "POST") {
            return $this->responseAPI("error", "Not allowed.", 406);
        }
        $body = json_decode(file_get_contents("php://input"), true);
        $data = departamentoData::getUsersFromJefe($body);

        if ($data == true) {
            return $this->responseAPI("success", "get success!", 200, $data);
        }
        return $this->responseAPI("error", "", 200);
    }

// Obtiene todos los departamentos (junto con los usuarios) de un jefe específico, que posean METAS PENDIENTES 
// de aprobar.
//    public function usersDeJefeMetasPendiente() {
//        
//        $body = json_decode(file_get_contents("php://input"), true);
//        $data = departamentoData::usersFromJefeMetasPendientes($body);
//        
//        if($data == true){
//            return $this->responseAPI("success", "get success!", 200, $data);
//        }
//            return $this->responseAPI("error", "", 200);
//    }








    public function add() {

        if ($this->get_request_method() != "POST") {
            return $this->responseAPI("error", "Not allowed.", 406);
        }

        $body = json_decode(file_get_contents("php://input"), true);

        $nombre = $body['nombre'];
        $empresa = $body['empresa'];
        $data = departamentoData::insert($nombre, $empresa['id']);
        if ($data === true) {
            return $this->responseAPI("success", "add success", 200);
        }
        return $this->responseAPI("error", "", 200);
    }

    public function del() {

        if ($this->get_request_method() != "POST") {
            return $this->responseAPI("error", "Not allowed.", 406);
        }

        $body = json_decode(file_get_contents("php://input"), true);

        $id = $body['id'];
        $data = departamentoData::delete($id);
        if ($data === true) {
            return $this->responseAPI("success", "del success", 200);
        }
        return $this->responseAPI("error", "", 200);
    }

    public function set() {

        if ($this->get_request_method() != "PUT") {
            return $this->responseAPI("error", "Not allowed.", 406);
        }

        $body = json_decode(file_get_contents("php://input"), true);

        $nombre = $body['nombre'];
        $id = $body['id'];

        $data = departamentoData::update($nombre, $id);
        if ($data === true) {
            return $this->responseAPI("success", "set success", 200);
        }
        return $this->responseAPI("error", "", 200);
    }

    public function __destruct() {
        return true;
    }

}
